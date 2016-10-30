<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/27
 * Time: 18:06
 */

namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\TemplateCode;
use app\models\User;
use Yii;
use yii\web\Controller;
use app\models\Template;


class UserController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $course = Course::getCourse();
        $user_course = User::getUserCourse();
        //print_r($course);die;
        return $this->render('list',
            ['user_course' => $user_course,
                'course' => $course]);

    }

    public function actionSearch()
    {
        $course = Course::getCourse();
        $course_id = Yii::$app->request->post('course_id');
        $section_id = Yii::$app->request->post('section_id');
        $phone = Yii::$app->request->post('phone');
        if ($course_id && $section_id && $course_id != 'no' && $section_id != 'no') {
            $condition_class = "uc.course_id = '{$course_id}' and uc.section_id = '{$section_id}'";
        }
        if ($phone) {
            $condition_user = "u.phone = '{$phone}'";
        }
        $user_course = User::getUserCourse($condition_class,$condition_user);
        //print_r($user_course);die;
        return $this->render('list',
            ['user_course' => $user_course,
                'course' => $course]);
    }

}