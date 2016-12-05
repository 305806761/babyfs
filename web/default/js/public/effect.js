var effect=(function(){
    function init(){
        showHide();
        Verification();
        //showImg();
        showBigImg();
    }
    /*function  showImg(){
     $('#img').click(function() {
     $(this).toggleClass('min');
     $(this).toggleClass('max');
     })
     }*/
    function showBigImg(){
        $(".introduce2-center-bot img").click(function(){
            var imgUrl1 = $(this).attr("src");
            var imgOffsetTop = $(this).offset().top;
            imgUrl2 = "url(" + imgUrl1 + ")";
            //alert(imgUrl2);
            $(".imgChangeBigK").css({"top":imgOffsetTop-300}).show();
            $("#imgChangeBig").css({"background-image":imgUrl2});
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

    function Verification() {
        $("input").blur(function () {
            if ($(this).is(".loginphoneNumber")) {
                var objvalue = $(this).val();
                var regx = /^(?:13\d|15\d|17\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/
                if (objvalue == "") {
                    $(".loginphoneNumberError").html("请输入手机号码!");
                }
                else if (regx.test(objvalue)) {
                    $(".loginphoneNumberError").html("");
                } else {
                    $(".loginphoneNumberError").html("请输入正确手机号!");
                }
            }
            if ($(this).is(".loginpassWord")) {
                var passWordError = $(".loginpassWordError");
                var passWord = $(".loginpassWord").val();
                if (passWord == "") {
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if (passWord.length < 6 || passWord.length > 32) {
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else {
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            /*注册*/
            if ($(this).is(".regiserNumber")) {
                var objvalue = $(this).val();
                var regx = /^(?:13\d|15\d|17\d|18[0123456789])-?\d{5}(\d{3}|\*{3})$/
                if (objvalue == "") {
                    $(".regiserNumberError").html("请输入手机号码!");
                }
                else if (regx.test(objvalue)) {
                    $(".regiserNumberError").html("");
                } else {
                    $(".regiserNumberError").html("请输入正确手机号!");
                }
            }
            if ($(this).is(".ReIdentifyingCode")) {
                var ReIdentifyingCode = $(".ReIdentifyingCode").val();
                var ReIdentifyingCodeError = $(".ReIdentifyingCodeError");
                if (ReIdentifyingCode == "") {
                    ReIdentifyingCodeError.html("<b style='color: #ff5a5f' class='error'>请输入验证码!</b>")
                } else {
                    ReIdentifyingCodeError.html("<b style='color: #008e23'></b>");
                }
            }
            if ($(this).is(".RegiserPassword")) {
                var passWordError = $(".RegiserPasswordError");
                var passWord = $(".RegiserPassword").val();
                if (passWord == "") {
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if (passWord.length < 6 || passWord.length > 32) {
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else {
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }
            if ($(this).is(".RegiserPassword2")) {
                var passWordError = $(".RegiserPasswordError2");
                var passWord = $(".RegiserPassword2").val();
                if (passWord == "") {
                    passWordError.html("<b style='color: #ff5a5f' class='error'>请输入密码!</b>");
                }
                else if (passWord.length < 6 || passWord.length > 32) {
                    passWordError.html("<b style='color: #ff5a5f' class='error2'>密码应为6--32个字符!</b>");
                }
                else {
                    passWordError.html("<b style='color: #008e23'></b>");
                }
            }

        }).keyup(function () {
            $(this).triggerHandler("blur");
        }).focus(function () {
            $(this).triggerHandler("blur");
        })
    }

    return {
        init: init
    }
})();
effect.init();


//获取验证码
//var wait=60;
//var inputLoginSend = document.getElementById("login-send");
//var $inputLoginSend = $("#login-send");
//document.getElementById("login-send").disabled = false;
//function time(o) {
//     $inputLoginSend.addClass("login-send-grey");
//     if (wait == 0) {
//         o.removeAttribute("disabled");
//         o.value="获取验证码";
//         wait = 60;
//         $inputLoginSend.removeClass("login-send-grey");
//     } else {
//         o.setAttribute("disabled", true);
//         o.value="重新发送(" + wait + ")";
//         wait--;
//         setTimeout(function() {
//             time(o)
//         },1000)
//     }
// }
// document.getElementById("login-send").onclick=function(){time(this);}