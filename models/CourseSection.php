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

//['tmp_name']  WareType[1][img_file]
        if (isset($param['image']['tmp_name'])
            && $param['image']['tmp_name']
        ) {
            $path_parts = pathinfo($param['image']['name']);
            $file = '/uploads/section/' . time() . rand(100, 999) . $path_parts['basename'];
            copy(
                $param['image']['tmp_name'],
                Yii::getAlias('@webroot' . $file)
            );
            $image = json_encode($file);
        }
        $course_section->image = $image ? $image : $course_section->image;
        //var_dump($course_section->image);die;
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

        $sql = "SELECT c.name AS course_name,c.code AS course_code,s.course_id AS section_course_id,
                s.name AS section_name,s.code AS section_code,s.sort,s.section_id,s.expire_time AS section_expire_time  
                FROM `course` AS c, `course_section` AS s 
                WHERE c.course_id = s.course_id";

        $coursesection = Yii::$app->db->createCommand($sql)
            ->queryAll();

        //print_r($coursesection);die;

        return $coursesection;
    }


    /**
     *
     * 获取所有课程$is_free=0 是免费，￥is_free=1是收费
     */

    public function getSectionWare($section_id, $user_id)
    {
        if (!$uc = UserCourse::findOne(['section_id' => $section_id, 'user_id' => $user_id])) {
            return [];
        }

        if (!$usable = Ware::getUsable($section_id, $uc->create_time)) {
            return [];
        }

        $sql = "SELECT sc.id,sc.cat_name,cs.name AS section_name
                FROM section_cat AS sc 
                LEFT JOIN course_section AS cs ON sc.section_id = cs.section_id 
                LEFT JOIN user_course AS uc ON sc.section_id = uc.section_id";
        $where = [];
        if ($section_id) {
            $where[] = "sc.section_id = '$section_id'";
        }
        if ($user_id) {
            $where[] = "uc.user_id = '$user_id'";
        }
        if ($where) {
            $sql .= ' where ' . implode(' and ', $where);
        }
//        echo $sql;die;

        $section_ware = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($section_ware as $key => $value) {
            $sql = "select w.title,w.ware_id 
                    from course_ware as cw 
                    left join ware as w on cw.ware_id = w.ware_id 
                    where cw.section_cat_id = {$value['id']}";
            $ware = Yii::$app->db->createCommand($sql)->queryAll();
            $all = count($ware);
            if ($all > $usable) {
                $ware = array_slice($ware, 0, $usable);
            }
            $section_ware[$key]['ware'] = $ware;
            if ($all >= $usable) {
                break;
            }
            $usable -= $all;
        }
        $ware = array('section_name' => $section_ware[0]['section_name'], 'section_ware' => $section_ware);
        //$section_ware['section_name'] = $section_ware[0]['section_name'];
        //print_r($ware);die;
        return $ware;
    }

}
