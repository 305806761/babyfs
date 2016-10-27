<?php

namespace app\controllers;

use Yii;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionNew()
    {
        Yii::$app->request->bodyParams;
        return '{"code":0,"msg":"success"}';
    }
}
