<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 10:42
 */

namespace app\controllers;

use app\models\LoginForm;
use app\models\Session;
use app\models\SignupForm;
use app\models\Tool;
use app\models\User;
use Yii;
use yii\web\Controller;


class UserController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

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
        if ($_POST['phone']) {
            $member = new User();
            $user = array('phone' => $_POST['phone'], 'password' => $_POST['password']);
            if (!$member->login($user)) {
                Tool::Redirect("/user/login", '登陆失败！', 'error');
            } else {
                echo Session::Get('phone');
                die;
                Tool::Redirect("/user/cp", '登陆成功！');
            }
        }
        return $this->render('login');
    }

    public function actionLogin1()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post(), 'LoginForm') && $model->login()) {
            echo Session::Get('phone') . '登录成功';

        } else {
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
            echo Session::Get('phone') . '注册成功并且登录成功';


        } else {
            echo "注册失败";
        }


        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /*
    * 退出登录
    * @param int $_SESSION['user_id'] 登录入口
    * @access public
    */
    public function actionlogout()
    {
        //if(isset($_SESSION['user_id'])) {
        session_unset();
        unset($_SESSION['user_id']);
        unset($_SESSION['phone']);
        User::NoRemember();
        //unset($_SESSION['oauth']);
        Tool::Redirect('/index.htm');
    }

    /**
     * 重设密码(修改密码)
     * @param int $user_id 登录入口
     * @access public
     */
    public function actionResetPassword()
    {
        $user_id = $_GET['user_id'];
        $user = User::GetUserById($user_id);
        if ($_POST) {
            $user_id = $_POST['user_id'];
            if ($_POST['password'] == $_POST['password2']) {
                $password = User::GenPassword($_POST['password']);
                $passwordold = User::getUsercheck(array('user_id' => $_POST['user_id'], 'password' => User::GenPassword($_POST['passwordold'])));
                if (!$passwordold) {
                    Tool::Redirect("user-reset-password?user_id={$user_id}", '旧密码有误！', 'error');
                }
                $sql = "update user set password='{$password}' WHERE user_id = '{$user_id}'";

                $res = Yii::$app->db->createCommand($sql)->query();
                if ($res) {
                    Tool::Redirect('user-reset-password?user_id={$user_id}', '密码修改成功', 'success');
                } else {
                    Tool::Redirect("user-reset-password?user_id={$user_id}", '修改密码失败！', 'error');
                }
            }
            Tool::Redirect("user-reset-password?user_id={$user_id}", '两次输入的密码不匹配，请重新设置', 'error');
        }
        return $this->render('resetpassword', [
            'user' => $user,
        ]);
    }


    /**
     * 验证用户名是否已经存在
     */
    public function actionUserByName()
    {

        if ($_GET['phone']) {
            if (User::GetUserByName($_GET['phone'])) {
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

    public function actionSend()
    {
        if ($_GET['phone']) {
            $mobile = $_GET['phone'];
            $verifyCode = rand(1000, 9999);
            //Session::Set('code',$verifyCode);
            Tool::cookieset("code", $verifyCode, "600");
            // echo Session::Get('vcode');die;
            $content = "【宝宝玩英语】您的验证码为：{$verifyCode}此验证码10分钟内有效，请尽快使用！";
            $result = Tool::Send($mobile, $content);
            if ($result) {
                $return = array(
                    'code' => 200,
                    // 'verifyCode' => Session::Get('code'),
                    'message' => '短信发送成功',
                );

            } else {
                $return = array(
                    'code' => -2,
                    'message' => '短信发送失败',
                );
            }

        } else {
            $return = array(
                'code' => -1,
                'message' => '没有获取手机号',
            );
        }

        die(json_encode($return));
    }


}