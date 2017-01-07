<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 10:40
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\data\Pagination;

class User extends ActiveRecord
{
    const SECRET_KEY = '@4!@#$%@';
    public $verifyCode;
    public $repassword;
    public $loginname;
    public $oldpassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['username','required', 'on' =>['signup']],
            //['username', 'unique', 'targetClass' => 'app\models\User', 'message' => '{attribute}已经存在', 'on' =>['signup']],
            ['username', 'validateUserName'],
            ['username','default', 'value' => ''],

            ['phone','required','on'=>['mobilesignup']],
            ['phone', 'string', 'min' => 11, 'max' => 11,'on'=>['mobilesignup']],
            ['phone','match','pattern'=>'/^1[34578][\d]{9}$/','message'=>'{attribute}必须为1开头的11位纯数字'],
            //['phone', 'unique', 'targetClass' => 'app\models\User', 'message' => '{attribute}已经存在'],
            ['phone','default', 'value' => ''],

            ['email','required','on'=>['emailsignup']],
            //['email','match','pattern'=>'\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*','message' => '{attribute}格式不正确'], 'operator'=>'=='
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => '{attribute}已经存在', 'on' =>['emailsignup']],
            ['email','default', 'value' => ''],

            [['password'], 'required','on'=>['mobilesignup', 'emailsignup', 'resetpassword']],
            [['password','repassword'], 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！','on'=>['emailsignup', 'mobilesignup']],

            ['oldpassword', 'required','on'=>['resetpassword']],
            ['oldpassword', 'string', 'min' => 6],
            ['oldpassword', 'default', 'value' => ''],

            ['loginname','required', 'on' =>['login']],
            ['loginname','string', 'max'=>'255', 'on' =>['login']],

            ['verifyCode','required', 'on' =>['mobilesignup']],
            ['verifyCode','number', 'on' => ['mobilesignup']],
            ['verifyCode','string', 'max'=>'4','min'=>'4', 'on' =>['mobilesignup']],

            ['is_email', 'default', 'value' => 0],
            ['is_email', 'in', 'range' => [0, 2]],



        ];
    }

    public function validateUserName($attribute, $params)
    {
        Yii::info($params, 'test');
        if (preg_match('/^\d{6,20}$/', $this->$attribute, $matches)) {
            //Yii::info('aaaa', 'test');
            $this->addError($attribute,'不能是纯数字');
            return false;
        } else if (!preg_match('/^[\x80-\xffa-zA-Z0-9—_]{4,20}$/', $this->$attribute, $matches)){
            $this->addError($attribute,'支持中文、字母、数字、“-”“_”的组合，4-20个字符');
            return false;
        }
        return true;
        //return $validate ? null : ['有错误请', [$this->message]];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'phone' => '手机号',
            'id' => '用户id',
            'email' => '邮箱',
            'loginname' => '用户名',
            'password' => '密码',
            'verifyCode' => '验证码',
            'repassword' => '确认密码',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Finds user by username or phone or email
     * @param $username
     * @return static
     */
    public static function findByLogin($username)
    {
        $result = [];
        if (preg_match('/^1[34578][\d]{9}$/',$username)){
            $result = ['result' => self::findOne(['phone' => $username]), 'type' => 'phone'];
        } else if (preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/',$username)){
            $result = ['result' => self::findOne(['email' => $username]), 'type' => 'email'];
        } else {
            $result = ['result' => self::findOne(['username' => $username]), 'type' => 'username'];
        }
        return $result;
    }



    public static function Signup($param)
    {
        $user = self::GetUserByName($param['phone']);
        $user->phone = $param['phone'];
        $user->password = $param['password'] ? self::GenPassword($param['password']) : '';
        //var_dump($user);die;
        //用户信息插入数据库
        //$user_id  = $user->save() ? Yii::$app->db->lastInsertID : '';
        if ($user->save()) {
            $user_id = Yii::$app->db->lastInsertID ? Yii::$app->db->lastInsertID : $user->user_id;
        }
        // var_dump($user_id);die;
        if ($user_id) {
            $user = array('user_id' => $user_id, 'phone' => $user->phone);
            self::Remember($user);
        }
        return $user_id;

    }

    /***
     * 添加模板分类
     ***/
    static public function modify(self $user, $phone, $password)
    {
        if ($password) {
            $user->password = self::GenPassword($password);
        }
        if ($phone) {
            $user->phone = $phone;
        }
        if ($user->save()) {
            return true;
        }
        return false;
    }


    /**
     * 用户登录
     * @param $user_row $array 需要设置的参数
     * @return $user_id int 用户ID
     * @access public
     */
    public function login($username,$password)
    {
        if ($username && $password) {
            $user = self::findByLogin($username);
            $result = $user['result'];
            if ($result)
            {
                if ($user['type'] == 'email')
                {
                    if ($result->is_email == 2) {
                        if($result->password == self::GenPassword($password)){
                            self::Remember($result);
                            return true;
                        }else{
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    if($result->password == self::GenPassword($password)){
                        self::Remember($result);
                        return true;
                    }else{
                        return false;
                    }
                }
            } else {
                return false;
            }


        }else{
            return false;
        }
    }

    /**
     * @param $user
     * @param int $rememberMe
     */
    static public function Remember($user, $rememberMe = 86400 * 365)
    {
        $user_rnd = self::GenLoginRnd($user->user_id, $user->phone);

        $user = User::findOne($user->user_id);
        $user->rnd = $user_rnd;
        //$user->repassword = '123456';
        if ($user->save()) {
            //self::NoRemember('user_rnd');
            Tool::cookieset('user_rnd', $user_rnd, $rememberMe);
        }else{
            print_r($user->errors);die;
            return false;
        }
    }

    /**
     * 注销cookies
     * @param string 用户信息
     * @return str 注销cookies
     * @access public
     */
    static public function NoRemember($cookiename)
    {
        Tool::cookieset($cookiename, null, -1);
    }

    static function get_loginpage($default = null)
    {
        if (Yii::$app->session->isActive) {
            Yii::$app->session->open();
        }
        $loginpage = Yii::$app->session->get('loginpage');
        if ($loginpage)
            return $loginpage;
        if ($default)
            return $default;
        return '/user/user-course';
    }


    /**
     * 双重加密密码
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    static public function GenPassword($p)
    {
        return md5($p . self::SECRET_KEY);
    }

    /**
     * 登陆认证令牌
     * @param string 密码
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    static public function GenLoginRnd($user_id, $phone)
    {
        $string = $user_id . $phone . time() . rand(100, 999);
        return md5($string);
    }


    /**
     * 查看用户名是否已经
     * @param string $var
     * @return object 返回用户id
     * @access public
     */
    static public function GetUserByName($var)
    {
        if (!$user = self::findOne(['phone' => $var])) {
            $user = new User();
        }
        return $user;
    }

    /**
     * 查看通过id用户是否存在
     * @param string $user_id
     * @return $user array
     * @access public
     */
    static public function GetUserById($user_id)
    {
        $username = self::findOne(['user_id' => $user_id]);
        return $username;
    }

    static public function isLogin()
    {
        $user_rnd = isset($_COOKIE['user_rnd']) ? $_COOKIE['user_rnd'] : '';
        //是否已经登陆
        if (!$user_rnd) {
            return false;
        }
        $user = User::findOne(['rnd' => $user_rnd]);
        if (!$user) {
            return false;
        }

        return $user;
    }

    /**
     * 查看通过id用户是否存在
     * @param string $user_id ,$password
     * @return $user array
     * @access public
     */
    static public function getUsercheck($param)
    {

        $username = self::findOne(['user_id' => $param['user_id'], 'password' => $param['password']]);
        return $username->user_id;
    }


    /**
     * 查看用户课程列表
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    static public function getUserCourse($where = '')
    {
        $sql = "select c.name as course_name,s.name as section_name,u.phone,u.created as user_created,
        uc.create_time,uc.expire_time,uc.section_id as section_id,uc.id as user_course_id  from";
        $sql .= " user_course as uc left join course as c on uc.course_id = c.course_id 
        left join section as s on uc.section_id = s.section_id left join user as u on uc.user_id = u.user_id";
        $sql = $where ? $sql . $where : $sql;
        $sql = $sql . ' order by uc.id desc';
        $result = Yii::$app->db->createCommand($sql)->query();

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $result->rowCount,
        ]);
        $result = Yii::$app->db->createCommand($sql . " LIMIT $pagination->offset,$pagination->limit");
        $user_course = $result->queryAll();
        $course = array('user_course' => $user_course, 'page' => $pagination);
        //var_dump($course);die;
        return $course;
    }

    /**
     * 验证section是否有权限
     * @param string $user_id
     * @param string $section_id
     * @param string $term_id
     * @return boolen
     * @access public
     */
    static public function checkPermitSection($user_id, $section_id = '', $term_id = '')
    {

        if ($section_id && $term_id) {
            $query = UserCourse::find()
                ->where(['uc.user_id' => $user_id, 'uc.section_id' => $section_id, 'uc.term_id' => $term_id])
                ->from(['uc' => UserCourse::tableName()]);
            $query->joinWith(['term' => function ($query) {
                $query->select('end_time');
            }]);
            $section_ware = $query->asArray()->all();

            if (!$section_ware) {
                return false;
            }
            $newtime = time();
            foreach ($section_ware as $value) {
                //$expire_time = $value['term']['end_time']; //从学期表查询时间
                $expire_time = strtotime($value['expire_time']); //从user_course表查询时间
            }
            if (!$expire_time) {
                return false;
            }
            //print_r($expire_time);die;
            if ($newtime >= $expire_time) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * 验证ware是否有权限
     * @param string $user_id
     * @param string $ware_id
     * @return boolen
     * @access public
     */

    static public function checkPermitWare($user_id, $ware_id = '')
    {
        if ($ware_id) {
            $cat = CourseWare::find()->where(['ware_id' => $ware_id]);
            $cat->joinWith(['sectionCat' => function ($cat) {
                //$cat->select('section_id,term_id');
            }]);
            $usercat = $cat->asArray()->all();//6,1,3
            $usercourse = UserCourse::find()->where(['user_id' => $user_id])->asArray()->all();
            foreach ($usercourse as $value) {
                if (!$value['section_id']) {
                    continue;
                }

                foreach ($usercat as $val) {
                    //print_r($val);die;
                    if (!$val['sectionCat']['section_id']) {
                        continue;
                    }
                    if ($value['section_id'] == $val['sectionCat']['section_id']) {
                        $end_time[] = strtotime($value['expire_time']); //user_course 获取时间
                       /* $end_time = TermModel::find()->select('end_time')
                            ->where(['section_id' => $value['section_id'], 'id' => $value['term_id']])
                            ->asArray()->one();*/
                    } else {
                        continue;
                    }
                }
            }

            if (is_array($end_time) && max($end_time)) {
                $newtime = time();
                if ($newtime >= $end_time) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * 验证游客ware是否有权限
     * @param string $user_id
     * @param string $ware_id
     * @return boolen
     * @access public
     */

    static public function checkGuestWare($section_id=0, $ware_id = 0)
    {
        if ($ware_id && $section_id) {
            $cat = CourseWare::find()->where(['ware_id' => $ware_id]);
            $cat->joinWith(['sectionCat' => function ($cat) {
                //$cat->select('section_id,term_id');
            }]);
            $usercat = $cat->asArray()->all();//6,1,3
            if ($usercat) {

                foreach ($usercat as $uKey => $uVal) {
                    if ($uVal['sectionCat']['section_id'] == 13) {
                        return true;
                    } else {
                        continue;
                    }
                }
            }
        }
        return false;
    }

    /** 验证免费列表是否有权限查看
     * @param int $section_id
     * @param int $term_id
     * @return bool
     */
    static public function checkFreeSection($section_id = 0, $term_id = 0,$t_time)
    {
        if ($term_id && $section_id && $t_time) {
            $term = TermModel::findOne(['section_id' => $section_id, 'id' => $term_id]);
            if ($term) {
                if (!$term->end_time) {
                    return false;
                }
                $newtime = time();
                if ($newtime < $term->end_time && $t_time== $term->end_time) {
                    return true;
                }else{
                    return false;
                }
            } else {
                return false;
            }

        }
        return false;
    }

    /**
     * 免费ware是否有权限
     * @param string $user_id
     * @param string $ware_id
     * @return boolen
     * @access public
     */

    static public function checkFreeWare($section_id=0, $ware_id = 0)
    {
        if ($ware_id && $section_id) {
            $cat = CourseWare::find()->where(['ware_id' => $ware_id]);
            $cat->joinWith(['sectionCat' => function ($cat) {
                //$cat->select('section_id,term_id');
            }]);
            $usercat = $cat->asArray()->all();//6,1,3
            if ($usercat) {

                foreach ($usercat as $uKey => $uVal) {
                    if ($uVal['sectionCat']['section_id'] == $section_id) {
                        return true;
                    } else {
                        continue;
                    }
                }
            }
        }
        return false;
    }

}