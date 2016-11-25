<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/25
 * Time: 上午11:31
 */

namespace app\models;


use app\models\base\BaseModel;

class BabyOneModel extends BaseModel
{


    /**
     * @return string
     */
    public static function tableName()
    {
        return 'baby_one';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['age'],'required'],
            [['age'],'safe'],
            ['age', 'string', 'min' => 1, 'max' => 128],

            [['area'],'required'],
            [['area'],'safe'],
            ['area', 'string', 'min' => 1, 'max' => 128],

            [['type' ], 'integer'],
            ['type', 'integer', 'min' => 0, 'max' => 255],
            ['type', 'default', 'value' => 0],

            [['one' ], 'integer'],
            ['one', 'integer', 'min' => 0, 'max' => 255],
            ['one', 'default', 'value' => 0],

            [['two' ], 'integer'],
            ['two', 'integer', 'min' => 0, 'max' => 255],
            ['two', 'default', 'value' => 0],

            [['three' ], 'integer'],
            ['three', 'integer', 'min' => 0, 'max' => 255],
            ['three', 'default', 'value' => 0],

            ['order_sort', 'default', 'value' => 0],
            ['order_sort', 'integer', 'min' => -2147483648, 'max' => 2147483647],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE,  self::STATUS_DELETED]],

        ];
    }
}