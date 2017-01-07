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
                Tool::notice('账号或密码有误','loginerror');
                return $this->redirect('login');
            }
        } else {
            Tool::notice('账号或密码有误','loginerror');
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
    public function actionSignup()
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
                            Tool::notice('验证码输入有误','signuperror');
                            return $this->redirect('signup');
                        }
                    } else {
                        Tool::notice('验证码已经失效','signuperror');
                        return $this->redirect('signup');
                    }
                } else {
                    Tool::notice('请输入验证码','signuperror');
                    return $this->redirect('signup');
                }
                $userInfo = $model::findOne(['phone' => $model->phone]);
                if($userInfo){
                    if ($userInfo->password)
                    {
                        Tool::notice('用户已经存在','signuperror');
                        return $this->redirect('signup');
                    } else {
                        //$userInfo->password = $model::GenPassword($model->password);
                        //$userInfo->repassword = $model::GenPassword($model->repassword);
                        if ($model->password === $model->repassword) {
                            $userInfo->password = $model::GenPassword($model->password);
                            if($userInfo->save()){
                                //User::Remember($model);
                                //Tool::Redirect(User::get_loginpage());
                                return $this->redirect('login');
                            }else{
        //                        print_r($model->errors);
        //                        die;
                                Tool::notice('注册失败','signuperror');
                                return $this->redirect('signup');
                            }
                        } else {
                            Tool::notice('密码不一致','signuperror');
                            return $this->redirect('signup');
                        }

                    }

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
                        Tool::notice('注册失败','signuperror');
                        return $this->redirect('signup');
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
        return false;
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
                        $code = self::base64Encode(Yii::$app->security->encryptByKey($model->email, self::EMAIL_KEY));
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
        return false;
        $this->layout = 'user';
        if (Yii::$app->request->get('code'))
        {
            $code = Yii::$app->request->get('code');
            $email = Yii::$app->security->decryptByKey(self::base64Decode($code), self::EMAIL_KEY);
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
        $this->layout = 'user';
        $rnd = $_COOKIE['user_rnd'];
        $model = new User();
        $model->setScenario('resetpassword');
        if ($rnd) {
            $userInfo = User::findOne(['rnd' => $rnd]);
            if ($userInfo)
            {

                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $oldPassword = $model->oldpassword;
                    $password = $model->password;
                    $repassword = $model->repassword;
                    if ($oldPassword) {
                        $olderPassword = User::GenPassword($oldPassword);
                        $result = User::findOne(['rnd' => $rnd, 'password' => $olderPassword]);
                        if ($result)
                        {
                            if ($password === $repassword)
                            {
                                $newPassword = User::GenPassword($password);
                                $result->password = $newPassword;

                                if ($result->save())
                                {
                                    return $this->redirect('/user/default');
                                } else {
                                    Tool::Redirect("/user/reset-password", '修改密码失败！', 'passworderror');
                                }
                            } else {
                                Tool::Redirect("/user/reset-password", '两次密码不同！', 'passworderror');
                                //return $this->render('reset', [
                                //    'model' => $model,
                                //]);
                            }
                        } else {
                            //应该退出
                            Tool::Redirect("/user/reset-password", '原始密码不正确！', 'passworderror');
                            //return $this->render('reset', [
                            //    'model' => $model,
                            //]);
                        }
                    } else {

                        Tool::Redirect("/user/reset-password", '请输入旧密码！', 'passworderror');
                        //return $this->render('reset', [
                        //    'model' => $model,
                        //]);
                    }
                } else {
                    return $this->render('reset', [
                        'model' => $model,
                    ]);
                }
            } else {
                return $this->redirect('login');
            }

        } else {
            return $this->redirect('login');
        }
    }

    /**
     * @return string|\yii\web\Response
     * @修改用户资料
     */
    public function actionResetUser()
    {
        $this->layout = 'user';
        $rnd = $_COOKIE['user_rnd'];
        if ($rnd)
        {
            $model = new User();
            $model->setScenario('resetuser');
            $userInfo = User::findOne(['rnd' => $rnd]);
            if ($userInfo)
            {
                if ($model->load(Yii::$app->request->post()) && $model->validate())
                {
                    $userInfo->username = $model->username;
                    if ($userInfo->save())
                    {
                        //修改成功
                        return $this->redirect('/user/default');
                    } else {
                        //修改失败
                        return $this->render('change_info', [
                            'model' => $model,
                        ]);
                    }
                } else {
                    //默认或者提交信息验证失败
                    $userInfo->phone = substr_replace($userInfo->phone, '****', 3, 4);
                    return $this->render('change_info', [
                        'model' => $userInfo,
                    ]);
                }
            } else {
                //如果用户没登录，跳转到登录
                return $this->redirect('/user/login');
            }
        } else {
            //如果用户没登录，跳转到登录
            return $this->redirect('/user/login');
        }
    }

    public function actionForget()
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
                            Tool::notice('验证码输入有误','forgeterror');
                            return $this->redirect('forget-password');
                        }
                    } else {
                        Tool::notice('验证码已经失效','forgeterror');
                        return $this->redirect('forget-password');
                    }
                } else {
                    Tool::notice('请输入验证码','forgeterror');
                    return $this->redirect('forget-password');
                }
                $userInfo = $model::findOne(['phone' => $model->phone]);
                if($userInfo){
                    //$userInfo->password = $model::GenPassword($model->password);
                    //$userInfo->repassword = $model::GenPassword($model->repassword);
                    if ($model->password === $model->repassword) {
                        $userInfo->password = $model::GenPassword($model->password);
                        if($userInfo->save()){
                            //User::Remember($model);
                            //Tool::Redirect(User::get_loginpage());
                            return $this->redirect('login');
                        }else{
                            //                        print_r($model->errors);
                            //                        die;
                            Tool::notice('注册失败','forgeterror');
                            return $this->redirect('forget-password');
                        }
                    } else {
                        Tool::notice('密码不一致','forgeterror');
                        return $this->redirect('forget-password');
                    }

                } else {
                    Tool::notice('手机号有误','forgeterror');
                    return $this->redirect('forget-password');
                }
            }
        }
        return $this->render('forget_password',['model'=> $model]);
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

    public static function base64Encode($string) {
        $src  = array("/", "+", "&", "=");
        $dist = array("_a", "_b", "_c", "_d");
        $old  = base64_encode($string);
        $new  = str_replace($src,$dist,$old);
        return $new;
    }

    public static function base64Decode($string) {
        $src = array("_a", "_b", "_c", "_d");
        $dist  = array("/", "+", "&", "=");
        $old  = str_replace($src, $dist, $string);
        $new = base64_decode($old);
        return $new;
    }

}