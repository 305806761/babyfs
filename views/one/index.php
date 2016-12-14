<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 下午6:34
 */

use yii\helpers\Url;
use yii\web\View;


use yii\widgets\ActiveForm;

app\assets\LoginAsset::register($this);
$this->title = '登录';
$this->registerJs("

//
//        var wait=60;
//        $(\".code\").click(function(){
//            send();
//        })
//        function send() {
//            if (wait == 0) {
//                $('#sendcode').removeAttr('disabled').removeClass('send').text('发送验证码');
//                wait = 60;
//            } else {
//                $('#sendcode').attr(\"disabled\", true).addClass('send').text(wait + \"s重新发送\");
//                wait--;
//                setTimeout(function() {
//                        send()
//                    },
//                1000)
//            }
//        }
");



$this->registerJs('
var waitReg = 60;
function timeReg(o) {

var obj = $("#sendcode");
if (waitReg == 0) {
obj.attr("disabled",false);
obj.text("获取验证码").removeClass("send");
waitReg = 60;
} else {
obj.attr("disabled",true);
obj.text("重新发送(" + waitReg + "s)").addClass("send");
waitReg--;
time = setTimeout(function() {
timeReg(o)
},
1000)
}
}', \yii\web\View::POS_HEAD);


$this->registerJs("
$(function() {
$(\"#sendcode\").click(function() {
var csrfToken = $('meta[name=\"csrf-token\"]').attr(\"content\");
var mobile = $(\"#mobilemodel-mobile\").val();
var obj = $(this);

if (obj.hasClass('send')) {
return false;
} else {
timeReg();
}

$.ajax({
type: 'post',
url: '/money/send',
dataType: 'json',
data: {'mobile':mobile,_csrf:csrfToken},
success: function(data){

if( data.status == 'success' ) {

} else {
clearTimeout(time)
obj.attr(\"disabled\",false);
obj.text(\"获取验证码\").removeClass(\"send\");
waitReg = 60;
alert(data.msg);
}
},
error: function(){
    clearTimeout(time)
    obj.attr(\"disabled\",false);
    obj.text(\"获取验证码\").removeClass(\"send\");
    waitReg = 60;
    alert('异常错误');
    }
    });
    });
});




");



?>

<div data-role="content" id="frombox">
    <h1>会员提现</h1>
    <p>输入手机号码，点击进入页面</p>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        //'enableAjaxValidation' => true,
        //'enableClientValidation' => true,
        'action' => ['/money/login'],
        'options' => [
            'class' => 'form-horizontal login-form',
            'data' => ['ajax' => 'false'],
        ],
        'fieldConfig' => [
            'inputOptions' => ['class'=>'inputtext'],

        ],
    ]); ?>


    <?= $form->field($model, 'id', [
        'template' => '<div class="unbox">
                            <label>手机号码</label>
                            <div class="inputbox">
                                {input}
                                <span class="red">{error}</span>
                            </div>
                        </div>',
    ])->textInput([
        'placeholder' => '请输入手机号码',
    ]) ?>

    <?= $form->field($model, 'nickname', [

        'template' => '<div class="unbox">
                            <label>验证码</label>
                            <div class="inputbox">
                                {input}
                                <a href="javascript:;" data-role="none" class="code"  id="sendcode" >发送验证码</a>
                                <span class="red">{error}</span>
                            </div>
                        </div>',
    ])->textInput([
        'placeholder' => '请输入验证码',
    ]) ?>

    <button>申请提现</button>
    <?php ActiveForm::end(); ?>
</div>
