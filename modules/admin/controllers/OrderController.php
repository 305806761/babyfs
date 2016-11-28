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


    public function actionTest(){
        $a = '{"num":3,
"goods_kind":3,
"num_iid":"317186352",
"price":"0.10",
"pic_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/FsjGyglAdtv_ctRyC1lrYQKLbB2_.jpg",
"pic_thumb_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/FsjGyglAdtv_ctRyC1lrYQKLbB2_.jpg?imageView2\/2\/w\/200\/h\/0\/q\/75\/format\/jpg",
"title":"\u82f9\u679c\u5341\u5206\u771f\u7231\u4f53\u9a8c\u8bfe\u3010\u82f1\u6587\u542f\u8499\u96c6\u8bad\u8425\u3011",
"type":"FIXED","discount_fee":"0.00","order_type":"0","status":"WAIT_SELLER_SEND_GOODS",
"status_str":"\u5f85\u53d1\u8d27","refund_state":"NO_REFUND",
"shipping_type":"express","post_fee":"0.00","total_fee":"0.30",
"refunded_fee":"0.00","payment":"0.30","created":"2016-11-26 23:19:01",
"update_time":"2016-11-26 23:19:16","pay_time":"2016-11-26 23:19:16",
"pay_type":"WEIXIN_DAIXIAO","consign_time":"","sign_time":"",
"buyer_area":"\u798f\u5efa\u7701\u8386\u7530\u5e02",
"seller_flag":0,"buyer_message":"",
"orders":[{"oid":17947484,"outer_sku_id":"","outer_item_id":"KP160032",
"title":"\u82f9\u679c\u5341\u5206\u771f\u7231\u4f53\u9a8c\u8bfe\u3010\u82f1\u6587\u542f\u8499\u96c6\u8bad\u8425\u3011",
"seller_nick":"\u5b9d\u5b9d\u73a9\u82f1\u8bed","fenxiao_price":"0.00","fenxiao_payment":"0.00","price":"0.10",
"total_fee":"0.10","payment":"0.10","discount_fee":"0.00","sku_id":"0","sku_unique_code":"",
"sku_properties_name":"","pic_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/FsjGyglAdtv_ctRyC1lrYQKLbB2_.jpg",
"pic_thumb_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/FsjGyglAdtv_ctRyC1lrYQKLbB2_.jpg?imageView2\/2\/w\/200\/h\/0\/q\/75\/format\/jpg",
"item_type":0,"buyer_messages":[],"order_promotion_details":[],"state_str":"\u5f85\u53d1\u8d27","allow_send":1,
"is_send":0,"item_refund_state":"","is_virtual":0,"is_present":0,"refunded_fee":"0.00",
"unit":"\u4ef6","num_iid":"317186352","num":"1"},
{"oid":17947485,"outer_sku_id":"","outer_item_id":"KC160031",
"title":"\u8349\u8393\u5341\u5206\u771f\u7231\u4f53\u9a8c\u8bfe\u3010\u82f1\u6587\u542f\u8499\u96c6\u8bad\u8425\u3011",
"seller_nick":"\u5b9d\u5b9d\u73a9\u82f1\u8bed","fenxiao_price":"0.00","fenxiao_payment":"0.00","price":"0.10",
"total_fee":"0.10","payment":"0.10","discount_fee":"0.00","sku_id":"0","sku_unique_code":"","sku_properties_name":"",
"pic_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/Fu1WHu8Ug35GicWVh1d6QgQobgU2.jpg",
"pic_thumb_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/Fu1WHu8Ug35GicWVh1d6QgQobgU2.jpg?imageView2\/2\/w\/200\/h\/0\/q\/75\/format\/jpg",
"item_type":0,
"buyer_messages":[],"order_promotion_details":[],
"state_str":"\u5f85\u53d1\u8d27","allow_send":1,"is_send":0,"item_refund_state":"",
"is_virtual":0,"is_present":0,"refunded_fee":"0.00","unit":"\u4ef6","num_iid":"317137576","num":"1"},
{"oid":17947486,"outer_sku_id":"","outer_item_id":"KY160030",
"title":"\u6a31\u6843\u5341\u5206\u771f\u7231\u4f53\u9a8c\u8bfe\u3010\u82f1\u6587\u542f\u8499\u96c6\u8bad\u8425\u3011",
"seller_nick":"\u5b9d\u5b9d\u73a9\u82f1\u8bed","fenxiao_price":"0.00","fenxiao_payment":"0.00",
"price":"0.10","total_fee":"0.10","payment":"0.10","discount_fee":"0.00","sku_id":"0",
"sku_unique_code":"",
"sku_properties_name":"","pic_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/FrZd2iDucQ1aSueXJO9PxHiPtPP2.jpg",
"pic_thumb_path":"https:\/\/img.yzcdn.cn\/upload_files\/2016\/11\/25\/FrZd2iDucQ1aSueXJO9PxHiPtPP2.jpg?imageView2\/2\/w\/200\/h\/0\/q\/75\/format\/jpg",
"item_type":0,"buyer_messages":[],"order_promotion_details":[],"state_str":"\u5f85\u53d1\u8d27","allow_send":1,"is_send":0,
"item_refund_state":"","is_virtual":0,"is_present":0,"refunded_fee":"0.00","unit":"\u4ef6","num_iid":"317182356","num":"1"}],
"fetch_detail":null,"coupon_details":[],"promotion_details":[],"adjust_fee":{"change":"0.00","pay_change":"0.00","post_change":"0.00"},
"sub_trades":[],
"weixin_user_id":"0","button_list":[{"tool_icon":"http:\/\/imgqn.koudaitong.com\/upload_files\/2015\/08\/28\/FpFY_MeJXzLCA3lwIV6br6qUbClv.png",
"tool_title":"\u53d1\u8d27","tool_value":"","tool_type":"goto_native:trade_send_goods","tool_parameter":"{}",
"new_sign":"0","create_time":""},{"tool_icon":"http:\/\/imgqn.koudaitong.com\/upload_files\/2015\/08\/28\/FpO1UIXyOEZO026tWIgUOm9uZnT2.png",
"tool_title":"\u5907\u6ce8","tool_value":"","tool_type":"goto_native:trade_memo","tool_parameter":"{}","new_sign":"0","create_time":""}],
"feedback_num":0,"trade_memo":"","fans_info":{"fans_nickname":"\u9b4f\u6797\u5a1c","fans_id":"735075439","buyer_id":"289828125","fans_type":"9"}
,"buy_way_str":"","pf_buy_way_str":"\u8fd0\u8d39\u5230\u4ed8","send_num":0,"user_id":"289828125","kind":3,"relation_type":"","relations":[],
"out_trade_no":[],"group_no":"","outer_user_id":0,"shop_id":"15657969","shop_type":"1","points_price":0,"delivery_start_time":0,"delivery_end_time":0,
"tuan_no":"","delivery_time_display":"","hotel_info":"","buyer_nick":"\u9b4f\u6797\u5a1c",
"tid":"E20161126231901028572283",
"buyer_type":"9",
"buyer_id":"735075439","receiver_city":"\u8386\u7530\u5e02","receiver_district":"\u4ed9\u6e38\u53bf","receiver_name":"\u9b4f\u6797\u5a1c",
"receiver_state":"\u798f\u5efa\u7701","receiver_address":"\u699c\u5934\u9547\u4e5d\u9ca4\u4e2d\u8857651\u53f7\u5ed6\u5e86\u68ee\u8bca\u6240\u65c1\u5df7\u5b50",
"receiver_zip":"","receiver_mobile":"18629342944","feedback":0,"outer_tid":"100580015724201611267018882734"}';

        $array = json_decode($a,true);
        $ordernew = new Order();
        $ordernew->AddOrder($array);
    }

}