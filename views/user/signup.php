<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
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
            <span><input href="javascript:;" class="login-send" id="login-send" value="获取验证码"></span>
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
    <div class="RegiserBtn"><input type="submit" value="提交"/></div>
    </form>
</div>
<div class="l-sign-icon"><img src="/default/img/sign-icon.png" alt=""></div>

<script src="/default/js/public/jquery-1.9.1.min.js"></script>
<script src="/default/js/public/effect.js"></script>

<script>
    //获取验证码
    var wait=60;
    //var inputLoginSend = document.getElementById("login-send");
    var inputLoginSend = $("#login-send");
    document.getElementById("login-send").disabled = false;
    function timeReg(o) {
        inputLoginSend.addClass("login-send-grey");
        if (wait == 0) {
            o.removeAttribute("disabled");
            o.value="获取验证码";
            wait = 60;
            inputLoginSend.removeClass("login-send-grey");
        } else {
            o.setAttribute("disabled", true);
            o.value="重新发送(" + wait + ")";
            wait--;
            time = setTimeout(function() {
                timeReg(o)
            },1000)
        }
    }

    $(function() {
        $(".login-send").click(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr("content");
            var mobile = $("#phone").val();
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
                        obj.attr("disabled",false);
                        obj.text("获取验证码").removeClass("login-send-grey");
                        wait = 60;
                        alert(data.message);
                    }
                },
                error: function(){
                    clearTimeout(time)
                    obj.attr("disabled",false);
                    obj.text("获取验证码").removeClass("login-send-grey");
                    wait = 60;
                    alert('异常错误');
                }
            });
        });
    });


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
