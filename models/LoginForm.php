<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
        ];
    }


    /**
     * 生成form的表单获取的值，然后传递到member模板 进行数据处理
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            $member = new Member();
            $user = array('username'=>$this->username,'password' => $this->password,'rememberMe' => $this->rememberMe);
            if(!$member->login($user)){
                $this->addError( '用户名或密码输入有误');
            }else{
                return true;
            }
        }
    }
}
