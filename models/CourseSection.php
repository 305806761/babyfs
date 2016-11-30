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

    public function getSectionWare($section_id, $user_id,$term_id)
    {
        if (!$uc = UserCourse::findOne(['section_id' => $section_id, 'user_id' => $user_id,'term_id'=>$term_id])) {
            return [];
        }
        if (!$term = TermModel::findOne(['section_id' => $section_id,'id'=>$term_id])) {
            return [];
        }
        /*//从学期中获取开始时间
        if (!$usable = Ware::getUsable($section_id, $term->	start_time)) {
            return [];
        }*/

        //从user_course中获取开始时间
        if (!$usable = Ware::getUsable($section_id, strtotime($uc->create_time))) {
            return [];
        }

        $section_ware = SectionCat::find()->where(['section_id'=>$section_id,'term_id'=>$term_id])->asArray()->all();
       // print_r($section_ware);die;
        foreach ($section_ware as $key => $value) {
            $query = CourseWare::find()->from(['cw'=>CourseWare::tableName()])->where(['cw.section_cat_id'=>$value['id']]);
            $query->joinWith(['ware'=>function($query){
                $query->from(['w'=>Ware::tableName()])
                    ->select('w.title,w.ware_id,w.image,w.small_text');
            }]);
            $ware = $query->asArray()->all();

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

        $section = Section::findOne(['section_id'=>$section_id]);
        $ware = array('section_name' => $section->name, 'section_ware' => $section_ware);
        //echo "<pre>";
        //print_r($ware);die;
        //$section_ware['section_name'] = $section_ware[0]['section_name'];
        return $ware;
    }

}
