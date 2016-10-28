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
        if ($_POST['course_id'] && $_POST['section_id'] && $_POST['course_id'] != 'no' && $_POST['course_id'] != 'no') {
            $condition_class = "uc.course_id = '{$_POST['course_id']}' and uc.section_id = '{$_POST['section_id']}'";
        }
        if ($_POST['phone']) {
            $condition_user = "u.phone = '{$_POST['phone']}'";
        }
        $user_course = User::getUserCourse($condition_class,$condition_user);
        //print_r($user_course);die;
        return $this->render('list',
            ['user_course' => $user_course,
                'course' => $course]);
    }

}