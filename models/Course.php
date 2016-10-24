<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/8
 * Time: 10:46
 */

namespace app\models;
use yii\db\ActiveRecord;

class Course extends ActiveRecord
{

    /**
     *
     * 通过课程名称查找课程id
     */
    public static function getByName($course_name)
    {
        if($course_name){
//(new \yii\db\Query())---self:;find
            $course_id = self::find()
                ->where(['name' => $course_name])
                ->scalar(); //获取数据库里自增的字段
            return $course_id;
        }else{
            return false;
        }
    }

    /**
     *
     * 获取所有课程$is_free=0 是免费，￥is_free=1是收费
     */

    public static function getCourse($is_free)
    {
        $course = self::find()
            ->select(['name', 'course_id'])  //查找字段
            ->where(['is_free' => $is_free]) //查找条件
            ->indexBy('course_id') //course_id 为key
            ->asArray() //查找结果以course_id 为key  ,name:为值
            ->column();
            return $course;

    }

}
