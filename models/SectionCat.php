<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/31
 * Time: 19:30
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "section_cat".
 *
 * @property integer $id
 * @property integer $section_id
 * @property string $cat_name
 * @property string $created
 *
 * @property CourseSection $section
 */
class SectionCat extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section_cat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'cat_name'], 'required'],
            [['section_id'], 'integer'],
            [['created'], 'safe'],
            [['cat_name'], 'string', 'max' => 100],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => CourseSection::className(), 'targetAttribute' => ['section_id' => 'section_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '段落ID',
            'section_id' => '阶段ID',
            'cat_name' => '段落名字',
            'created' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(CourseSection::className(), ['section_id' => 'section_id']);
    }

    public static function add($param)
    {
        $sectioncat = self::getById($param['id']);
        $sectioncat->section_id = $param['section_id'] ? $param['section_id'] : $sectioncat->section_id;
        $sectioncat->cat_name = $param['cat_name'] ? $param['cat_name'] : $sectioncat->cat_name;

        $cat_id = 0;
        if ($sectioncat->save()) {
            $cat_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $sectioncat->id;
        }
        return $cat_id;
    }

    public static function getById($id)
    {

        if (!$section_cat = self::findOne($id)) {
            $section_cat = new SectionCat();
        }
        return $section_cat;

    }

    public function getList()
    {
        $sql = "select cs.name as section_name,sc.cat_name,sc.id as section_cat_id from section_cat as sc left join course_section as cs on sc.section_id = cs.section_id";
        return Yii::$app->db->createCommand($sql)->queryAll();
        //return $this->hasMany(CourseSection::className(), ['section_id' => 'section_id']);
    }
}