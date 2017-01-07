<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 17/1/7
 * Time: 下午6:53
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\WapAsset;

$this->title = '忘记密码';
$this->params['breadcrumbs'][] = $this->title;
WapAsset::register($this);

$this->registerJs($js);
?>

<body class="register-body">
<?php $this->beginBody() ?>
<?php if($_COOKIE['notice']):?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['signuperror']):?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['signuperror'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['success']):?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt="" /></div>
<div class="register-con register-con1">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'phone', [
        'template' => '
                      <div class="r-input-box" style="padding-top:30px;">
                        <p>{input}</p>
                        {error}
                      </div>
                      ',
    ])->textInput([
        'class' => 'regiserNumber',
        'id' => 'phoneone',
        'maxlength' => '11',
        'minlength' => '11',
        'placeholder' => "手机号"
    ])->error(['class'=> 'prompt-error regiserNumberError']) ?>

    <?= $form->field($model, 'verifyCode', [
        'template' => '
                    <div class="r-input-box">
                    <p class="clearfix">
                        <span>{input}</span>
                        <span class="login-send" id="login-send">获取验证码</span>
                    </p>
                    {error}
                    </div>
                      ',
    ])->textInput([
        'class' => 'ReIdentifyingCode',
        'maxlength' => '4',
        'minlength' => '4',
        'placeholder' => "验证码"
    ])->error(['class'=>'prompt-error ReIdentifyingCodeError']) ?>

    <?= $form->field($model, 'password', [
        'template' => '
                      <div class="r-input-box">
                        <p>{input}</p>
                        {error}
                      </div>
                      ',
    ])->passwordInput([
        'class' => 'RegiserPassword',
        'maxlength' => '32',
        'minlength' => '6',
        'placeholder' => "密码"
    ])->error(['class'=>'prompt-error RegiserPasswordError"']) ?>

    <?= $form->field($model, 'repassword', [
        'template' => '
                      <div class="r-input-box r-input-box-six">
                        <p>{input}</p>
                        {error}
                      </div>
                      ',
    ])->passwordInput([
        'class' => 'RegiserPassword2 r-input-box-regiserPassword2',
        'maxlength' => '32',
        'minlength' => '6',
        'placeholder' => "确认密码"
    ])->error(['class'=>'prompt-error RegiserPasswordError2']) ?>

    <div class="RegiserBtn">
        <?= Html::buttonInput('提交', ['onclick'=>'javascript:this.form.submit()']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php $this->endBody() ?>
</body>
<?php
$this->registerJs("afterLoad();");
?>
<script type="text/javascript">
    function afterLoad()
    {
        //获取验证码
        var wait=60;
        //var inputLoginSend = document.getElementById("login-send");
        var inputLoginSend = $("#login-send");
        document.getElementById("login-send").disabled = false;
        function timeReg(o) {
            inputLoginSend.addClass("login-send-grey");
            if(wait==0){
                inputLoginSend.html("获取验证码");
                wait = 60;
                inputLoginSend.removeClass("login-send-grey");
            }else{
                inputLoginSend.html("重新发送(" + wait + ")");
                wait--;
                time = setTimeout(function() {
                        timeReg(o)
                    },
                    1000)
            }
        }


        $(function() {
            $(".login-send").click(function() {
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                var mobile = $("#phoneone").val();
                var obj = $(this);
                if (obj.hasClass('login-send-grey')) {
                    return false;
                } else {
                    timeReg(this);
                }
                $.ajax({
                    type: 'get',
                    url: '/user/send',
                    dataType: 'json',
                    data: {'phone':mobile,_csrf:csrfToken},
                    cache:false,
                    success: function(data){
                        if( data.status == 'success' ) {

                        } else {
                            clearTimeout(time)
                            obj.html("获取验证码").removeClass("login-send-grey");
                            wait = 60;
                            alert(data.message);
                        }
                    },
                    error: function(){
                        clearTimeout(time)
                        obj.html("获取验证码").removeClass("login-send-grey");
                        wait = 60;
                        alert('异常错误');
                    }
                });
            });
        });


        $(".J_Close").click(
            function () {
                $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                    $(this).slideUp(400);
                });
                <?php Yii::$app->session->remove('')?>
                return false;
            }
        );

    }
</script>
