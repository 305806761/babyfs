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

class Member extends ActiveRecord
{
    const SECRET_KEY = '@4!@#$%@';



    /**
     * 创建用户
     * @param $user_row $array 需要设置的参数
     * @return $user_id int 用户ID 或则false
     * @access public
     */

    public function Signup($param){

        $this->username = $param['username'];
        $this->password = self::GenPassword($param['password']);

          //  var_dump($user);die;
            //用户信息插入数据库
            $user_id  = $this->save() ? Yii::$app->db->lastInsertID : '';
        if($user_id){
            $user = array('user_id' => $user_id, 'username' => $this->username);
            self::Remember($user);
        }
            $course_id = $param['subject'];
            // 关联用户和课程的关系
            if ($user_id && $course_id) {

                $result = Yii::$app->db->createCommand()->insert('course_user', [
                    'course_id' => $course_id,
                    'user_id' => $user_id,
                ])->execute();
                return $result ? $user_id : false;
            } else {
                return false;
            }

    }

    /**
     * 用户登录
     * @param $user_row $array 需要设置的参数
     * @return $user_id int 用户ID
     * @access public
     */
    public function login($param){

        if($param){
            $user = Member::findOne(['username' => $param['username'],'password' => self::GenPassword($param['password'])])->toArray();
            //   SELECT * FROM `member` WHERE `username`='15210663958' AND `password`='123456'
            if($user){
                $rememberMe = $param['rememberMe'] ? 3600*24*30 : 0;
                self::Remember($user,$rememberMe);
                return true;
            }else{
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
    static public function Remember($user,$rememberMe='7*86400') {
        Tool::cookieset('user_id', $user['user_id'], $rememberMe);
        Tool::cookieset('username', $user['username'], $rememberMe);
        Session::Set('user_id', $user['user_id']);
        Session::Set('username', $user['username']);
    }

    /**
     * 注销cookies
     * @param string 用户信息
     * @return str 注销cookies
     * @access public
     */
    static public function NoRemember($cookiename) {
        Tool::cookieset($cookiename, null, -1);
    }


    /**
     * 双重加密密码
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    static public function GenPassword($p) {
        return md5($p . self::SECRET_KEY);
    }

    /**
     * 查看用户名是否已经
     * @param string 密码
     * @return str 返回加密的用户密码
     * @access public
     */
    static public function GetUserByName($var) {
        $username = self::findOne(['username'=>$var]);
        return $username->user_id ? true : false;
    }

}