<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:25
 */

namespace app\modules\admin\controllers;

use app\models\Template;
use app\models\WareType;
use Yii;
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
        $content = [];

        if (Yii::$app->request->post()) {
            if ($ware->load(Yii::$app->request->post()) && $ware->save()) {
                return $this->redirect(['list']);
            }
        }

        if (true) {
            $t = json_decode('[1,2]', true);
            foreach ($t as $type_id) {
                $wt = WareType::findOne($type_id);
                $content[] = $this->renderPartial('ware', ['model' => $wt]);
            }
        }

        return $this->render('add', [
            'model' => $ware,
            'items' => $content,
        ]);
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

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['list']);
            }
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

    public function actionGetTempCodes($temp_id, $type_id)
    {
        $model = WareType::findOne($type_id);
        $form = new ActiveForm();
        return $form->field($model, "[$model->type_id]temp_code_id")->dropDownList(Template::getTempCodes($temp_id));
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