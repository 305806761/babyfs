<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/24
 * Time: 17:07
 */

namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class OrderGoods extends ActiveRecord
{

    public function AddOrderGoods($param){

        $this->order_sn = $param['order_sn'];
        $this->order_id = $param['order_id'];
        $this->code = $param['outer_item_id'];
        $this->goods_name = $param['title'];
        $this->goods_number = $param['num'] ? $param['num'] : '1';
        $this->fenxiao_price = $param['fenxiao_price'] ? $param['fenxiao_price'] : '0.00';
        $this->price = $param['price'] ? $param['price'] : '0.00';
        $this->fenxiao_payment = $param['fenxiao_payment'] ? $param['fenxiao_payment'] : '0.00';
        $this->total_fee = $param['total_fee'] ? $param['total_fee'] : '0.00';
        $this->payment = $param['payment'] ? $param['payment'] : '0.00';
        $this->refunded_fee = $param['refunded_fee'] ? $param['refunded_fee'] : '0.00';
        $this->state_str = $param['state_str'] ? $param['state_str'] : '已付款';
        $this->item_refund_state = $param['item_refund_state'] ? $param['item_refund_state'] : 'NO_REFUND';
        $rec_id  = self::save() ? Yii::$app->db->lastInsertID : '';
        return $rec_id;
    }
}