<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录</title>
    <meta name="viewport"content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="/default/css/style.css"/>
</head>
<body class="login-body">
<form method="post" action="/user/login">
<div class="login-con">
    <div class="l-input-box">
        <p><input type="text" name="phone" placeholder="用户名/手机号" class="loginphoneNumber" maxlength="11"></p>
        <p class="prompt-error loginphoneNumberError"></p>
    </div>
    <div class="l-input-box">
        <p><input type="password" name="password" placeholder="密码"class="loginpassWord" maxlength="32"></p>
        <p class="prompt-error loginpassWordError"></p>
    </div>
    <div class="l-input-btn"><input type="submit" value="登陆"></div>
    <div class="l-input-link"><a href="/user/signup">注册</a> | <a href="/user/signup">忘记密码</a> |<a href="/user/user-course/?type=1">游客登陆</a></div>
</div>
</form>
<div class="l-sign-icon"><img src="/default/img/sign-icon.png" alt=""></div>
<script src="/default/js/public/jquery-1.9.1.min.js"></script>
<script src="/default/js/public/effect.js"></script>
</body>
</html>
