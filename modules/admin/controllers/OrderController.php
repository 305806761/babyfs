<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/21
 * Time: 15:59
 */

namespace app\modules\admin\controllers;
use app\models\lib\KdtApiClient;
use app\models\OrderGoods;
use Yii;
use yii\web\Controller;
use app\models\Order;

class OrderController extends Controller
{
    public function actionIndex(){
        $ordernew = new Order();
        date_default_timezone_set('PRC');

        $appId = '125ec687338926758c';
        $appSecret = '00bf023ac1dc1f20d1e63f9275eb862f';
        $client = new KdtApiClient($appId, $appSecret);

        //$method = 'kdt.trade.get';
        $method = 'kdt.trades.sold.get';
        $create = date('Y-m-d H:i:s',time()-7200);
        $end = date('Y-m-d H:i:s');
//echo $create ."<br />".$end;die;
//$start_created = date_create($time);
//$end_created = date_create(time());
//$params = [
//    'tid' => 'E20161024122620127828788' ,
//    'fields' => 'tid,title,receiver_city,outer_tid,orders',
//];
        $params = [
            // 'use_has_next' => false ,
            'start_created' => $create,
            'end_created' => $end,
        ];
        $result = $client->post($method,$params);
        //print_r($result['response']['trades']);die;
        foreach ($result['response']['trades'] as $order){

            $ordernew->AddOrder($order);
        }

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }

}