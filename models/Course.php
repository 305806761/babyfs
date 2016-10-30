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
        $result = self::findOne($course_id);
        /*$course = self::find()
            ->select(['name', 'course_id'])  //查找字段
            ->where(['course_id' => $course_id]) //查找条件
            ->indexBy('course_id') //course_id 为key
            ->asArray() //查找结果以course_id 为key  ,name:为值
            ->one();
            ->column();*/
        //print_r($result);die;
        return $result;

    }

    /*
     * 添加课程
    */
    public function add($param)
    {
        $this->name = $param['name'];
        $this->code = $param['code'];
        $this->class_hour = $param['class_hour'];

        // var_dump($param);die;
        //用户信息插入数据库
        $course_id = $this->save() ? Yii::$app->db->lastInsertID : '';
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
        $sql = "select cs.* from user_course as uc left join course_section as cs  on uc.section_id = cs.section_id where uc.user_id = '{$user_id}'";
        $section = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($section as $key => $value) {
            $section[$key][is_buy] = '1';
            if ($key == 0) {
                $section_ids = $value['section_id'];
            } else {
                $section_ids .= ',' . $value['section_id'];
            }
        }
        // $section_ids = 2,3,4
        //print_r($section);die;
        $sqlsection = "select * from course_section where section_id not in ($section_ids)";
        $course_section = Yii::$app->db->createCommand($sqlsection)->queryAll();
        foreach ($course_section as $key => $value) {
            $course_section[$key][is_buy] = '0';
        }
        $course = array_merge($section, $course_section);
        // print_r($course);die;
        return $course;
    }

}
