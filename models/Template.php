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

    public function  add($param){
        $templatecode = new TemplateCode();

        $result = $templatecode->add($param);

        return $result;
    }

    public static function getBigTemplate()
    {
        return self::hasMany(TemplateCode::className(), ['template_id' => 'template_id'])
            ->orderBy('temp_code_id')
            ->asArray()
            ->all();

    }



}