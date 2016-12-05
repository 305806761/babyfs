<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/11/17
 * Time: 15:09
 */

namespace app\models;

use app\models\base\BaseModel;
use Yii;



class TermModel extends BaseModel
{


    public function rules()
    {

        return [
            //[['id'], 'integer', 'min' => 0, 'max' => 2147483647],
            //['id', 'default', 'value' => 0],

            [['section_id'], 'integer', 'min' => 1, 'max' => 2147483647],
            ['section_id', 'default', 'value' => 1],

            [['term' ], 'required'],
            ['term', 'integer', 'min' => 1, 'max' => 2147483647],

            [['start_time' ], 'required'],
            //['expire_time', 'integer', 'min' => 1, 'max' => 2147483647],

            [['end_time'], 'required', ],
            //['create_time', 'integer', 'min' => 1, 'max' => 2147483647],

            [['order_start_time'], 'required', ],

            [['order_end_time'], 'required', ],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE,  self::STATUS_DELETED]],

            ['created_at', 'integer', 'min' => 1, 'max' => 2147483647],
            ['created_at', 'default', 'value' => 0],

            ['updated_at', 'integer', 'min' => 1, 'max' => 2147483647],
            ['updated_at', 'default', 'value' => 0],
        ];
    }
    /**
     * @表名字
     * @return string
     */
    public static function tableName()
    {
        return 'section_term';
    }

    /**
     * @阶段
     * @return \yii\db\ActiveQuery
     */
    public function getStage()
    {
        return $this->hasOne(Section::className(),['section_id' => 'section_id']);
    }

    public function getTerm()
    {
        return $this->hasMany(Section::className(), ['section_id' => 'section_id']);
    }

    public static function getTermNames()
    {
        $temp = self::find()->joinWith(['stage'])->asArray()->all();
        $term = array();
        foreach ($temp as $key=> $value){
            $term[$value['id']] = $value['stage']['name'] .'  |  ' .$value['term'] .'  |  ' .date('Y-m-d',$value['start_time']);
       }
//        echo "<pre>";
//        print_r($term);die;

        return $term;

    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [

            'term' => '学期',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'created_at' => '添加时间',
            'status' => '状态',
            'order_start_time' => '订单开始时间',
            'order_end_time' => '订单结束时间'

        ];
    }
}