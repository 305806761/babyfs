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
    public function  add($param){
        $this->name = $param['name'];
        $this->code = $param['code'];
        $this->class_hour = $param['class_hour'];

        // var_dump($param);die;
        //用户信息插入数据库
        $course_id  = $this->save() ? Yii::$app->db->lastInsertID : '';
        return $course_id;
    }

    /*** 选择
    **/
    public static function getCourse(){
        $course = self::find()->asArray()->all();
        return $course;
    }

}
