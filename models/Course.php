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
        $query = UserCourse::find()->where(['user_id'=>$user_id]);
        $query->joinWith(['section' => function ($query){
            $query->select('name,image,buyurl,section_id');
        }]);
        $query->joinWith(['term' => function ($query){
            $query->select('id,start_time,end_time');
        }]);
        $section = $query->asArray()->all();
        $newtime = time();
        $free = array('7','8','9');
        $section_ids = array();
        foreach ($section as $key => $value) {
            $section[$key][is_buy] = '1';
            //$expire_time = $value['term']['end_time'];   获取学期term 时间
            $expire_time = strtotime($value['expire_time']); //user_course 获取时间
            if($newtime>=$expire_time){
                $section[$key][is_buy] = '0';
            }
            if($value['started']=='1'){
                $section[$key][is_buy] = '0';
            }
            if(in_array($value['section_id'],$free)){
                continue;
            }
            $section_ids[] = $value['section_id'];
        }

        if(empty($section_ids)){
            return $section;
        }

        $course_section = Section::find()->where(['not in','section_id', $section_ids])->asArray()->all();
        foreach ($course_section as $key => $value) {
            $course_section[$key]['section'] = $value;
            $course_section[$key][is_buy] = '0';
        }
        $course = array_merge($section, $course_section);
        //echo "<pre>";
        //print_r($course);die;
        return $course;
    }

}
