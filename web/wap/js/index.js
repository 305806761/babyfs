var effect=(function(){
    function init(){
        showHide();
        Verification();
        showBigImg();
    }
function showBigImg(){
    $(".introduce2-center-bot img").click(function(){
        var imgUrl1 = $(this).attr("src");
        var imgOffsetTop = $(this).offset().top;
        // imgUrl2 = "url(" + imgUrl1 + ")";
        imgUrl2 = imgUrl1;
        $(".imgChangeBigK").css({"top":imgOffsetTop-100}).show();
        // $("#imgChangeBig").css({"background-image":imgUrl2});
        $("#imgChangeBig img").attr("src",imgUrl2);
        var opacity60BgHeight = $("#imgChangeBig").height();
        opacity60BgHeight = parseInt(opacity60BgHeight) + "px";
        // alert(opacity60BgHeight);
        $(".tmBgOpacity60").height(opacity60BgHeight);
    })

    $(".imgChangeBigK").click(function(){
        $(".imgChangeBigK").hide();
    })
}

    function showHide(){
       $(".course-list-con-top").click(function(){
           if($(this).siblings(".course-list-con-bottom").is(":hidden")){
               $(this).siblings(".course-list-con-bottom").css("display","block");
           }else{
               $(this).siblings(".course-list-con-bottom").css("display","none");
           }
       });
    }
    function Verification(){
        $("input").blur(function(){
            if($(this).is(".loginUser")){
                var loginUser = $(this).val();
                if(loginUser==""){
                    $(".loginphoneNumberError").html("请输入用户名!");
                }else{
                    $(".loginphoneNumberError").html("");
                }
            }
            /*if($(this).is(".loginphoneNumber")){
                var objvalue=$(this).val();
                var regx=/^(?:13\d|15\d|17\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/
                if(objvalue==""){
                    $(".loginphoneNumberError").html("请输入手机号码!");
                }
                else if(regx.test(objvalue)){
                    $(".loginphoneNumberError").html("");
                }else{
                    $(".loginphoneNumberError").html("请输入正确手机号!");
                }
            }*/
            if($(this).is(".loginpassWord")){
                var passWordError=$(".loginpassWordError");
                var passWord=$(".loginpassWord").val();
                if(passWord==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord.length<6 || passWord.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            //手机注册
            if($(this).is(".regiserNumber")){
                var objvalue=$(this).val();
                var regx=/^(?:13\d|15\d|17\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/
                if(objvalue==""){
                    $(".regiserNumberError").html("请输入手机号码!");
                    // $(".ReIdentifyingCode").attr("disabled","disabled"); 
                    $("#login-send").unbind("click");
                }
                else if(regx.test(objvalue)){
                    $(".regiserNumberError").html("");
                    $("#login-send").bind("click", function(){
                        codeSend();
                    })
                }else{
                    $(".regiserNumberError").html("请输入正确手机号!");
                }
            }
            if($(this).is(".ReIdentifyingCode")){
                var ReIdentifyingCode=$(".ReIdentifyingCode").val();
                var ReIdentifyingCodeError=$(".ReIdentifyingCodeError");
                if(ReIdentifyingCode==""){
                    ReIdentifyingCodeError.html("<b style='color: #ff5a5f' class='error'>请输入验证码!</b>")
                }else{
                    ReIdentifyingCodeError.html("<b style='color: #008e23'></b>");
                }
            }
            if($(this).is(".RegiserPassword")){
                var passWordError=$(".RegiserPasswordError");
                var passWord=$(".RegiserPassword").val();
                if(passWord==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord.length<6 || passWord.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            if($(this).is(".RegiserPassword2")){
                var passWordError=$(".RegiserPasswordError2");
                var passWord=$(".RegiserPassword").val();
                var passWord2=$(".RegiserPassword2").val();
                // var passWord2a=$(".r-input-box-regiserPassword2").val();
                if(passWord2==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord2.length<6 || passWord2.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }else if(passWord2!=passWord){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>两次密码不一致!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            //邮箱注册
            if($(this).is(".regiserEmail")){
                var emailValue=$(".regiserEmail").val();
                if(emailValue==""){
                    $(".regiserEmailError").html("请输入邮箱!");
                }else if(!/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/.test(emailValue)){
                    $(".regiserEmailError").html("请输入正确邮箱!");
                }else{
                    $(".regiserEmailError").html("");
                }
            }
            if($(this).is(".regiserNumber2")){
                var objvalue=$(this).val();
                var regx=/^(?:13\d|15\d|17\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/
                if(objvalue==""){
                    $(".regiserNumberError2").html("请输入手机号码!");
                }
                else if(regx.test(objvalue)){
                    $(".regiserNumberError2").html("");
                }else{
                    $(".regiserNumberError2").html("请输入正确手机号!");
                }
            }
            if($(this).is(".RegiserPasswordCon2")){
                var passWordError=$(".RegiserPasswordErrorCon2");
                var passWord=$(".RegiserPasswordCon2").val();
                if(passWord==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord.length<6 || passWord.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            if($(this).is(".RegiserPassword2Con2")){
                var passWordError=$(".RegiserPasswordError2Con2");
                var passWord=$(".RegiserPasswordCon2").val();
                var passWord2=$(".RegiserPassword2Con2").val();
                // var passWord2a=$(".r-input-box-regiserPassword2").val();
                if(passWord2==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord2.length<6 || passWord2.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }else if(passWord2!=passWord){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>两次密码不一致!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            //修改密码
            if($(this).is(".userinfo-regiserPassword2")){
                var passWordError=$(".RegiserPasswordError2a");
                var passWord2a=$(".userinfo-regiserPassword2").val();
                if(passWord2a==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord2a.length<6 || passWord2a.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            if($(this).is(".RegiserPassword3")){
                var passWordError=$(".RegiserPasswordError3");
                var passWord2a=$(".userinfo-regiserPassword2").val();
                var passWord3=$(".RegiserPassword3").val();
                if(passWord3==""){
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if(passWord3.length<6 || passWord3.length>32){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }else if(passWord3!=passWord2a){
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>两次密码不一致!</b>");
                }
                else{
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }

        })/*.keyup(function(){
                $(this).triggerHandler("blur");
            }).focus(function(){
                $(this).triggerHandler("blur");
            })*/
    }
    return{
        init:init
    }
})();
effect.init();

//获取验证码
var wait=60;
$("#login-send").bind("click", function(){
    var val = $(".regiserNumber").val();
    if(val!=""){
        codeSend();
    }
})
function codeSend(){
    $("#login-send").addClass("login-send-grey");
    if(wait==0){
        $("#login-send").html("获取验证码");
        wait = 60;
        $("#login-send").bind("click", function(){
            codeSend();
        })
        $("#login-send").removeClass("login-send-grey");
    }else{
        $("#login-send").unbind("click");
         $("#login-send").html("重新发送(" + wait + ")");
         wait--;
         setTimeout(function(){
            codeSend();
         }, 1000);
    }
}

//footer
$(".footer li").click(function(){
    $(".footer li").removeClass("active")
    $(this).addClass("active");
})
//cellphoneChange
/*$("#cellphoneChange").click(function(){
    if($(".register-body .r-input-box-four").is(":hidden")){
        $(".register-body .r-input-box-four").show();
        $("#cellphoneChange").html("邮<br>箱<br>注<br>册");
    }else{
        $(".register-body .r-input-box-four").hide();
        $("#cellphoneChange").html("手<br>机<br>注<br>册");
    }   
})*/

//注册页面切换手机/邮箱注册方式
$(".register-tab-btn p").click(function(){
    $(".register-tab-btn p").removeClass("active");
    $(this).addClass("active");
    var num = $(this).index();
    if(num==0){
        $(".register-con2").hide();
        $(".register-con1").show();
    }else if(num==1){
        $(".register-con2").show();
        $(".register-con1").hide();
    }
})

//课程列表增加十分珍爱打卡
$(".course-list-con-bottom dl dd em").click(function(){
    $(".punchTheClockBorder").show();
    $(".tmBgOpacity80").show();
})
$(".punchTheClockBorder b").click(function(){
    $(".punchTheClockBorder").hide();
    $(".tmBgOpacity80").hide();
})