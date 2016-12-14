<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/14
 * Time: 下午4:37
 */

namespace app\modules\admin\controllers;

use app\models\ClassModel;
use app\models\search\ClassSearchModel;
use yii\web\Controller;
use Yii;
class ClassController extends Controller
{



    public function actionIndex(){

        $model = new ClassSearchModel();
        $dataProvider = $model->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'searchModel' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * @return string|\yii\web\Response
     * @添加
     */
    public function actionCreate(){
        $model = new ClassModel();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }



}