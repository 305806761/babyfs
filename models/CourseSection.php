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
use yii\web\Session;

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
    public static function getSectionByCourse_id($course_id)
    {
        if ($course_id) {
            $sql = "select s.name,s.section_id from section as s left JOIN course_section as cs on s.section_id = cs.section_id where cs.course_id =$course_id";
            $section = Yii::$app->db->createCommand($sql)->queryAll();
            return $section;
        } else {
            return false;
        }
    }

    /**
     * 添加课程与阶段的关系
     * @param integer $section_id
     * @param array $course_id
     * @return boolean
     */
    public function add($section_id,$course_id)
    {

        if($section_id && $course_id){
            if(is_array($course_id)){
                foreach ($course_id as $value){
                    $course_section = CourseSection::findOne(['section_id'=>$section_id,'course_id'=>$value]);
                    if(!$course_section){
                        $course_section = new CourseSection();
                    }
                    $course_section->section_id = $section_id;
                    $course_section->course_id = $value;
                    $course_section->save();
                }
            }else{
                $course_section = CourseSection::findOne(['section_id'=>$section_id,'course_id'=>$course_id]);
                if(!$course_section){
                    $course_section = new CourseSection();
                }
                $course_section->section_id = $section_id;
                $course_section->course_id = $course_id;
                $course_section->save();
            }
        }else{
            return false;
        }
        return true;
    }

    public static function getSectionById($section_id)
    {
        if (!$section = self::findOne($section_id)) {
            $section = new CourseSection();
        }
        return $section;
    }

    /**
     * 查找阶段（下课程id）
     * @param integer $section_id
     * @return array
     */

    public static function getCourseSection($section_id='')
    {
        if($section_id){
            $section = Section::findOne(['section_id'=>$section_id])->attributes;
            $section['course_id'] = CourseSection::find()->select('course_id')->where(['section_id'=>$section_id])->asArray()->all();
        }else{
            $section = Section::find()->asArray()->all();
            foreach ($section as $key=> $value){
                foreach ($value as $val){
                    $section[$key]['course_id'] = CourseSection::find()->select('course_id')
                        ->where(['section_id'=>$value['section_id']])->asArray()->all();
                }

            }
        }
        return $section;
    }

    /**
     * 查找课程（下阶段）
     * @param integer $section_id
     * @return array
     */
    public static function getCourse(){
        $course = Course::find()->asArray()->all();
        foreach ($course as $key=>$value){
            $sql = "SELECT s.* FROM course_section AS cs LEFT join section as s ON cs.section_id = s.section_id where cs.course_id ='{$value[course_id]}'";
            $section = Yii::$app->db->createCommand($sql)->queryAll();
            $course[$key]['section'] = $section;
        }
        return $course;
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

        $sql = "SELECT sc.id,sc.cat_name,s.name AS section_name
                FROM section_cat AS sc 
                LEFT JOIN section AS s ON sc.section_id = s.section_id 
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
       echo $sql;die;

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
        print_r($ware);die;
        return $ware;
    }

}
