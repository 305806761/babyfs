<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:25
 */

namespace app\modules\admin\controllers;

use app\models\WareType;
use Yii;
use yii\web\Controller;
use app\models\Ware;
use app\models\WareSearch;

class WareController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 课程列表
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
     * 添加课程
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
}