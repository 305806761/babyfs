<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/11/1
 * Time: 18:30
 */

namespace app\controllers;

use Yii;
use app\models\Tool;
use app\models\WareType;
use app\models\TemplateCode;
use Handlebars\Handlebars;
use app\models\Ware;
use app\models\User;
use yii\web\Controller;

class WareController extends Controller
{
    public function actionDetail($ware_id=''){
        $this->layout = false;
        $user = User::isLogin();
        if(!$user){
            Tool::Redirect("/user/login");
        }
        $ware_id = Yii::$app->request->get('ware_id') ? Yii::$app->request->get('ware_id') : $ware_id;
        if(!$ware_id){
            Tool::Redirect('/section/list');
        }
        $model = $this->findModel($ware_id);
        $result = '';
        if ($c = json_decode($model->contents, true)) {
            foreach ($c as $type_id) {
                if ($wt = WareType::findOne($type_id)) {
                   // print_r($c);die;
                    if ($template_code = TemplateCode::findOne($wt->temp_code_id)) {
                        $engine = new Handlebars();
                        $engine->registerHelper('addOne', function ($index){
                            return ++$index;
                        });
                        $result .= $engine->render(
                            $template_code->code,
                            json_decode($wt->content, true)
                        );
                    }
                }
            }
        }
        $model->contents = $result;
        //print_r($model);die;
        return $this->render('detail',['ware'=>$model]);
    }

    protected function findModel($id)
    {
        if (($model = Ware::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('课件没有找到');
        }
    }

}