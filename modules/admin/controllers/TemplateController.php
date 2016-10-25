<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 11:26
 */

namespace app\controllers;
use Yii;
use yii\web\Controller;
use app\models\Template;


class TemplateController extends Controller
{
    public $layout = "newlayout";
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAddTemp(){

        $template = new Template();

            $temp = $template->getTemp();

            if ($_POST) {
                $array = array(
                    'template_id'=>$_POST['template_id'],
                    'code'=>$_POST['code'],
                );

            $result = $template->add($array);

            if($result){
                echo "添加模板成功";
            }


        }

        return $this->render('addtemp', ['temp' => $temp]);
    }


}