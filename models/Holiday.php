<?php

namespace app\models;

use app\models\base\BaseModel;
use Yii;

/**
 * This is the model class for table "holiday".
 *
 * @property integer $id
 * @property string $day
 * @property integer $type
 * @property string $ctime
 */
class Holiday extends BaseModel
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
            ['type', 'required'],
            ['type', 'integer', 'min' => 1, 'max' => 4294967295],
            ['type','default', 'value' => 1],

            //['day', 'string', 'max' => 255],
            //['day', 'default', 'value' => 0],

            //['term_ids', 'required'],
            ['term_id', 'string', 'max' => 255],
            ['term_id','default', 'value' => ''],

            [['start_time', 'end_time', 'term_id', 'day'], 'safe'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_time' => '开始日期',
            'end_time' => '结束日期',
            'type' => '类型',
            'term_id'=> '学期ID',
//            'created_at' => '创建时间',
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
