<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 10:42
 */

namespace app\controllers;

use Yii;
use app\models\Course;
use app\models\LoginForm;
use app\models\Session;
use app\models\SignupForm;
use app\models\Tool;
use app\models\User;
use yii\web\Controller;


class UserController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * 用户个人中心
     *
     * @return string
     */
    public function actionDefault(){

        $user = User::isLogin();
        if(!$user){
            Tool::Redirect("/user/login");
        }
        //var_dump($user);die;
        $this->view->params['user_button'] = 1;
        return $this->render('default',['user'=>$user]);
    }

    public function actionUserCourse(){
        $user = User::isLogin();
        if(!$user){
            Tool::Redirect("/user/login");
        }

        $course = Course::getCourseSection($user->user_id);
        //print_r($course);die;
        return $this->render('user_course',['course'=>$course]);
    }

    /**
     * Login action.用户登录
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = false;
        $user = User::isLogin();
        if($user){
            Tool::Redirect(User::get_loginpage());
        }
        $phone = Yii::$app->request->post('phone');
        $password = Yii::$app->request->post('password');
        if ($phone) {
            $member = new User();
            $user = array('phone' => $phone, 'password' => $password);
            if (!$member->login($user)) {
                Tool::Redirect("/user/login", '登陆失败！', 'error');
            } else {
                //echo Session::Get('phone');die;
                Tool::Redirect(User::get_loginpage());
            }
        }
        return $this->render('login');
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionSignup()
    {
        $this->layout = false;
        $user = User::isLogin();
        if($user){
            Tool::Redirect(User::get_loginpage());
        }
        $phone = Yii::$app->request->post('phone');
        $password = Yii::$app->request->post('password');
        if ($phone) {
            $member = new User();
            $user = array('phone' => $phone, 'password' => $password);

            if (!$member->signup($user)) {
                Tool::Redirect("/user/signup", '注册失败！', 'error');
            } else {
                //echo Session::Get('phone');die;
                Tool::Redirect(User::get_loginpage());
            }
        }
        return $this->render('signup');
    }


    /*
    * 退出登录
    * @param int $_SESSION['user_id'] 登录入口
    * @access public
    */
    public function actionLogout()
    {
        session_unset();
        //Yii::$app->session->remove('user_id');
        User::NoRemember('user_rnd');
        $user = User::isLogin();
        if(!$user){
            Tool::Redirect("/user/login");
        }
        Tool::Redirect('/user/user-course');
    }

    /**
     * 重设密码(修改密码)
     * @param int $user_id 登录入口
     * @access public
     */
    public function actionResetPassword()
    {
        $this->layout = false;
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $user = User::GetUserById($user_id);
        if (Yii::$app->request->post()) {
            $user_id = $_POST['user_id'];
            if ($_POST['password'] == $_POST['password2']) {
                $password = User::GenPassword($_POST['password']);
                $passwordold = User::getUsercheck(array('user_id' => $_POST['user_id'], 'password' => User::GenPassword($_POST['passwordold'])));
                if (!$passwordold) {
                    Tool::Redirect("/user/reset-password?user_id={$user_id}", '旧密码有误！', 'error');
                }
                $sql = "update user set password='{$password}' WHERE user_id = '{$user_id}'";

                $res = Yii::$app->db->createCommand($sql)->query();
                if ($res) {
                    Tool::Redirect('/user/reset-password?user_id={$user_id}', '密码修改成功', 'success');
                } else {
                    Tool::Redirect("/user/reset-password?user_id={$user_id}", '修改密码失败！', 'error');
                }
            }
            Tool::Redirect("/user/reset-password?user_id={$user_id}", '两次输入的密码不匹配，请重新设置', 'error');
        }
        $this->view->params['password'] = 1;
        return $this->render('reset', [
            'user' => $user,
        ]);
    }

    public function actionResetUser()
    {
        $this->layout = false;
        $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
        $user = User::GetUserById($user_id);
        if (Yii::$app->request->post()) {
            $user_id = Yii::$app->request->post('user_id');
            $phone = Yii::$app->request->post('phone');
            if ($phone) {
                $user_phone = User::GetUserByName($phone);
                if ($user_phone->phone) {
                    Tool::Redirect("/user/reset-user?user_id={$user_id}", '手机号已经存在！', 'error');
                }
                $sql = "update user set phone='{$phone}' WHERE user_id = '{$user_id}'";

                $res = Yii::$app->db->createCommand($sql)->query();
                if ($res) {
                    Tool::Redirect("/user/default?user_id={$user_id}", '手机号修改成功', 'success');
                } else {
                    Tool::Redirect("/user/reset-user?user_id={$user_id}", '手机号密码失败！', 'error');
                }
            }
        }
        $this->view->params['user'] = 1;
        return $this->render('reset', [
            'user' => $user,
        ]);
    }

    /**
     * 发送短信
     * @return string
     */

    public function actionSend()
    {
        if (Yii::$app->request->get('phone')) {
            $mobile = $_GET['phone'];
            $verifyCode = rand(1000, 9999);
            //Yii::$app->session->set('code', $verifyCode);
            // Session::Set('code', $verifyCode);
            //Tool::cookieset("code", $verifyCode, "600");

            $content = "【宝宝玩英语】您的验证码为：{$verifyCode}此验证码10分钟内有效，请尽快使用！";
            $result = Tool::Send($mobile, $content);
            if ($result) {
                //发送成功，保存session
                //检查session是否打开
                if (!Yii::$app->session->isActive) {
                    Yii::$app->session->open();
                }
                //验证码和短信发送时间存储session
                Yii::$app->session->set('login_sms_code', $verifyCode);
                Yii::$app->session->set('login_sms_time', time());
                //
                $return = array(
                    'cood' => 200,
                    // 'verifyCode' => Session::Get('code'),
                    'message' => '短信发送成功',
                );
            } else {
                $return = array(
                    'cood' => 0,
                    'message' => '短信发送失败',
                );
            }
        } else {
            $return = array(
                'cood' => 0,
                'message' => '没有获取手机号',
            );
        }
        die(json_encode($return));
    }

    /**
     * 验证码是否有效
     */
    public function actionCheckCode()
    {
        $code = Yii::$app->request->get('code');
        if ($code) {
            //检查session是否打开
            if (!Yii::$app->session->isActive) {
                Yii::$app->session->open();
            }
            //取得验证码和短信发送时间session
            $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
            $signup_sms_time = Yii::$app->session->get('login_sms_time');
            if (time() - $signup_sms_time < 600) {
                if ($code != $signup_sms_code) {
                    $result = array('cood' => 0, 'message' => '验证码输入有误');
                }
            } else {
                $result = array('cood' => 0, 'message' => '验证码已经失效');
            }
        }
       // echo $signup_sms_code;
        return json_encode($result);
    }


}