<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\WapAsset;

$this->title = '手机号注册';
$this->params['breadcrumbs'][] = $this->title;
WapAsset::register($this);

?>
<?php if($_COOKIE['notice']):?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['error']):?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['error'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['success']):?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<body class="register-body">
<?php $this->beginBody() ?>
<div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt="" /></div>
<div class="register-con">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'oldpassword', [
        'template' => '
                      <div class="r-input-box userinfo-input-box1" style="padding-top:45px;">
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

    <?= $form->field($model, 'password', [
        'template' => '
                      <div class="r-input-box userinfo-input-box1">
                        <p>{input}</p>
                        {error}
                      </div>
                      ',
    ])->passwordInput([
        'class' => 'RegiserPassword2 userinfo-regiserPassword2',
        'maxlength' => '32',
        'minlength' => '6',
        'placeholder' => "确认密码"
    ])->error(['class'=>'prompt-error RegiserPasswordError2a']) ?>

    <?= $form->field($model, 'repassword', [
        'template' => '
                      <div class="r-input-box userinfo-input-box1">
                        <p>{input}</p>
                        {error}
                      </div>
                      ',
    ])->passwordInput([
        'class' => 'RegiserPassword3',
        'maxlength' => '32',
        'minlength' => '6',
        'placeholder' => "确认密码"
    ])->error(['class'=>'prompt-error RegiserPasswordError3']) ?>


    <div class="RegiserBtn">
        <?= Html::buttonInput('修改', ['onclick'=>'javascript:this.form.submit()']) ?>
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
