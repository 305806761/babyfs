<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:25
 */

namespace app\modules\admin\controllers;

use app\models\Template;
use app\models\TemplateCode;
use app\models\WareType;
use Handlebars\Handlebars;
use Yii;
use yii\helpers\Html;
use yii\jui\Sortable;
use yii\widgets\ActiveForm;
use yii\web\Controller;
use app\models\Ware;
use app\models\WareSearch;
use yii\web\NotFoundHttpException;

class WareController extends Controller
{
//    public $enableCsrfValidation = false;

    /**
     * 课件列表
     */
    public function actionList()
    {
        $searchModel = new WareSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 添加课件
     * @return mixed
     */
    public function actionAdd()
    {
        $ware = new Ware();

        if (Ware::saveAll($ware)) {
            return $this->redirect(['list']);
        }

        if (Yii::$app->request->post()) {
            if ($ware->load(Yii::$app->request->post()) && $ware->save()) {
                return $this->redirect(['list']);
            }
        }

        return $this->render('update', [
            'model' => $ware,
            'items' => [$this->renderPartial('ware', ['model' => WareType::create()])],
        ]);
    }

    public function actionNewSection()
    {
        $sort = new Sortable([
            'items' => [$this->renderPartial('ware', ['model' => WareType::create()])],
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        return $sort->renderItems();
    }

    /**
     * 修改课件
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $content = [];

        if (Ware::saveAll($model)) {
            return $this->redirect(['list']);
        }

        if ($model->contents) {
            $t = json_decode($model->contents, true);
            foreach ($t as $type_id) {
                if ($wt = WareType::findOne($type_id)) {
                    $content[] = $this->renderPartial('ware', ['model' => $wt]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'items' => $content,
        ]);
    }

    public function actionGetTempInfo($temp_id, $type_id)
    {
        if (!$model = WareType::findOne($type_id)) {
            $model = new WareType();
            $model->type_id = $type_id;
        }
        $model->template_id = $temp_id;
        $form = new ActiveForm();
        $r = [
            'codes' => strval($form->field($model, "[$model->type_id]temp_code_id")->dropDownList(Template::getTempCodes($temp_id))),
            'param' => $this->renderPartial('section', ['model' => $model])
        ];
        return json_encode($r);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $result = '';
        if ($c = json_decode($model->contents, true)) {
            foreach ($c as $type_id) {
                if ($wt = WareType::findOne($type_id)) {
                    if ($template_code = TemplateCode::findOne($wt->temp_code_id)) {
                        $engine = new Handlebars();
                        $result .= $engine->render(
                            $template_code->code,
                            json_decode($wt->content, true)
                        );
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ware the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('课件没有找到');
        }
    }
}