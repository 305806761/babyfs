<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/25
 * Time: 19:08
 */

namespace app\modules\admin\controllers;

use app\models\Course;
use app\models\CourseSection;
use Yii;
use yii\web\Controller;
use app\models\Template;


class SectionController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 课程列表
     */
    public function actionList()
    {

        $coursesection = CourseSection::getCourseSection();
        return $this->render('list', ['coursesection' => $coursesection]);

    }

    /**
     * 添加课程
     */
    public function actionAdd()
    {
        $course = Course::getCourse();
        $coursesection = new CourseSection();
        if ($_POST) {
            $array = array(
                'name' => Yii::$app->request->post('name'),
                'code' => Yii::$app->request->post('code'),
                'course_id' => Yii::$app->request->post('course_id'),
                'class_hour' => Yii::$app->request->post('class_hour', 0),
                'sort' => Yii::$app->request->post('sort'),
            );

            $result = $coursesection->add($array);

            if ($result) {
                echo "课程阶段添加成功";
            }

        }

        return $this->render('add',
            ['course' => $course]);
    }

    public function actionGetSection()
    {
        if ($_GET['course_id']) {
            $section = CourseSection::getById($_GET['course_id']);
            //print_r($section);die;
            die(json_encode($section));
        }
    }

}