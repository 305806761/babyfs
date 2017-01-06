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

class Section extends ActiveRecord
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

    /*
     * 添加课程
    */
    public function add($param)
    {
        $course_section = self::getSectionById($param['section_id']);
        $course_section->name = $param['name'] ? $param['name'] : $course_section->name;
        $course_section->code = $param['code'] ? $param['code'] : $course_section->code;
        $course_section->expire_time = $param['expire_time'] ? $param['expire_time'] : $course_section->expire_time;
        $course_section->create_time = $param['create_time'] ? $param['create_time'] : $course_section->create_time;
        $course_section->sort = $param['sort'] ? $param['sort'] : $course_section->sort;
        $course_section->is_show = isset($param['is_show']) ? $param['is_show'] : $course_section->is_show;
        $course_section->section_id = $param['section_id'] ? $param['section_id'] : $course_section->section_id;
        $course_section->buyurl = $param['buyurl'] ? $param['buyurl'] : $course_section->buyurl;

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

        //用户信息插入数据库
        if ($course_section->save()) {
            $section_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $course_section->section_id;
            $course_section = new CourseSection();
            $course_section->add($section_id,$param['course_id']);
        }
        return $section_id;
    }

    public static function getSectionById($section_id)
    {
        if (!$section = self::findOne($section_id)) {
            $section = new Section();
        }
        return $section;
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

    /**
     * @param $course_section_id  $course_section_id //Array ( [course_section_id] => Array ( [0] => 3,2,1 [1] => 4,2,1 )
     * @param $user_id  [user_id] => 2
     * @param string $expire_time  strtotime
     * @return bool
     */
    public static function addPermit($course_section_id,$user_id,$expire_time=''){

        if(empty($course_section_id) || !$user_id){
            return false;
        }
        $sections = array();
        $key = array('course_id', 'section_id', 'term_id');
        foreach ($course_section_id as $ke => $value) {
            $val = explode(',', $value);
            $sections[$ke] = array_combine($key, $val);
            $sections[$ke]['user_id'] = $user_id;
        }
        if(empty($sections)){
            return false;
        }
        foreach ($sections as $k => $v) {
            //判断是阶段的那个学期
            $time = time();
            $term = TermModel::find()->where(
                [
                    'AND', ['=', 'status', 2],
                    ['=', 'section_id', $v['section_id']],
                    ['=', 'id', $v['term_id']],
                    //['>=', 'order_end_time', $time],
                    //['<=', 'order_start_time', $time],
                    //'order_end_time>:order_end_time' ,[':order_end_time' => strtotime($this->created)],
                ]
            )->asArray()->one();
            if(empty($term)){
                return false;
            }
            $course = Course::findOne($v['course_id']);
            if ($course->type == 3) {
                $term['start_time'] = $time;
                $term['end_time'] = $expire_time ? $expire_time :Yii::$app->params['course_expire'];
            }
            $sections[$k]['version'] = 1;
            $sections[$k]['started'] = 2;
            $sections[$k]['term_id'] = $term['id'];
            $sections[$k]['create_time'] = date('Y-m-d H:i:s', $term['start_time']);
            $sections[$k]['expire_time'] = date('Y-m-d H:i:s', $term['end_time']);
        }
        $usercourse = new UserCourse();
        $result = $usercourse->modify($usercourse, $sections);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

}
