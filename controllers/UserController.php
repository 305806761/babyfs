<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 10:42
 */

namespace app\controllers;

use app\models\Session;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\Tool;


class UserController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.用户登录
     *
     * @return string
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), 'LoginForm') && $model->login()) {
            echo Session::Get('username').'登录成功';

        }else{
            echo "登录失败";
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }




    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionSignup()
    {
        $model = new SignupForm();


        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            echo Session::Get('username').'注册成功并且登录成功';


        }else{
            echo "注册失败";
        }


        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * 验证用户名是否已经存在
     */
    public function actionUserByName(){

        if($_GET['username']){
            if(Member::GetUserByName($_GET['username'])){
                $return = array(
                    'code' => 200,
                    'data' => array(
                        'callback' => "checkMobie('exists')",
                    )
                );

            }
        }
        die(json_encode($return));


    }


    /**
     * 发送短信
     * @return string
     */

    public function actionSend(){
        if ($_GET['phone']){
            $mobile = $_GET['phone'];
            $verifyCode = rand(1000, 9999);
            //Session::Set('code',$verifyCode);
            Tool::cookieset("code",$verifyCode,"600");
           // echo Session::Get('vcode');die;
            $content = "【宝宝玩英语】您的验证码为：{$verifyCode}此验证码10分钟内有效，请尽快使用！";
            $result = Tool::Send($mobile,$content);
            if($result){
                $return = array(
                    'code' => 200,
                   // 'verifyCode' => Session::Get('code'),
                    'message' => '短信发送成功',
                );

            }else{
                $return = array(
                    'code' => -2,
                    'message' => '短信发送失败',
                );
            }

        }else{
            $return = array(
                'code' => -1,
                'message' => '没有获取手机号',
                );
        }

        die(json_encode($return));
    }


}