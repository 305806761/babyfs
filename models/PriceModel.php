<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/1
 * Time: 下午7:30
 */

namespace app\models;


use app\models\base\BaseModel;

class PriceModel extends BaseModel
{


    public function rules()
    {
        return [


            ['type', 'default', 'value' => 0],
            ['type', 'integer', 'min' => 0, 'max' => 2147483647],

            ['property', 'default', 'value' => ''],
            ['property', 'string', 'min' => 0, 'max' => 255],

            ['code_rule', 'default', 'value' => ''],
            ['code_rule', 'string', 'min' => 0, 'max' => 255],

            ['code', 'default', 'value' =>''],
            [['code'], 'string', 'min' => 0, 'max' => 255],

            ['class_property', 'default', 'value' =>''],
            [['class_property'], 'string', 'min' => 0, 'max' => 255],

            ['name', 'default', 'value' =>''],
            [['name'], 'string', 'min' => 0, 'max' => 255],

            [['property', 'code', 'class_property', 'name', 'up_time'], 'safe'],

            ['price', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['price' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['price', 'default', 'value' =>'0'],

            ['up_time', 'default', 'value' =>''],
            [['up_time'], 'string', 'min' => 0, 'max' => 255],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE,  self::STATUS_DELETED]],

        ];
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'csv_price';
    }



}