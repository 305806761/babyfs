<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/30
 * Time: 15:56
 */

namespace app\controllers;

use yii\web\Controller;
use yii\data\Pagination;
use app\models\CourseSection;
use app\models\User;
use app\models\Tool;


class SectionController extends Controller
{
    public function actionList()
    {
        $user = User::isLogin();
        if (!$user) {
            Tool::Redirect("/user/login");
        }
        $section_id = \Yii::$app->request->get('section_id', '');
        //echo $section_id;die;

        $cs = new CourseSection();
        $wares = $cs->getSectionWare($section_id, $user->user_id);
        //print_r($wares);die;
        return $this->render('list', ['wares' => $wares]);
    }


}