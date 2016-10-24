<?php
namespace app\models;


use Yii;
use yii\base\Model;



/**
 * ContactForm is the model behind the contact form.
 */
class SignupForm extends Model
{
    public $username;
    public $verifyCode;
    public $password;
    public $subject;



    /**
     * @return array the validation rules.    ['country', 'validateCountry'],
     */

        public function rules()
    {
        return [
            ['username', 'unique','targetClass'=>Member::className(),'message'=>'{attribute}已经被占用了'],
            ['username','match','pattern'=>'/^1[3458][\d]{9}$/','message'=>'{attribute}必须为1开头的11位纯数字'],
            [['username','password','verifyCode'],'required','message'=>'{attribute}不能为空'],
            [['verifyCode'], 'string','min'=>4, 'max' => 4,'message'=>'{attribute}位数为4位'],
            ['verifyCode','compare','compareValue' =>$_COOKIE[code],'operator'=>'==', 'message'=>'{attribute}输入有误'],
            [['password'], 'string','min'=>6, 'max' => 16,'message'=>'{attribute}位数为6至16位'],
            [['subject'], 'safe'],
        ];

    }
    /*
    **前台显示  ['age', 'compare', 'compareValue' => 30, 'operator' => '>='],
     */

    public function attributeLabels()
    {
        return [
            'username' =>'手机号',
            'verifyCode' => '验证码',
            'password' =>'密码',
            'subject'=> '课程列表',
        ];
    }

    public function getCourse()
    {
        $course = Course::getCourse(0);

        return $course;
    }


    /**
     * 生成form的表单获取的值，然后传递到member模板 进行数据处理
     * @return boolean whether the user is logged in successfully
     */
    public function signup()
    {
        if ($this->validate()) {

            $member = new Member();
            $user = array('username'=>$this->username,'password' => $this->password,'subject' => $this->subject);

            if(!$member->signup($user)){
                $this->addError( '注册失败，请重新注册');
            }else{
                return true;
            }
        }else{
            echo "meiyoutongguoyanz";
        }
    }
    

}