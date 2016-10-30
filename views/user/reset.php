<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>修改用户信息</title>
    <meta name="viewport"content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="/default/css/style.css" />
    <style>
        .sysmsg{clear:both;position:relative;width:90%;margin:8px auto;}
        .sysmsg p{font-size:16px;color:#f60;padding:8px 0 8px 40px;background:#f9feda url(/default/img//sysmsg.png) no-repeat 10px 10px;border:1px solid #fc0;}
        .sysmsg-success p{color:#690;background:#eefcd3 url(/default/img/sysmsg.png) no-repeat 10px -24px;border:1px solid #990;}
        .sysmsg-error p{color:#f00;background:#feeada url(/default/img/sysmsg.png) no-repeat 10px -58px;border:1px solid #f00;}
        .sysmsg.inbox p{width:690px;}.sysmsg .close{position:absolute;top:12px;right:8px;background:url(/default/img/sysmsg.png) no-repeat 100% 100%;text-indent:-99px;cursor:pointer;display:block;width:16px;height:16px;overflow:hidden;}
        .sysmsg.inbox .close{right:260px;}
    </style>
</head>
<body class="login-body">
<?php if($_COOKIE['notice']):?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['error']):?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['error'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['success']):?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<div class="register-con">

        <?php if(isset($this->params['user'])): ?>
    <form action="/user/reset-user" method="post">
        <div class="l-input-box">
            <p><input type="text" placeholder="用户名/手机号" maxlength="11" name="phone" value="<?= $user->phone ?>" id="phone" class="regiserNumber"></p>
            <p class="prompt-error regiserNumberError"></p>
        </div>
        <?php endif ?>
        <?php if(isset($this->params['password'])): ?>
        <form action="/user/reset-password" method="post">
        <div class="l-input-box">
            <p><input type="password" placeholder="旧密码" maxlength="32" name="passwordold"  class="RegiserPassword"></p>
            <p class="prompt-error RegiserPasswordError"></p>
        </div>

        <div class="l-input-box">
            <p><input type="password" placeholder="密码" maxlength="32" name="password" id="password" class="RegiserPassword"></p>
            <p class="prompt-error RegiserPasswordError"></p>
        </div>
        <div class="l-input-box">
            <p><input type="password" placeholder="确认密码" maxlength="32" name="password2" id="password2" class="RegiserPassword2"></p>
            <p class="prompt-error RegiserPasswordError2"></p>
        </div>
        <?php endif ?>
            <input type="hidden" name="user_id" value="<?= $user->user_id ?>" />
        <div class="RegiserBtn"><input type="submit" value="提交"/></div>
    </form>
</div>
<div class="l-sign-icon"><img src="/default/img/sign-icon.png" alt=""></div>

<script src="/default/js/public/jquery-1.9.1.min.js"></script>
<script src="/default/js/public/effect.js"></script>

<script>
    $(".J_Close").click(
        function () {
            $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                $(this).slideUp(400);
            });
            <?php Yii::$app->session->remove('')?>
            return false;
        }
    );
    //两次密码是否一致
    $("#password2").blur(function(){
        var password2 = $("#password2").val();
        var password = $("#password").val();
        if (password2 != password) {
            $(".RegiserPasswordError2").html("确认密码和设置密码不一致");
        }
    });
</script>
</body>
</html>
