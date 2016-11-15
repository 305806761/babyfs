<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/21
 * Time: 15:59
 */

namespace app\modules\admin\controllers;

use app\models\OrderGoods;
use Yii;
use yii\web\Controller;
use app\models\Order;

class OrderController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $order = new Order();
        if(Yii::$app->request->post()){
            $order_sn = Yii::$app->request->post('order_sn');
            $mobile = Yii::$app->request->post('mobile');
            $orders = $order->getInfo($order_sn,$mobile);
        }else{
            $orders = $order->getInfo();
        }
        //print_r($orders);die;
        return $this->render('list',['orders'=>$orders]);
    }

}