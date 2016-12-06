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
            ['name', 'safe'],

            ['code', 'default', 'value' =>''],
            ['code', 'safe'],

            ['wx_name', 'default', 'value' =>''],
            ['wx_name', 'safe'],

            ['leader', 'default', 'value' =>''],
            ['leader', 'safe'],

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