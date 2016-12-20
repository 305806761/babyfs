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
        //如果用户存在，那么用户不能看游客的课
        $section_id = (int)Yii::$app->request->get('section_id');
        $term_id = (int)Yii::$app->request->get('term_id');
        if ($_COOKIE['isGuest'] == 1) {
            //如果用户是游客
            if ($user) {

                //echo $section_id;die;
                $cs = new CourseSection();
                //判断是否有权限查看该课件checkPermitSection
                if(!User::checkPermitSection($user->user_id,$section_id,$term_id)){
                    Tool::Redirect('/user/user-course','没有权限查看','notice');
                };
                $wares = $cs->getSectionWare($section_id, $user->user_id,$term_id);

            } else {
                //只能看游客的课
                $cs = new CourseSection();
                $wares = $cs->getGuestWare($section_id, $term_id);

            }
        } else {
            if ($user) {
                //如果用户存在，那么用户不能看游客的课
                $section_id = (int)Yii::$app->request->get('section_id');
                $term_id = (int)Yii::$app->request->get('term_id');
                //echo $section_id;die;
                $cs = new CourseSection();
                //判断是否有权限查看该课件checkPermitSection
                if(!User::checkPermitSection($user->user_id,$section_id,$term_id)){
                    Tool::Redirect('/user/user-course','没有权限查看','notice');
                };
                $wares = $cs->getSectionWare($section_id, $user->user_id,$term_id);
            } else {
                Tool::Redirect("/user/login");
            }
        }

        //print_r($wares);die;
        return $this->render('list', ['wares' => $wares]);
    }


}