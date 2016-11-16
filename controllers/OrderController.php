<?php

namespace app\controllers;

use app\models\Tool;
use Yii;
use app\models\Order;

class OrderController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionNew()
    {
        $param = Yii::$app->request->bodyParams;
        //Yii::warning(json_encode($param));
        if (
            isset($param['test']) &&
            $param['test'] == false &&
            $param['sign'] == md5(Yii::$app->params['youzan_appid'] . $param['msg'] . Yii::$app->params['youzan_secret']) &&
            $param['status'] == 'WAIT_SELLER_SEND_GOODS' &&
            $param['mode'] == 0 &&
            $param['type'] == 'TRADE'
        ) {
            $youzan_id = $param['id'];
            $msg = json_decode(urldecode($param['msg']),true);
            $ordernew = new Order();
            $ordernew->AddOrder($msg['trade']);
        }
        return '{"code":0,"msg":"success"}';
    }
}
