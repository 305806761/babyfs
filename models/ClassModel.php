<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/14
 * Time: 下午4:38
 */

namespace app\models;


use app\models\base\BaseModel;

class ClassModel extends BaseModel
{

    public static function tableName()
    {
        return 'class';
    }


    public function rules()
    {

        return [

            ['name', 'required'],
            ['name', 'string', 'min' => 1, 'max' => 65535],
            ['name', 'unique'],

            ['price', 'double', 'min' => 1, 'max' => 999999999999.99],
            ['price', 'match', 'pattern' => '/^[1-9][0-9]{0,11}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['price', 'required'],

            [['name'], 'safe'],

            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE]],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],

            ['order_sort', 'integer', 'min' => 0, 'max' => 4294967295],
            ['order_sort', 'default', 'value' => 0],

        ];

    }

    public function attributeLabels()
    {

        return [
            'name' => '名称',
            'created_at' => '添加时间',
            'price' => '价格',
            'status' => '状态',
            'order_sort' => '排序',

        ];
    }
}