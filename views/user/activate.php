<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/16
 * Time: 上午9:44
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\WapAsset;

$this->title = '课程卡激活';
$this->params['breadcrumbs'][] = $this->title;


WapAsset::register($this);

?>

<body class="login-body">
<?php $this->beginBody() ?>
<?php if ($_COOKIE['notice']): ?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif; ?>
<?php if ($_COOKIE['error']): ?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['error'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif; ?>
<?php if ($_COOKIE['success']): ?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif; ?>

<div class="l-logo-babyfs">
    <img src="/wap/images/logo_babyfs.png" alt=""/>
    <p class="activation-back"><a href="<?= \yii\helpers\Url::to('default')?>" target="_self">返回</a></p>
</div>

<div class="login-con">
    <h2><?= Html::encode($this->title) ?> </h2>

    <?php $form = ActiveForm::begin([
        'action' => ['/user/activate'],
    ]); ?>

    <?= $form->field($model, 'code', [
        'template' => '
          <div class="l-input-box">
            <p><lable>{label}</lable>{input}</p>
            <p>{error}</p>
          </div>
          ',
    ])->textInput([
        // 'class' => 'loginUser',
        'maxlength' => '13',
        'minlength' => '13',
        'placeholder' => "请输入卡号"
    ])->error(['class' => 'prompt-error loginphoneNumberError222'])
    ?>

    <?= $form->field($model, 'password', [
        'template' => '
          <div class="l-input-box">
            <p><lable>{label}</lable>{input}</p>
             <p>{error}</p>
          </div>
          ',
    ])->textInput([
        'class' => 'loginpassWord',
        'maxlength' => '6',
        'minlength' => '6',
        'placeholder' => "请输入密码"
    ])->error(['class' => 'prompt-error loginpassWordError333'])
    ?>
    <div class="l-input-btn">
        <?= Html::buttonInput('提交', ['onclick' => 'javascript:this.form.submit()']) ?>

    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$this->registerJs("afterLoad();");
?>
<?php $this->endBody() ?>
</body>

<script>
    function afterLoad() {
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


