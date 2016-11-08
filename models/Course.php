<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/8
 * Time: 10:46
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Course extends ActiveRecord
{

    /**
     *
     * 通过课程名称查找课程id
     */
    public static function getByName($course_name)
    {
        if ($course_name) {
//(new \yii\db\Query())---self:;find
            $course_id = self::find()
                ->where(['name' => $course_name])
                ->scalar(); //获取数据库里自增的字段
            return $course_id;
        } else {
            return false;
        }
    }

    /**
     *
     * 获取所有课程$is_free=0 是免费，￥is_free=1是收费
     */
    static public function getCourseById($course_id)
    {
        $course = self::findOne($course_id);
        if (!$course || !$course_id) {
            $course = new Course();
        }
        return $course;

    }

    /*
     * 添加课程
    */
    /**
     * @param $param
     * @return string
     */
    public function add($param)
    {
        //print_r($param);die;
        $course = self::getCourseById($param['course_id']);
        $course->name = $param['name'];
        $course->code = $param['code'];
        $course->class_hour = $param['class_hour'];

        // var_dump($param);die;
        //用户信息插入数据库
        if ($course->save()) {
            $course_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $course->course_id;
        }

        return $course_id;
    }

    /***
     * 单课程列表返回
     **/
    public static function getCourse()
    {
        $course = self::find()->asArray()->all();
        return $course;
    }

    /***
     *课程下阶段数据
     **/
    public static function getCourseSection($user_id)
    {
        $sql = "select cs.*,uc.expire_time as user_course_expire from user_course as uc left join course_section as cs  on uc.section_id = cs.section_id where uc.user_id = '{$user_id}'";
        $section = Yii::$app->db->createCommand($sql)->queryAll();
        $newtime = time();
        foreach ($section as $key => $value) {
            $expire_time = $value['user_course_expire'];
            if($newtime>=$expire_time){
                $section[$key][is_buy] = '0';
            }else{
                $section[$key][is_buy] = '1';
            }
            if ($key == 0) {
                $section_ids = $value['section_id'];
            } else {
                $section_ids .= ',' . $value['section_id'];
            }
        }
        // $section_ids = 2,3,4
        //print_r($section);die;
        $section_ids = $section_ids ? $section_ids : "''";
        $sqlsection = "select * from course_section where section_id not in ($section_ids)";
        $course_section = Yii::$app->db->createCommand($sqlsection)->queryAll();
        foreach ($course_section as $key => $value) {
            $course_section[$key][is_buy] = '0';
        }
        $course = array_merge($section, $course_section);
        //print_r($user_id);die;
        return $course;
    }

}
