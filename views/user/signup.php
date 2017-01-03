<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册';
$signup = true;
$this->params['breadcrumbs'][] = $this->title;
?>
<body class="register-body">
<div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt="" /></div>
<div class="register-con">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username', [
        'template' => '
          <div class="r-input-box r-input-box-one">
            <p>{input}</p>
            {error}
          </div>
          ',
    ])->textInput([
        'class' => 'loginUser',
        'maxlength' => '255',
        'minlength' => '2',
        'placeholder' => "用户名"
    ]) ->error(['class'=> 'prompt-error loginphoneNumberError'])
    ?>

    <?= $form->field($model, 'email', [
        'template' => '
          <div class="r-input-box r-input-box-two">
            <p>{input}</p>
            {error}<p id="cellphoneChange">邮<br>箱<br>注<br>册</p>
          </div>
         
          ',
    ])->textInput([
        'class' => 'regiserEmail',
        //'maxlength' => '11',
        //'minlength' => '11',
        'placeholder' => "邮箱"
    ])->error(['class'=>'prompt-error regiserEmailError']) ?>

    <?= $form->field($model, 'phone', [
        'template' => '
          <div class="r-input-box r-input-box-three">
            <p>{input}</p>
            {error}
          </div>
          ',
    ])->textInput([
        'class' => 'regiserNumber',
        'id'=> 'phone',
        'maxlength' => '11',
        'minlength' => '11',
        'placeholder' => "手机号"
    ])->error(['class'=> 'prompt-error regiserNumberError']) ?>

    <?= $form->field($model, 'verifyCode', [
        'template' => '
        <div class="r-input-box r-input-box-four">
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
          <div class="r-input-box r-input-box-five">
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

    <?= $form->field($model, 'password2', [
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
        <?= Html::buttonInput('注册', ['onclick'=>'javascript:this.form.submit()']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs("afterLoad();");
?>

<script type="text/javascript">



    function afterLoad()
    {
        $("#login-send").click(function () {
            alert('s');
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var mobile = $("#phone").val();
            var obj = $(this);
            alert('s');
            if (obj.hasClass('login-send-grey')) {
                return false;
            } else {
                codeSend();
            }

            $.ajax({
                type: 'get',
                url: '/user/send',
                dataType: 'json',
                data: {'phone': mobile, _csrf: csrfToken},
                cache: false,
                success: function (data) {

                    if (data.status == 'success') {

                    } else {
                        clearTimeout(time)
                        obj.attr("disabled", false);
                        obj.text("获取验证码").removeClass("login-send-grey");
                        wait = 60;
                        alert(data.message);
                    }
                },
                error: function () {
                    clearTimeout(time)
                    obj.attr("disabled", false);
                    obj.text("获取验证码").removeClass("login-send-grey");
                    wait = 60;
                    alert('异常错误');
                }
            });
        });





        //验证码是否正确
        $(".ReIdentifyingCode").blur(function () {
            var verifyCode = $(".ReIdentifyingCode").val();
            $.ajax({
                type: "get",
                url: "/user/check-code",
                data: "code=" + verifyCode,
                cache: false,
                dataType: "json",
                success: function (data) {
                    if (data.statu == 'success') {
                        alert(data.message);
                    } else {
                        clearTimeout(time)
                        obj.attr("disabled", false);
                        obj.text("获取验证码").removeClass("login-send-grey");
                        wait = 60;
                        alert(data.message);
                        //$(".ReIdentifyingCodeError").html(data.message);
                    }
                },
                error: function () {
                    clearTimeout(time)
                    obj.attr("disabled", false);
                    obj.text("获取验证码").removeClass("login-send-grey");
                    wait = 60;
                    alert(data.message);
                    //$(".ReIdentifyingCodeError").html('异常错误');
                }
            });
        });
    }
</script>
