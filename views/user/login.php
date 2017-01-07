<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\WapAsset;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
$login = true;
WapAsset::register($this);
?>


<body class="login-body">
<?php $this->beginBody() ?>
<?php if($_COOKIE['loginnotice']):?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['loginnotice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['loginerror']):?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['loginerror'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['loginsuccess']):?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['loginsuccess'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt="" /></div>
<div class="login-con">
    <h2><?= Html::encode($this->title) ?> </h2>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'loginname', [
        'template' => '
          <div class="l-input-box">
            <p><lable>{label}</lable>{input}</p>
            {error}
          </div>
          ',
    ])->textInput([
        'class' => 'loginUser',
        'maxlength' => '255',
        'minlength' => '2',
        'placeholder' => "用户名/手机号"
    ]) ->error(['class'=> 'prompt-error loginphoneNumberError'])
    ?>

    <?= $form->field($model, 'password', [
        'labelOptions' => ['label' => '密&nbsp;&nbsp;&nbsp;码'],
        'template' => '
              <div class="l-input-box">
                <p>{label}{input}</p>
                {error}
              </div>
              ',
        ])->passwordInput([
        'class' => 'loginpassWord',
        'maxlength' => '32',
        'minlength' => '2',
        'placeholder' => '密码'
    ]) ->error(['class'=> 'prompt-error loginpassWordError'])
    ?>

    <div class="l-input-btn">
        <?= Html::buttonInput('登录',['onclick'=>'javascript:this.form.submit()']) ?>
        <span><a href="<?= \yii\helpers\Url::to(['/user/forget'])?>" target="_self">忘记密码</a></span></p>
    </div>
    <div class="l-input-link"><a href="<?= \yii\helpers\Url::to(['user/user-course','type'=>1])?>">游客登录</a><a href="<?= \yii\helpers\Url::to('signup')?>">注册账号</a></div>

    <?php ActiveForm::end(); ?>
</div>
<?php $this->endBody() ?>
</body>
<script type="text/javascript">
    function afterLoad()
    {
        $(".J_Close").click(
            function () {
                $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                    $(this).slideUp(400);
                });

                return false;
            }
        );

    }
</script>
