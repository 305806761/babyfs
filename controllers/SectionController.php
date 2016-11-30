<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/30
 * Time: 15:56
 */

namespace app\controllers;

use Yii;
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
        $section_id = (int)Yii::$app->request->get('section_id');
        $term_id = (int)Yii::$app->request->get('term_id');
        //echo $section_id;die;

        $cs = new CourseSection();
        //判断是否有权限查看该课件checkPermitSection
        if(!User::checkPermitSection($user->user_id,$section_id,$term_id)){
            Tool::Redirect('/user/user-course','没有权限查看','notice');
        };
        $wares = $cs->getSectionWare($section_id, $user->user_id,$term_id);
        //print_r($wares);die;
        return $this->render('list', ['wares' => $wares]);
    }


}