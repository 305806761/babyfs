<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:26
 */

namespace app\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class Ware extends ActiveRecord
{
    /*
     * 添加课程
    */
    public function  add($param){
        $this->name = $param['name'];
        $this->code = $param['code'];
        $this->class_hour = $param['class_hour'];
        $this->is_free = $param['is_free'];

        // var_dump($param);die;
        //用户信息插入数据库
        $course_id  = $this->save() ? Yii::$app->db->lastInsertID : '';
        return $course_id;
    }

    public static function getCourse(){
        $course = self::find()->asArray()->all();
        return $course;
    }

}