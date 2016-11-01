<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/17
 * Time: 14:06
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "template".
 *
 * @property integer $template_id
 * @property string $type
 * @property string $param
 * @property string $created
 *
 * @property TemplateCode[] $templateCodes
 * @property WareType[] $wareTypes
 */
class Template extends ActiveRecord
{
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['created'], 'safe'],
            [['type'], 'string', 'max' => 20],
            [['param'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'template_id' => '模板ID',
            'type' => '名字',
            'param' => '参数',
            'created' => '创建时间',
        ];
    }

    /**
     *
     * 获取所有模板类型
     */
    public static function getTemp()
    {
        $temp = self::find()
            ->select(['type', 'template_id','param'])//查找字段
            //->where(['is_free' => $is_free]) //查找条件
            ->indexBy('template_id')//course_id 为key
            ->asArray()//查找结果以course_id 为key  ,name:为值
            ->all();
        return $temp;

    }

    /**
     *
     * 获取所有模板类型
     */
    public static function getTempNames()
    {
        $temp = self::find()
            ->select(['type', 'template_id'])//查找字段
            //->where(['is_free' => $is_free]) //查找条件
            ->indexBy('template_id')//course_id 为key
            ->asArray()//查找结果以course_id 为key  ,name:为值
            ->column();
        return $temp;

    }

    /**
     * 添加模板code
     **/

    public function add($param)
    {

        $templatecode = new TemplateCode();

        $result = $templatecode->add($param);

        return $result;
    }

    public static function getBigTemplate($temp_code_id = null)
    {
        $where = $temp_code_id ? " where c.temp_code_id = $temp_code_id" : '';
        $sql = "SELECT t.type,t.template_id,t.param,c.code,c.temp_code_id FROM `template_code` AS c LEFT JOIN `template` AS t ON c.template_id = t.template_id" . $where;
        //echo $sql;die;
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        return $result;
    }

    static public function getTypeByid($template_id)
    {
        if (!$template_id) {
            $template = new Template();
        }
        if (!$template = self::findOne($template_id)) {
            $template = new Template();
        }
        return $template;
    }

    /***
     * 添加模板分类
     ***/
    static public function addType($params)
    {
        $template = Template::getTypeByid($params['template_id']);
        //var_dump($template);die;
        $template->type = $params['type'] ? $params['type'] : $template->type;
        $template->param = $params['param'] ? $params['param'] : '';

        if ($template->save()) {
            $template_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $template->template_id;
        }
        return $template_id;
    }

    /**
     * 获取所有模板代码
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateCodes()
    {
        return $this->hasMany(TemplateCode::className(), ['template_id' => 'template_id']);
    }

    public static function getTempCodes($id)
    {
        $temp = TemplateCode::find()
            ->select(['temp_code_id'])//查找字段
            ->where(['template_id' => $id]) //查找条件
            ->indexBy('temp_code_id')//course_id 为key
            ->asArray()//查找结果以course_id 为key  ,name:为值
            ->column();
        return $temp;

    }
}