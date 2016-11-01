<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/17
 * Time: 19:14
 */


namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template_code".
 *
 * @property integer $temp_code_id
 * @property integer $template_id
 * @property string $code
 * @property string $created
 *
 * @property Template $template
 * @property WareType[] $wareTypes
 */
class TemplateCode extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'code'], 'required'],
            [['template_id'], 'integer'],
            [['code'], 'string'],
            [['created'], 'safe'],
            [['template_id'], 'exist', 'skipOnError' => true, 'targetClass' => Template::className(), 'targetAttribute' => ['template_id' => 'template_id']],
        ];
    }

    public function add($param)
    {
        $template_code = self::getTempCodeById($param['temp_code_id']);
        $template_code->template_id = $param['template_id'];
        $template_code->code = $param['code'];
        //  var_dump($user);die;
        //用户信息插入数据库

        if ($template_code->save()) {
            $temp_code_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $template_code->temp_code_id;
        }


        return $temp_code_id ? $temp_code_id : false;

    }

    public static function getTempCodeById($temp_code_id)
    {

        if (!$temp_code_id) {
            $template_code = new TemplateCode();
        }
        if (!$template_code = self::findOne($temp_code_id)) {
            $template_code = new TemplateCode();
        }
        return $template_code;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'temp_code_id' => 'Temp Code ID',
            'template_id' => 'Template ID',
            'code' => 'Code',
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
    public function getWareTypes()
    {
        return $this->hasMany(WareType::className(), ['temp_code_id' => 'temp_code_id']);
    }
}