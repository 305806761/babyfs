<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:26
 */

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "ware".
 *
 * @property integer $ware_id
 * @property string $title
 * @property string $small_text
 * @property string $contents
 * @property string $create_time
 *
 * @property CourseWare[] $courseWares
 */
class Ware extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'small_text'], 'required'],
            [['create_time'], 'safe'],
            [['title'], 'string', 'max' => 150],
            [['small_text'], 'string', 'max' => 255],
            [['contents'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ware_id' => '课件ID',
            'title' => '课件名称',
            'small_text' => '课件简介',
            'contents' => '课件内容',
            'create_time' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseWares()
    {
        return $this->hasMany(CourseWare::className(), ['ware_id' => 'ware_id']);
    }
}