<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 9:28
 */
namespace app\controllers;
use app\models\Course;
use Yii;
use yii\web\Controller;
use app\models\Template;


class CourseController extends Controller
{
    public $layout = "newlayout";
    public $enableCsrfValidation = false;

    /**
     * 课程列表
    */
    public function actionList(){

        $course = Course::getCourse();
        return $this->render('list',['course'=>$course]);

    }

    /**
     * 添加课程
     */
    public function actionAdd(){
        $course = new Course();

        if ($_POST) {
            $array = array(
                'name'=>$_POST['name'],
                'code'=>$_POST['code'],
                'class_hour'=>$_POST['class_hour'],
                'is_free'=>$_POST['is_free'],
            );

            $result = $course->add($array);

            if($result){
                echo "添加课程成功";
            }

        }

        return $this->render('add');
    }

}