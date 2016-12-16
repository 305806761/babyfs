<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/13
 * Time: 下午2:44
 */

namespace app\models;


use app\models\base\BaseModel;
use yii\helpers\ArrayHelper;

class CardModel extends BaseModel
{

    public $number;
    public $card_sn;
    public $start_code;
    public $end_code;
    public $state = array(

    );


    public static function getCancel(){
        return [
            '-1' => '未作废',
            '1' => '已作废',
        ];
    }
    public static function getCancelAll(){
        return ArrayHelper::merge([0 => '全部'], self::getCancel());

    }

    public static function getUsed(){
        return [
            '-1' => '未使用过',
            '1' => '使用过',
        ];
    }
    public static function getUsedAll(){
        return ArrayHelper::merge([0 => '全部'], self::getUsed());

    }
    public static function getUseable(){
        return [
            '-1' => '不可用',
            '1' => '可用',
        ];
    }
    public static function getUseableAll(){
        return ArrayHelper::merge([0 => '全部'], self::getUseable());

    }
    public static function getActive(){
        return [
            '-1' => '未激活',
            '1' => '已激活',
        ];
    }
    public static function getActiveAll(){
        return ArrayHelper::merge([0 => '全部'], self::getActive());

    }
    /**
     * @return string
     * @基础词汇卡表
     */
    public static function tableName()
    {
        return 'card';
    }

    /**
     * @return array
     * @规则
     */
    public function rules()
    {
        return [
            ['number', 'required', 'on' => 'create'],
            ['number', 'integer', 'min' => 1, 'max' => 4294967295],
            ['number','default', 'value' => 0],

            ['card_sn', 'required', 'on' => 'create'],
            ['card_sn', 'match', 'pattern' => '/^[1-9]{1}[0-9]{7}$/', 'on' => 'create'],
            ['card_sn', 'integer', 'min' => 10000000, 'max' => 99999999],

            ['code', 'required', 'on' => 'create'],
            ['code', 'string', 'min' => 1, 'max' => 65535],
            ['code', 'unique', 'on' => 'create'],

            ['start_code', 'required', 'on' => 'activate'],
            ['start_code', 'match', 'pattern' => '/^[1-9]{1}[0-9]{15}$/', 'on' => 'activate'],

            ['end_code', 'required', 'on' => 'activate'],
            ['end_code', 'match', 'pattern' => '/^[1-9]{1}[0-9]{15}$/', 'on' => 'activate'],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 1, 'max' => 65535],
            ['password', 'unique', 'on' => 'create'],

            [['code', 'password', 'start_code', 'end_code'], 'safe'],


            ['user_id', 'integer', 'min' => 0, 'max' => 4294967295],
            ['user_id', 'default', 'value' => 0],

            ['class_id', 'required', 'on' => 'activate'],
            ['class_id', 'integer', 'min' => 0, 'max' => 4294967295],
            ['class_id', 'default', 'value' => 0],

            ['is_active', 'integer', 'min' => -128, 'max' => 127],
            ['is_active','default', 'value' => -1],

            ['is_useable', 'integer', 'min' => -128, 'max' => 127],
            ['is_useable', 'default', 'value' => 1],

            ['is_used', 'integer', 'min' => -128, 'max' => 127],
            ['is_used', 'default', 'value' => -1],

            ['is_cancel', 'integer', 'min' => -128, 'max' => 127],
            ['is_cancel', 'default', 'value' => -1],

            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],

            ['order_sort', 'integer', 'min' => 0, 'max' => 4294967295],
            ['order_sort', 'default', 'value' => 0],

            ['expired_at', 'safe'],
            ['expired_at', 'required', 'on' => 'activate'],
            [['expired_at'], 'default', 'value' => 0],
        ];
    }




    public function attributeLabels()
    {
        return [
            'code' => '卡号',
            'password' => '密码',
            'number' => '数量',
            'card_sn' => '前缀',
            'class_id' => '课',
            'start_code' => '起始卡段',
            'end_code' => '结束卡段',
            'expired_at' => '截止日期',
            'is_active' => '是否激活',
            'is_useable' => '是否可用',
            'is_used' => '是否使用',
            'is_cancel' => '是否作废',
            'status' => '状态',

        ];
    }


    public function getDada(){
        return $this->hasOne(ClassModel::className(), ['id' => 'class_id']);
    }

    public function getUsers(){
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @param $code
     * @param $password
     * @param int $status
     * @ 1是绑定手机号(激活可用)，2是激活卡号，3作废，4已使用
     */
    public static function getCardStatus($code, $password ,$status=1){
        $model = new CardModel();
        $model->code = $code;
        $model->password = $password;
        if ($model->code && $model->password) {
            $cardInfo = CardModel::findOne(['code' => $model->code, 'password' => $model->password]);
            if($cardInfo){
                if ($status == 1) {
                    if($cardInfo->is_useable ==1 && $cardInfo->is_used == -1 && $cardInfo->is_active == 1 && $cardInfo->is_cancel == -1) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

}