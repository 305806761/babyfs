<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/13
 * Time: 下午2:44
 */

namespace app\models;


use app\models\base\BaseModel;

class CardModel extends BaseModel
{

    public $number;
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
            ['number', 'required'],
            ['number', 'integer', 'min' => 1, 'max' => 4294967295],
            ['number','default', 'value' => 1],

            ['code', 'required'],
            ['code', 'string', 'min' => 1, 'max' => 65535],
            ['code', 'unique'],

            ['password', 'required'],
            ['password', 'string', 'min' => 1, 'max' => 65535],
            ['password', 'unique'],

            [['code', 'password'], 'safe'],

            ['user_id', 'integer', 'min' => 0, 'max' => 4294967295],
            ['user_id', 'default', 'value' => 0],

            ['is_active', 'integer', 'min' => 0, 'max' => 255],
            ['is_active','default', 'value' => ''],

            ['is_useable', 'integer', 'min' => 0, 'max' => 255],
            ['is_useable', 'default', 'value' => ''],

            ['is_used', 'integer', 'min' => 0, 'max' => 255],
            ['is_used', 'default', 'value' => ''],

            ['is_cancel', 'integer', 'min' => 0, 'max' => 255],
            ['is_cancel', 'default', 'value' => ''],

            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],

            ['order_sort', 'integer', 'min' => 0, 'max' => 4294967295],
            ['order_sort', 'default', 'value' => 0],

            ['expired_at', 'integer', 'min' => 0, 'max' => 4294967295],
            ['expired_at', 'default', 'value' => 0],
        ];
    }




    public function attributeLabels()
    {
        return [
            'code' => '卡号',
            'password' => '密码',
            'number' => '数量',
        ];
    }


}