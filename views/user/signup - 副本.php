<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 12:01
 */

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('signupFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>



    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'signup-form','method'=>'post','action' =>['user/signup']]); ?>

              <?= $form->field($model, 'phone')->textInput(['autofocus' => true]) ?><p id="username-error"></p>

                <?= Html::Button('获取验证码', ['class' => 'btn btn-primary', 'name' => 'button','onclick'=>'send();']) ?>

                <?= $form->field($model, 'verifyCode')->textInput() ?><p id="verifycode-error"></p>

                <?= $form->field($model, 'password')->passwordInput() ?>


                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>

<?php
   // $this->registerJs("afterLoad();");
?>

<script>

        function send(){
            phone =  $("#signupform-phone").val() ;
            $.ajax({
                    url: "/user/send",
                    data: "phone="+phone,
                    success: function(data){
                       if(data.code= '200'){
                           return true;
                       }
                   }
                });

        }

        function afterLoad() {
            //验证手机号是否已经存在
            $("#signupform-phone").blur(function(){
                if ($(this).val()) {
                    $.ajax({
                        url: "/user/user-by-name",
                        data: "phone="+$(this).val(),
                        success: function(result){
                            var res = $.parseJSON(result);
                            if(res.code = '200'){
                                if (typeof(res.data)!="undefined") {
                                    if (typeof(res.data.callback)!="undefined") {
                                        eval(res.data.callback);
                                    }
                                }
                            }
                        }
                    });
                }
            });



        }
//<p class="help-block help-block-error"></p>
        function checkMobie(result){
             if(result=='exists'){
                $("#username-error").html(
                    '<strong style="color:red;font:12px/1.4 Helvetica,宋体,Arial,sans-serif;">手机号码已存在</strong>');
            }
        }
//验证码是否正确
        function checkCode(result){
            if(result=='error'){
                $("#verifycode-error").html(
                    '<strong style="color:red;font:12px/1.4 Helvetica,宋体,Arial,sans-serif;">验证码输入有误</strong>');
            }
        }



</script>