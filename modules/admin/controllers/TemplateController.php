<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 11:26
 */

namespace app\modules\admin\controllers;
use app\models\TemplateCode;
use Yii;
use yii\web\Controller;
use app\models\Template;


class TemplateController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionList()
    {
        $template = Template::getBigTemplate();
        return $this->render('list',
            ['template'=>$template]);
    }

    /**
     * 添加模板code
    **/
    public function actionAddTemp(){

        $template = new Template();

            $temp = $template->getTemp();

            if (Yii::$app->request->post()) {
                $array = array(
                    'template_id'=>Yii::$app->request->post('template_id'),
                    'code'=>Yii::$app->request->post('code'),
                );

            $result = $template->add($array);

            if($result){
                echo "添加模板成功";
            }
        }
        return $this->render('addtemp', ['temp' => $temp]);
    }

    /***
     * 添加模板分类
    ***/

    public function actionAddType(){

        $type = Yii::$app->request->get('type');
        if($type){
            $template = new Template();
            $template_id = $template->addType($type);
            if(!$template_id){
                $result = array(
                    'error'=>1,
                    'message' => '添加模板类型失败',
                );
            }
            $result = array(
                'id' => $template_id,
                'type' => $type,
            );
            die(json_encode($result));
        }
    }

    /***
     * 修改模板
     ***/
    public function actionEditTemp(){
        $template = new Template();
        $temp = $template->getTemp();
        $temp_code_id = $_GET['temp_code_id'];
        $tempcode = TemplateCode::getTempCodeById($temp_code_id);
        //print_r($tempcode);die;
        return $this->render('addtemp',
            [
                'tempcode' => $tempcode,
                'temp' => $temp,

            ]);
    }


}