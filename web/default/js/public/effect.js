var effect=(function(){
    function init(){
       showHide();
       Verification();
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
            if($(this).is(".loginphoneNumber")){
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
            }
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
            /*注册*/
            if($(this).is(".regiserNumber")){
                var objvalue=$(this).val();
                var regx=/^(?:13\d|15\d|17\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/
                if(objvalue==""){
                    $(".regiserNumberError").html("请输入手机号码!");
                }
                else if(regx.test(objvalue)){
                    $(".regiserNumberError").html("");
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
                var passWord=$(".RegiserPassword2").val();
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

        }).keyup(function(){
                $(this).triggerHandler("blur");
            }).focus(function(){
                $(this).triggerHandler("blur");
            })
    }
    return{
        init:init
    }
})();
effect.init();