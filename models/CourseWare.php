<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course_ware".
 *
 * @property integer $id
 * @property integer $section_cat_id
 * @property integer $version
 * @property integer $ware_id
 * @property integer $sort
 * @property string $created
 *
 * @property Ware $ware
 * @property SectionCat $sectionCat
 */
class CourseWare extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_ware';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_cat_id', 'ware_id'], 'required'],
            [['section_cat_id', 'version', 'ware_id', 'sort'], 'integer'],
            [['created'], 'safe'],
            [['ware_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ware::className(), 'targetAttribute' => ['ware_id' => 'ware_id']],
            [['section_cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => SectionCat::className(), 'targetAttribute' => ['section_cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '课程课件关联',
            'section_cat_id' => '课程阶段分组id',
            'version' => '版本',
            'ware_id' => '课件id',
            'sort' => '排序',
            'created' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWare()
    {
        return $this->hasOne(Ware::className(), ['ware_id' => 'ware_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSectionCat()
    {
        return $this->hasOne(SectionCat::className(), ['id' => 'section_cat_id']);
    }
}
