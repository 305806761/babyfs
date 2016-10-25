<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/20
 * Time: 11:25
 */

namespace app\controllers;
use app\models\Template;
use app\models\TemplateCode;
use Yii;
use yii\web\Controller;
use app\models\Ware;
use app\models\Course;


class WareController extends Controller
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
        $ware = new Ware();
        $course = Course::getCourse();
        $template = Template::getTemp();
//Array ( [1] => 文字 [2] => 图片 [3] => 视频 [4] => 音频 )
       // $templatecode = Template::getBigTemplate();
        //print_r($templatecode);die;
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

        return $this->render('add',[
            'course'=>$course,
            'template' => $template,
        ]);
    }

}