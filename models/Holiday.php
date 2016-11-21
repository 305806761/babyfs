<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "holiday".
 *
 * @property integer $id
 * @property string $day
 * @property integer $type
 * @property string $ctime
 */
class Holiday extends \yii\db\ActiveRecord
{
    const TYPE_HOLIDAY = 1;
    const TYPE_SCHOOL_DAY = 2;

    public static $types = [
        self::TYPE_HOLIDAY => '假期',
        self::TYPE_SCHOOL_DAY => '上学日',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'holiday';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'ctime'], 'safe'],
            [['type'], 'integer'],
            [['term_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'day' => '日期',
            'type' => '类型',
            'term_id'=> '学期ID',
            'ctime' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getSectionTerm()
    {
        $sql = "select s.name,st.id,st.term,st.start_time from section_term as st left join section as s on st.section_id = s.section_id";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($result as $value){
            $section[$value['id']] = $value['name'] .' | '.date('Y-m-d',$value['start_time']);
        }
        return $section;
    }
}
