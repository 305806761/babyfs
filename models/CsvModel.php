<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/30
 * Time: 下午10:41
 */

namespace app\models;

use Yii;
use app\models\base\BaseModel;

class CsvModel extends BaseModel
{

    public function rules()
    {
        return [

            ['category_id', 'default', 'value' => 0],
            ['category_id', 'integer', 'min' => 0, 'max' => 2147483647],

            ['category_name', 'default', 'value' => ''],
            ['category_name', 'safe'],

            ['order_sn', 'default', 'value' => ''],
            ['order_sn', 'safe'],

            ['subcategory_code', 'default', 'value' => ''],
            ['subcategory_code', 'safe'],

            ['subcategory_name', 'default', 'value' =>''],
            ['subcategory_name', 'safe'],

            ['type', 'default', 'value' => 0],
            ['type', 'integer', 'min' => 0, 'max' => 2147483647],

            ['code', 'required'],
            ['code', 'default', 'value' =>''],
            [['code'], 'string', 'min' => 1, 'max' => 255],

            ['should_pay', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['should_pay' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['should_pay', 'required'],

            ['real_pay', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['real_pay' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['real_pay', 'default', 'value' =>'0'],

            ['all_pay', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['all_pay' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['all_pay', 'required'],

            ['year', 'required'],
            ['year', 'default', 'value' => 0],
            [['year'], 'integer', 'min' => 0, 'max' => 2147483647],

            ['month', 'required'],
            ['month', 'default', 'value' => 0],
            [['month'], 'integer', 'min' => 0, 'max' => 2147483647],

            ['day', 'required'],
            ['day', 'default', 'value' => 0],
            [['day'], 'double', 'min' => 0, 'max' => 2147483647],


            [['order_add_time', 'order_pay_time'], 'default', 'value' => 0],

            ['title', 'required'],
            ['title', 'default', 'value' =>''],
            ['title', 'safe'],


            ['price', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['price' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['price', 'required'],

            ['number', 'required'],
            ['number', 'default', 'value' => 0],
            [['number'], 'integer', 'min' => 1, 'max' => 2147483647],

            ['people_pay', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['people_pay' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['people_pay', 'default', 'value' =>'0'],

            ['alone_money', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['alone_money' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['alone_money', 'default', 'value' =>'0'],

            ['all_money', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['all_money' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['all_money', 'default', 'value' =>'0'],

            ['my_money', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['my_money' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['my_money', 'default', 'value' =>'0'],

            ['surplus_money', 'double', 'min' => 0, 'max' => 999999999999.99],
            [['surplus_money' ], 'match', 'pattern' => '/^[0-9]{0,9}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],
            ['surplus_money', 'default', 'value' =>'0'],

            ['money_type', 'default', 'value' => 0],
            ['money_type', 'integer', 'min' => 0, 'max' => 2147483647],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE,  self::STATUS_DELETED]],

        ];

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'csv_main';
    }

    public function attributeLabels()
    {
        return [
            'category_name' => '组名',
            'subcategory_name' => '买家会员名',
            'title' => '宝贝标题',
            'section_name' => '阶段名称',
            'order_add_time' => '下单时间',
            'code' => '商家编码',
            'course_name' => '课程名称',
            'number' => '数量',
            'all_money' => '总额',
            'alone_money' => '单价',
            'my_money' => '提成',
            'surplus_money' => '实际收益',

        ];
    }


    public function getCourse(){
        return $this->hasOne(Course::className(), ['code' => 'code']);
    }



}