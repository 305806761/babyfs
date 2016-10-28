<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>注册</title>
    <meta name="viewport"content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="/default/css/style.css" />
</head>
<body class="login-body">
<div class="register-con">
    <form action="/user/signup" method="post">
    <div class="l-input-box">
        <p><input type="text" placeholder="用户名/手机号" maxlength="11" name="phone" id="phone" class="regiserNumber"></p>
        <p class="prompt-error regiserNumberError"></p>
    </div>
    <div class="r-input-box">
        <p class="clearfix">
            <span><input type="text" placeholder="验证码" maxlength="6" name="verifyCode" class="ReIdentifyingCode" id="verifyCode"></span>
            <span><button onclick="send();return false;">获取验证码</button></span>
        </p>
        <p class="prompt-error ReIdentifyingCodeError"></p>
    </div>
    <div class="l-input-box">
        <p><input type="password" placeholder="密码" maxlength="32" name="password" id="password" class="RegiserPassword"></p>
        <p class="prompt-error RegiserPasswordError"></p>
    </div>
    <div class="l-input-box">
        <p><input type="password" placeholder="确认密码" maxlength="32" name="password2" id="password2" class="RegiserPassword2"></p>
        <p class="prompt-error RegiserPasswordError2"></p>
    </div>
    <div class="RegiserBtn"><input type="submit" value="注册"/></div>
    </form>
</div>
<div class="l-sign-icon"><img src="/default/img/sign-icon.png" alt=""></div>

<script src="/default/js/public/jquery-1.9.1.min.js"></script>
<script src="/default/js/public/effect.js"></script>

<script>
    function send(){
        var phone =  $("#phone").val() ;
        $.ajax({
            type: "get",
            url: "/user/send",
            data: "phone="+phone,
            cache:false,
            dataType: "json",
            success: function(data){
                var response = data;
                if(response.cood = '0'){
                    $(".regiserNumberError").html(data.message);
                }
            }
        });
    }
        //两次密码是否一致
        $("#password2").blur(function(){
            var password2 = $("#password2").val();
            var password = $("#password").val();
            if (password2 != password) {
                $(".RegiserPasswordError2").html("确认密码和设置密码不一致");
            }
        });
        //验证码是否正确
        $("#verifyCode").blur(function(){
            var verifyCode = $("#verifyCode").val();
            $.ajax({
                type: "get",
                url: "/user/check-code",
                data: "code="+verifyCode,
                cache: false,
                dataType:  "json",
                success: function(data){
                    var response = data;
                    if(response.cood = '0'){
                        $(".ReIdentifyingCodeError").html(data.message);
                    }
                }
            });
        });
</script>
</body>
</html>
