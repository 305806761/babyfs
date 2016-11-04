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
        if($password){
            $user->password = self::GenPassword($password);
        }
        if($phone){
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
    public function login($param)
    {

        if ($param) {
            $user = self::findOne(['phone' => $param['phone'], 'password' => self::GenPassword($param['password'])])->attributes;
            //print_r($user);die;
            //   SELECT * FROM `member` WHERE `username`='15210663958' AND `password`='123456'
            if ($user) {
                self::Remember($user);
                return true;
            } else {
                return false;
            }

        }
    }

    /**
     * 设置登录cookies
     * @param $user array 用户信息
     * @return str 返回用户cookies
     * @access public
     */
    static public function Remember($user, $rememberMe = '86400 * 365')
    {
        $user_rnd = self::GenLoginRnd($user['user_id'], $user['phone']);

        $user = User::findOne($user['user_id']);
        $user->rnd = $user_rnd;
        if ($user->update()) {
            //self::NoRemember('user_rnd');
            Tool::cookieset('user_rnd', $user_rnd, $rememberMe);
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
        $sql = "select c.name as course_name,cs.name as section_name,u.phone,u.created as user_created,uc.create_time,uc.expire_time,uc.section_id as section_id,uc.id as user_course_id  from";
        $sql .= " user_course as uc left join course as c on uc.course_id = c.course_id left join course_section as cs on uc.section_id = cs.section_id left join user as u on uc.user_id = u.user_id";
        $sql = $where ? $sql . $where : $sql;
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

}