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
    public $password2;
    public $loginname;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username','required', 'on' =>['signup']],
            ['username', 'unique', 'targetClass' => 'app\models\User', 'message' => '{attribute}已经存在', 'on' =>['signup']],
            ['username','string', 'max'=>'255', 'on' =>['signup']],
            ['username','default', 'value' => ''],

            ['phone','required','on'=>['signup']],
            ['phone', 'string', 'min' => 11, 'max' => 11,'on'=>['signup']],
            // ['mobile','match','pattern'=>'/^1[34578][\d]{9}$/','message'=>'{attribute}必须为1开头的11位纯数字'],
            ['phone','default', 'value' => ''],// '/^'

            ['email','required','on'=>['signup']],
            //['email','match','pattern'=>'\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*','message' => '{attribute}格式不正确'], 'operator'=>'=='
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User', 'message' => '{attribute}已经存在', 'on' =>['signup']],
            ['email','default', 'value' => ''],

            [['password','password2'], 'required'],
            [['password','password2'], 'string', 'min' => 6],
            ['password2', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！'],

            ['loginname','required', 'on' =>['login']],
            ['loginname','string', 'max'=>'255', 'on' =>['login']],

            ['verifyCode','required', 'on' =>['signup']],
            ['verifyCode','number'],
            ['verifyCode','string', 'max'=>'4','min'=>'4', 'on' =>['signup']],

        ];
    }


    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'phone' => '手机号',
            'id' => '用户id',
            'email' => '邮箱',
            'loginname' => '用户名/电话/邮箱',
            'password' => '密 & 码',
            'verifyCode' => '验证码',
            'password2' => '确认密码',
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
        if (preg_match('/^1[34578][\d]{9}$/',$username)){

            return self::findOne(['phone' => $username]);

        } elseif (preg_match('/^[\w\-\.]+@[\w\-]+(\.\w+)+$/',$username)){

            return self::findOne(['email' => $username]);
        }
        else{
            return self::findOne(['username' => $username]);
        }
    }


    /**
     * 创建用户
     * @param $user_row $array 需要设置的参数
     * @return $user_id int 用户ID 或则false
     * @access public
     */

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

            if($user->password == self::GenPassword($password)){
                self::Remember($user);
                return true;
            }else{
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
        $user->password2 = '123456';
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

}