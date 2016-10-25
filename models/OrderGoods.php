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
        $this->goods_number = $param['num'];
        $this->fenxiao_price = $param['fenxiao_price'];
        $this->price = $param['price'];
        $this->fenxiao_payment = $param['fenxiao_payment'];
        $this->total_fee = $param['total_fee'];
        $this->payment = $param['payment'];
        $this->refunded_fee = $param['refunded_fee'];
        $this->state_str = $param['state_str'];
        $this->item_refund_state = $param['item_refund_state'];
        $rec_id  = self::save() ? Yii::$app->db->lastInsertID : '';
        return $rec_id;
    }
}