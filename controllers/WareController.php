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
    public function actionDetail($ware_id = '')
    {
        $this->layout = 'ware';
        $ware_id = Yii::$app->request->get('ware_id') ? Yii::$app->request->get('ware_id') : $ware_id;
        if (!$ware_id) {
            Tool::Redirect('/section/list');
        }
        //登陆session
        if (!Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }
        Yii::$app->session->set("loginpage", "/ware/detail?ware_id=$ware_id");
        //判断是否登录

        $user = User::isLogin();
        if ($_COOKIE['isGuest'] == 1) {
            //如果用户是游客
            if ($user) {
                //判断是否有权限查看该课件
                if (!User::checkPermitWare($user->user_id, $ware_id)) {
                    Tool::Redirect('/section/list', '没有权限查看', 'notice');
                };
                $model = $this->findModel($ware_id);
                $result = '';
                if ($c = json_decode($model->contents, true)) {
                    foreach ($c as $type_id) {
                        if ($wt = WareType::findOne($type_id)) {
                            // print_r($c);die;
                            if ($template_code = TemplateCode::findOne($wt->temp_code_id)) {
                                $engine = new Handlebars();
                                $engine->registerHelper('addOne', function ($index) {
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

            } else {
                //只能看游客的课
                $models = User::checkGuestWare(13, $ware_id);
                if ($models) {
                    $model = $this->findModel($ware_id);
                    $result = '';
                    if ($c = json_decode($model->contents, true)) {
                        foreach ($c as $type_id) {
                            if ($wt = WareType::findOne($type_id)) {
                                // print_r($c);die;
                                if ($template_code = TemplateCode::findOne($wt->temp_code_id)) {
                                    $engine = new Handlebars();
                                    $engine->registerHelper('addOne', function ($index) {
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
                } else {
                    Tool::Redirect("/user/login");
                }
            }
        } else {
            if ($user) {
                //如果用户存在，那么用户不能看游客的课
                //判断是否有权限查看该课件
                if (!User::checkPermitWare($user->user_id, $ware_id)) {
                    Tool::Redirect('/section/list', '没有权限查看', 'notice');
                };
                $model = $this->findModel($ware_id);
                $result = '';
                if ($c = json_decode($model->contents, true)) {
                    foreach ($c as $type_id) {
                        if ($wt = WareType::findOne($type_id)) {
                            // print_r($c);die;
                            if ($template_code = TemplateCode::findOne($wt->temp_code_id)) {
                                $engine = new Handlebars();
                                $engine->registerHelper('addOne', function ($index) {
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
            } else {
                Tool::Redirect("/user/login");
            }
        }
        //print_r($model);die;
        return $this->render('detail', ['ware' => $model]);
    }

    public function actionView($ware_id = '')
    {
        $this->layout = 'ware';
        $ware_id = (int)Yii::$app->request->get('ware_id') ? (int)Yii::$app->request->get('ware_id') : $ware_id;
        $section_id = (int)Yii::$app->request->get('section_id') ? (int)Yii::$app->request->get('section_id') : '';
        $termId = (int)Yii::$app->request->get('term_id') ? (int)Yii::$app->request->get('term_id') : '';
        $time = base64_decode(Yii::$app->request->get('time')) ? base64_decode(Yii::$app->request->get('time')) : '';
        if ($ware_id && $section_id) {
            $freeArray = Yii::$app->params['free'];
            if (in_array($section_id, $freeArray)) {
                //彭达添加term默认只有第一学期。
                $isTime = User::checkFreeSection($section_id, $termId, $time);
                if ($isTime) {
                    $models = User::checkFreeWare($section_id, $ware_id);
                    if ($models) {
                        $model = $this->findModel($ware_id);
                        $result = '';
                        if ($c = json_decode($model->contents, true)) {
                            foreach ($c as $type_id) {
                                if ($wt = WareType::findOne($type_id)) {
                                    // print_r($c);die;
                                    if ($template_code = TemplateCode::findOne($wt->temp_code_id)) {
                                        $engine = new Handlebars();
                                        $engine->registerHelper('addOne', function ($index) {
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
                    }
                }
            }
        }
        //print_r($model);die;
        return $this->render('view', ['ware' => $model]);
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