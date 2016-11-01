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

class CourseSection extends ActiveRecord
{

    /**
     *
     * 通过课程名称查找课程id
     */
    public static function getByName($section_name)
    {
        if ($section_name) {
//(new \yii\db\Query())---self:;find
            $course_id = self::find()
                ->where(['name' => $section_name])
                ->scalar(); //获取数据库里自增的字段
            return $course_id;
        } else {
            return false;
        }
    }

    /**
     *
     * 通过course_id查找section
     */
    public static function getById($course_id)
    {
        if ($course_id) {
//(new \yii\db\Query())---self:;find
            $section = self::find()
                ->select(['name', 'section_id'])
                ->where(['course_id' => $course_id])
                //->indexBy('select_id')
                ->asArray()
                ->all(); //获取数据库里自增的字段
            return $section;
        } else {
            return false;
        }
    }

    /*
     * 添加课程
    */
    public function add($param)
    {
        $course_section = self::getSectionById($param['section_id']);
        $course_section->name = $param['name'] ? $param['name'] : $course_section->name;
        $course_section->code = $param['code'] ? $param['code'] : $course_section->code;
        $course_section->expire_time = $param['expire_time'] ? $param['expire_time'] : $course_section->expire_time;
        $course_section->sort = $param['sort'] ? $param['sort'] : $course_section->sort;
        $course_section->course_id = $param['course_id'] ? $param['course_id'] : $course_section->course_id;
        $course_section->section_id = $param['section_id'] ? $param['section_id'] : $course_section->section_id;

        // var_dump($param);die;
        //用户信息插入数据库
        if ($course_section->save()) {
            $section_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $course_section->section_id;
        }
        return $section_id;
    }

    public static function getSectionById($section_id)
    {
        if (!$section = self::findOne($section_id)) {
            $section = new CourseSection();
        }
        return $section;
    }

    public static function getCourseSection()
    {
        //获取课程和课程的阶段

        $sql = "select c.name as course_name,c.code as course_code,s.course_id as section_course_id,s.name as section_name,s.code as section_code,s.sort,s.section_id,s.expire_time as section_expire_time  from `course` as c, `course_section` as s WHERE c.course_id = s.course_id";

        $coursesection = Yii::$app->db->createCommand($sql)
            ->queryAll();

        //print_r($coursesection);die;

        return $coursesection;
    }


    /**
     *
     * 获取所有课程$is_free=0 是免费，￥is_free=1是收费
     */

    public function getSectionWare($section_id)
    {

        $sql = "select sc.id,sc.cat_name,cs.name as section_name
                from section_cat as sc left join course_section as cs on sc.section_id = cs.section_id WHERE sc.section_id = $section_id";
        $section_ware = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($section_ware as $key => $value) {
            $sql = "select w.title,w.ware_id from course_ware as cw left join ware as w on cw.ware_id = w.ware_id where cw.section_cat_id = {$value['id']}";
            $ware = Yii::$app->db->createCommand($sql)->queryAll();
            $section_ware[$key]['ware'] = $ware;
        }
        $ware = array('section_name' => $section_ware[0]['section_name'], 'section_ware' => $section_ware);
        //$section_ware['section_name'] = $section_ware[0]['section_name'];
        //print_r($ware);die;
        return $ware;
    }

}
