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
        $template = new Template();

        if (Yii::$app->request->post()) {
            if (Template::modify($template, Yii::$app->request->post('type'), Yii::$app->request->post('param'))) {
                return $this->redirect(['list-type']);
            }
        }

        return $this->render('addtype', ['template' => $template->attributes]);
    }

    public function actionEditType()
    {
        $template_id = Yii::$app->request->get('template_id');
        if (!$template = Template::findOne($template_id)) {
            return $this->redirect(['list-type']);
        }

        if (Yii::$app->request->post()) {
            if (Template::modify($template, Yii::$app->request->post('type'), Yii::$app->request->post('param'))) {
                return $this->redirect(['list-type']);
            }
        }
        return $this->render('addtype', ['template' => $template->attributes,]);
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

    public function actionListType()
    {
        $type = Template::getTemp();
        return $this->render('listtype', ['type' => $type,]);
    }


}