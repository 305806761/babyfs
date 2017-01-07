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
                if (!User::checkPermitSection($user->user_id, $section_id, $term_id)) {
                    Tool::Redirect('/user/user-course', '没有权限查看', 'notice');
                };
                $wares = $cs->getSectionWare($section_id, $user->user_id, $term_id);

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
                if (!User::checkPermitSection($user->user_id, $section_id, $term_id)) {
                    Tool::Redirect('/user/user-course', '没有权限查看', 'notice');
                };
                $wares = $cs->getSectionWare($section_id, $user->user_id, $term_id);
            } else {
                Tool::Redirect("/user/login");
            }
        }

        //print_r($wares);die;
        return $this->render('list', ['wares' => $wares]);
    }

    /**
     * @return string
     */
    public function actionFree()
    {
        //$key = 'FREE';
        // $code = base64_encode(Yii::$app->security->encryptByKey($section_id, $key)); //加密
        // $section_id = Yii::$app->security->decryptByKey(base64_decode($s_id), $key);//解密
        //$term_id = Yii::$app->security->decryptByKey(base64_decode($t_id), $key);//解密

        $this->layout='user';
        $wares = [];
        $section_id = (int)Yii::$app->request->get('section_id');
        $term_id = (int)Yii::$app->request->get('term_id');
        $d_time = base64_decode(Yii::$app->request->get('time'));
        $freeArray = Yii::$app->params['free'];
        if(in_array($section_id,$freeArray)){
            if (!User::checkFreeSection($section_id, $term_id,$d_time)) {
               Tool::notice('没有权限查看或者权限已经失效','notice');
            };
            $cs = new CourseSection();
            $wares = $cs->getFreeWare($section_id, $term_id);
        }else{
            Tool::notice('对不起，您没有权限查看！','notice');
        }
        Yii::warning(json_encode($wares.'用户和课程的关系建立'));


        return $this->render('free_list', ['wares' => $wares]);
    }


}