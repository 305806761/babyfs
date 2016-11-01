<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 11:26
 */

namespace app\modules\admin\controllers;

use app\models\TemplateCode;
use app\models\Tool;
use Yii;
use yii\web\Controller;
use app\models\Template;


class TemplateController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionList()
    {
        $template = Template::getBigTemplate();
        //print_r($template);die;
        return $this->render('list',
            ['template' => $template]);
    }

    /**
     * 添加模板code
     **/
    public function actionAddTemp()
    {

        $template = new Template();
        $temp = $template->getTemp();
        if (Yii::$app->request->post()) {
            $array = array(
                'template_id' => Yii::$app->request->post('template_id'),
                'temp_code_id' => Yii::$app->request->post('temp_code_id'),
                'code' => Yii::$app->request->post('code'),
            );

            $result = $template->add($array);

            if ($result) {
                Tool::Redirect('/admin/template/list');
            }
        }
        return $this->render('addtemp', ['temp' => $temp]);
    }

    /***
     * 添加模板分类
     ***/

    public function actionAddType()
    {
       // $param = array('text'=>'text','img'=>'image','video'=>'video','text=>text,img=>image');

        //print_r($param);die;
        if (Yii::$app->request->post()) {
            $type = Yii::$app->request->post('type');
            $template_id = Yii::$app->request->post('template_id');
            $template_id = Yii::$app->request->post('template_id');
            $array = array('type'=>$type,'template_id'=>$template_id);
            $template = new Template();
            $template_id = $template->addType($array);
            if ($template_id) {
                Tool::Redirect('/admin/template/add-temp');
            }
        }
        return $this->render('addtype', ['param' => $param]);
    }

    /***
     * 修改模板
     ***/
    public function actionEditTemp()
    {
        $template = new Template();
        $temp = $template->getTemp();
        $temp_code_id = Yii::$app->request->get('temp_code_id');
        $tempcode = $template->getBigTemplate($temp_code_id);
        //print_r($tempcode);die;
        return $this->render('addtemp',
            [
                'tempcode' => $tempcode,
                'temp' => $temp,

            ]);
    }

    public function actionEditType()
    {
        $template_id = Yii::$app->request->get('template_id');
        $template =Template::find()->where(['template_id'=>$template_id])->asArray()->one();
        //print_r($template);die;
        return $this->render('addtype', ['template' => $template,]);
    }

    public function actionListType(){
        $type = Template::getTemp();
        return $this->render('listtype', ['type' => $type,]);
    }


}