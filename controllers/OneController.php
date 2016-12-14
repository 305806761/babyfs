<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 下午6:29
 */

namespace app\controllers;

use app\models\WechatModel;
use yii;
use yii\web\Controller;

class OneController extends Controller
{
    public $layout = 'one';
    public function actionIndex()
    {

        $model = WechatModel::findOne(4);
//        print_r($model);
//        die;
        return $this->render('/one/index', [
            'model' => $model,
        ]);

    }

}