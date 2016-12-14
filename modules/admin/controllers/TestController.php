<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 上午11:34
 */

namespace app\modules\admin\controllers;
use app\models\lib\KdtApiClient;
use Yii;
use yii\web\Controller;

class TestController extends Controller
{
    public function actionIndex(){
        //$ordernew = new Order();
        date_default_timezone_set('PRC');

        $appId = '125ec687338926758c';
        $appSecret = '00bf023ac1dc1f20d1e63f9275eb862f';
        $client = new KdtApiClient($appId, $appSecret);

        //$method = 'kdt.trade.get';
//        $method = 'kdt.trades.sold.get';
        $method = 'kdt.trade.get';
        $create = date('Y-m-d H:i:s',time()-7200);
        $end = date('Y-m-d H:i:s');
//echo $create ."<br />".$end;die;
//$start_created = date_create($time);
//$end_created = date_create(time());
//$params = [
//    'tid' => 'E20161024122620127828788' ,
//    'fields' => 'tid,title,receiver_city,outer_tid,orders',
////];
//        $params = [
//            // 'use_has_next' => false ,
//            'start_created' => $create,
//            'end_created' => $end,
//        ];
        $params = [
            'tid'=>'E20161208101159141338749',// String 是 E123456 交易编号
            'sub_trade_page_size'=>'5',// Number 否 500 指定获取子交易每页条数，不传则获取全部，上限500
            'sub_trade_page_no'=>'1',// Number 否 1 指定获取子交易的第几页，不传则获取全部
            //'fields'=>'refund_state,title,num_iid,outer_tid,status,consign_time,type,buyer_id',
        ];
        $result = $client->post($method,$params);
        //print_r($result['response']['trades']);die;

        echo "<pre>";
        print_r($result['response']['trade']);
        die;

        //TRADE_NO_CREATE_PAY (没有创建支付交易)
        //WAIT_BUYER_PAY (等待买家付款)
        //WAIT_PAY_RETURN (等待支付确认)
        //WAIT_GROUP（等待成团，即：买家已付款，等待成团）
        //WAIT_SELLER_SEND_GOODS (等待卖家发货，即：买家已付款)
        //WAIT_BUYER_CONFIRM_GOODS (等待买家确认收货，即：卖家已发货)
        //TRADE_BUYER_SIGNED (买家已签收)
        //TRADE_CLOSED (付款以后用户退款成功，交易自动关闭)
        //TRADE_CLOSED_BY_USER (付款以前，卖家或买家主动关闭交易)
        //foreach ($result['response']['trades'] as $order){


          //  print_r($order);
            //$ordernew->AddOrder($order);
        //}

//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';
    }

}