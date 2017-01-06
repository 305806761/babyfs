<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/8
 * Time: 10:46
 */

namespace app\models;

use app\models\base\BaseModel;
use Yii;

class Course extends BaseModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * @inheritdoc  image    char(120)
     */
    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 100],

            ['price', 'double', 'min' => 1, 'max' => 999999999999.99],
            ['price', 'match', 'pattern' => '/^[1-9][0-9]{0,11}(\.[0-9]{1,2})?$/', 'message' => '请输入整数或小数二位'],

            ['type', 'default', 'value' => self::COURSETYPEK],
            ['type', 'in', 'range' => [self::COURSETYPEK, self::COURSETYPEH, self::COURSETYPEKN]],
            [['code'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => '课程ID',
            'name' => '课程名称',
            'code' => '课程code',
            'type' => '类别',
            'price' => '价格',
        ];
    }


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
        $query = UserCourse::find()->where(['user_id' => $user_id]);
        $query->joinWith(['section' => function ($query) {
            $query->select('name,image,buyurl,section_id')->where(['is_show' => 0]);
        }]);
        $query->joinWith(['term' => function ($query) {
            $query->select('id,term,start_time,end_time');
        }]);
        $section = $query->asArray()->all();

        $newtime = time();
        $free = array('7', '8', '9');
        $section_ids = array();
        $a = false;
        foreach ($section as $key => $value) {
            //开放中
            $section[$key]['is_buy'] = '1';
            //$expire_time = $value['term']['end_time'];   获取学期term 时间
            //判断时候过期
            $expire_time = strtotime($value['expire_time']); //user_course 获取时间
            if ($newtime >= $expire_time) {
                $section[$key]['is_buy'] = '0';
            }
            //1是未审核，2是审核
            if ($value['started'] == '1') {
                $section[$key]['is_buy'] = '0';
            }

            if (in_array($value['section_id'], $free)) {

            }else{
                $a = 1;
            }
            //所有免费和精品课，免费只有一个
            $section_ids[] = $value['section_id'];
        }

        if (empty($section_ids)) {
            if (!$section) {
                //如果什么都没买 ，只显示精品
                $section = Section::find()->where(['not in', 'section_id', $free])->andWhere(['is_show' => 0])->asArray()->all();
                foreach ($section as $skey => $sval) {
                    $section[$skey]['section'] = $sval;
                }
            }
            return $section;
        }

        if(!$a){
            //只买了免费课
            $section_ids = array_diff($free, $section_ids);
            $course_section = Section::find()->where(['in', 'section_id', $section_ids])->andWhere(['is_show' => 0])->asArray()->all();
        }else{
            //显示精品和免费
            $course_section = Section::find()->where(['not in', 'section_id', $section_ids])->andWhere(['is_show' => 0])->asArray()->all();
        }

        foreach ($course_section as $key => $value) {
            $course_section[$key]['section'] = $value;
            $course_section[$key]['is_buy'] = '0';
        }
        $course = array_merge($section, $course_section);
//        echo "<pre>";
//        print_r($course);die;
        return $course;
    }

    public static function getGuestCourse()
    {
        //如果什么都没买 ，只显示精品
        $section = Section::find()->where(['section_id' => 13, 'is_show' => 1])->asArray()->all();
        foreach ($section as $skey => $sval) {
            $section[$skey]['section'] = $sval;
            $section[$skey]['term_id'] = 29;
            $section[$skey]['is_buy'] = 1;

        }
        // echo "<pre>";
        //print_r($section);
        //die;
        return $section;

    }

}
