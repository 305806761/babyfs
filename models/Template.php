<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/17
 * Time: 14:06
 */

namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Template extends ActiveRecord
{
    /**
     *
     * 获取所有模板类型
     */

    public static function getTemp()
    {
        $temp = self::find()
            ->select(['type', 'template_id'])  //查找字段
            //->where(['is_free' => $is_free]) //查找条件
            ->indexBy('template_id') //course_id 为key
            ->asArray() //查找结果以course_id 为key  ,name:为值
            ->column();
        return $temp;

    }

    /**
     * 添加模板code
     **/

    public function  add($param){
        $templatecode = new TemplateCode();

        $result = $templatecode->add($param);

        return $result;
    }

    public static function getBigTemplate()
    {
        $sql = "SELECT t.type,c.code,c.temp_code_id FROM `template_code` AS c LEFT JOIN `template` AS t ON c.template_id = t.template_id";
        $result = Yii::$app->db->createCommand($sql)->queryAll();
        return $result;
    }
    /***
     * 添加模板分类
     ***/
    public function addType($type){
        $this->type = $type;
        // $user_id  = $this->save() ? Yii::$app->db->lastInsertID : '';
        $template_id = $this->save() ? Yii::$app->db->lastInsertID : '';
        return $template_id;
    }



}