<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/1
 * Time: 下午3:32
 */

namespace app\models;


use app\models\base\BaseModel;

class GroupModel extends BaseModel
{

    public function rules()
    {
        return [

            ['name', 'default', 'value' =>''],
            [['name'], 'string', 'min' => 0, 'max' => 255],

            ['code', 'default', 'value' =>''],
            [['code'], 'string', 'min' => 0, 'max' => 255],

            ['wx_name', 'default', 'value' =>''],
            [['wx_name'], 'string', 'min' => 0, 'max' => 255],

            ['leader', 'default', 'value' =>''],
            [['leader'], 'string', 'min' => 0, 'max' => 255],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE,  self::STATUS_DELETED]],

        ];

    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'csv_group';
    }

    public function attributeLabels()
    {
        return [

        ];
    }



}