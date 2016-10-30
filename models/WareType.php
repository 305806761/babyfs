<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ware_type".
 *
 * @property integer $type_id
 * @property integer $template_id
 * @property integer $temp_code_id
 * @property string $content
 * @property string $created
 *
 * @property Template $template
 * @property TemplateCode $tempCode
 */
class WareType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ware_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'temp_code_id'], 'integer'],
            [['temp_code_id', 'content'], 'required'],
            [['created'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'template_id']],
            [['temp_code_id'], 'exist', 'skipOnError' => true, 'targetClass' => TemplateCode::className(), 'targetAttribute' => ['temp_code_id' => 'temp_code_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'template_id' => '课件模板id',
            'temp_code_id' => '课件模板style',
            'content' => '课件内容',
            'created' => '创建时间',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(Template::className(), ['template_id' => 'template_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTempCode()
    {
        return $this->hasOne(TemplateCode::className(), ['temp_code_id' => 'temp_code_id']);
    }
}
