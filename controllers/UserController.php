<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 10:42
 */

namespace app\controllers;

use app\models\CardModel;
use app\models\Section;
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

    const EMAIL_KEY= 'BABYENGLISH';
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
        if (Yii::$app->request->get('type') == 1) {
            //游客点击
            if ($user) {
                //如果用户登陆了，那么不能看游客的课
                $course = Course::getCourseSection($user->user_id);
            } else {
                //如果游客第一次点击，就设置cookie，否则
                if ($_COOKIE['isGuest'] == 1) {

                } else {
                    Tool::cookieset('isGuest', 1);
                }
                $course = Course::getGuestCourse();
            }

        } else {
            if ($_COOKIE['isGuest'] == 1) {
                if ($user) {
                    $course = Course::getCourseSection($user->user_id);
                } else {
                    $course = Course::getGuestCourse();
                }
            } else {
                if ($user) {
                    $course = Course::getCourseSection($user->user_id);
                } else {
                    Tool::Redirect("/user/login");
                }
            }

        }

        //echo "<pre>";
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
        $this->layout = 'user';
        $user = User::isLogin();
        if($user){
            Tool::Redirect(User::get_loginpage());
        }
        $model = new User();
        $model->setScenario('login');
        if($model->load(Yii::$app->request->post()) && $model->validate()){

            if($model->login($model->loginname,$model->password)){
                Tool::Redirect(User::get_loginpage());
            }else{
                Tool::notice('账号或密码有误','error');
                return $this->redirect('login');
            }
        } else {
            Tool::notice('账号或密码有误','error');
            return $this->render('login',['model'=> $model]);
        }
        return $this->render('login',['model'=> $model]);
    }


//    /**
//     * @return string
//     * @注册页面
//     */
//    public function actionSignup()
//    {
//        $this->layout = 'user';
//        $user = User::isLogin();
//        if($user){
//            Tool::Redirect(User::get_loginpage());
//        }
//        $model = new User();
//        return $this->render('signup',['model'=> $model]);
//    }


    /**
     * @return string|\yii\web\Response
     * @手机号注册
     */
    public function actionMobileSignup()
    {
        $this->layout = 'user';
        $model = new User();
        $model->setScenario('mobilesignup');
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                if ($model->verifyCode) {
                    //检查session是否打开
                    if (!Yii::$app->session->isActive) {
                        Yii::$app->session->open();
                    }
                    //取得验证码和短信发送时间session
                    $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
                    $signup_sms_time = Yii::$app->session->get('login_sms_time');
                    if (time() - $signup_sms_time < 600) {
                        if ($model->verifyCode != $signup_sms_code) {
                            Tool::notice('验证码输入有误','error');
                            return $this->redirect('mobile-signup');
                        }
                    } else {
                        Tool::notice('验证码已经失效','error');
                        return $this->redirect('mobile-signup');
                    }
                } else {
                    Tool::notice('请输入验证码','error');
                    return $this->redirect('mobile-signup');
                }
                $userInfo = $model::findByLogin($model->phone);
                if($userInfo->password){
                    Tool::notice('用户已经存在','error');
                    return $this->redirect('mobile-signup');
                } else {
                    $model->password = $model::GenPassword($model->password);
                    $model->repassword = $model::GenPassword($model->repassword);
                    if($model->save()){
                        //User::Remember($model);
                        //Tool::Redirect(User::get_loginpage());
                        return $this->redirect('login');
                    }else{
//                        print_r($model->errors);
//                        die;
                        Tool::notice('注册失败','error');
                        return $this->redirect('mobile-signup');
                    }
                }
            }
        }
        return $this->render('signup',['model'=> $model]);
    }

    /**
     * @return string|\yii\web\Response
     * @邮箱登陆
     */
    public function actionEmailSignup()
    {
        $this->layout = 'user';
        $model = new User();
        $model->setScenario('emailsignup');
        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                $userInfo = $model::findByLogin($model->email);
                if ($userInfo->user_id) {

                    Tool::notice('用户已经注册','error');
                    return $this->redirect('email-signup');
                } else {
                    $model->password = $model::GenPassword($model->password);
                    $model->repassword = $model::GenPassword($model->repassword);
                    if($model->save()){
                        $code = base64_encode(Yii::$app->security->encryptByKey($model->email, self::EMAIL_KEY));
                        //User::Remember($model);
                        //Tool::Redirect(User::get_loginpage());
                        $mail= Yii::$app->mailer->compose();
                        $mail->setTo($model->email); //要发送给那个人的邮箱
                        $mail->setSubject("宝宝玩英语帐户激活邮件"); //邮件主题
                        //$mail->setTextBody('测试text'); //发布纯文字文本
                        $mail->setHtmlBody("<br>您好!<br><br><br>
                        感谢您在宝宝玩英语注册帐户！<br><br><br>
                        帐户需要激活才能使用，赶紧激活成为宝玩正式的一员吧:<br><br><br>
                        点击下面的链接立即激活帐户(或将网址复制到浏览器中打开)：<br><br><br>
                        http://course.babyfs.cn/user/email-activate/?code=".$code."
                        )"); //发送的消息内容
                        if ($mail->send())
                        {
                            $msg = '请到您的注册邮箱'.$model->email.'收取激活邮件';
                            $result = ['title' => '注册成功', 'msg' => $msg];
                            return $this->render('signup_msg', ['model' => $result]);
                        } else {
                            $msg = '';
                            $result = ['title' => '发送邮件失败', 'msg' => $msg];
                            return $this->render('signup_msg', ['model' => $result]);
                        }
                        //return $this->redirect('login');
                    }else{
                        Tool::notice('注册失败','error');
                        return $this->redirect('email-signup');
                    }
                }
            }
        }
        return $this->render('signup', ['model' => $model, 'dada' => 1]);
    }


    /**
     * @return string
     * @邮箱激活验证
     */
    public function actionEmailActivate()
    {
        $this->layout = 'user';
        if (Yii::$app->request->get('code'))
        {
            $code = Yii::$app->request->get('code');
            $email = Yii::$app->security->decryptByKey(base64_decode($code), self::EMAIL_KEY);
            if ($email)
            {
                $userInfo = User::find()->where(['email' => $email, 'is_email' => 0])->one();
                if ($userInfo)
                {
                    $userInfo->is_email = 2;
                    if ($userInfo->save())
                    {
                        $result = ['title' => '激活成功', 'msg' => ''];
                        return $this->render('signup_msg', ['model' => $result]);
                    } else {

                        $result = ['title' => '激活失败', 'msg' => ''];
                        return $this->render('signup_msg', ['model' => $result]);
                    }
                } else {
                    $result = ['title' => '邮箱已经激活或未注册', 'msg' => ''];
                    return $this->render('signup_msg', ['model' => $result]);
                }
            } else {
                $result = ['title' => '链接有误', 'msg' => ''];
                return $this->render('signup_msg', ['model' => $result]);
            }
        } else {
            $result = ['title' => '链接无效', 'msg' => ''];
            return $this->render('signup_msg', ['model' => $result]);
        }
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
        User::NoRemember('isGuest');
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
            //Yii::info($mobile, 'test');
            if(preg_match("/1[34578]{1}\d{9}$/",$mobile)){
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
                        'status' => 'success',
                        // 'verifyCode' => Session::Get('code'),
                        'message' => '短信发送成功',
                    );
                } else {
                    $return = array(
                        'status' => 'error',
                        'message' => '短信发送失败',
                    );
                }
            } else {
                $return = array(
                    'status' => 'error',
                    'message' => '手机号格式错误',
                );
            }
        } else {
            $return = array(
                'status' => 'error',
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

    public function actionActivate(){
        $this->layout = 'webmain';
        $model = new CardModel();
        $userInfo = User::isLogin();


        if ($userInfo) {
            if ($model->load(Yii::$app->request->post())) {
                $cardInfo = CardModel::getCardStatus($model->code, $model->password, 1);
                if ($cardInfo) {
                    $cardInfos = CardModel::findOne(['code' => $model->code, 'password' => $model->password]);
                    $cardInfos->user_id = $userInfo->user_id;
                    $cardInfos->is_used = 1;
                    $cardInfos->is_useable = -1;

                    if ($cardInfos->save()) {
                        // ( [course_section_id] => Array ( [0] => 3,2,1 [1] => 4,2,1 ) [user_id] => 2 )
                        $result = Section::addPermit(['course_section_id' => '42,10,16'], $cardInfos->user_id, $cardInfos->expired_at);
                        if ($result) {
                            Tool::Redirect(User::get_loginpage());
                        } else {
                            Tool::notice('卡号或密码错误，请重新输入','error');
                            return $this->redirect('activate');
                        }

                    } else {
                        Tool::notice('卡号或密码错误，请重新输入','error');
                        return $this->redirect('activate');
                    }
                } else {
                    Tool::notice('卡号或密码错误，请重新输入','error');
                    return $this->redirect('activate');
                }
            }
        }
        return $this->render('activate', ['model' => $model]);
    }


}