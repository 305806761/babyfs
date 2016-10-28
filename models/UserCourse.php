<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/27
 * Time: 15:01
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class UserCourse extends ActiveRecord
{
    /**
     * 添加用户与课程的关系
    **/
    public function add($param){

        $this->course_id = $param['course_id'];
        $this->section_id = $param['section_id'];
        $this->version = $param['version'];
        $this->user_id = $param['user_id'];
        $this->create_time = $param['create_time'];
        $this->expire_time = $param['expire_time'];

        $id = self::save() ? Yii::$app->db->lastInsertID : '';
        return $id;
    }

}