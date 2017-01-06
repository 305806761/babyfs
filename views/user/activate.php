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
<style>
    .sysmsg{clear:both;position:relative;width:90%;margin:8px auto;}
    .sysmsg p{font-size:16px;color:#f60;padding:8px 0 8px 40px;background:#f9feda url(/default/img//sysmsg.png) no-repeat 10px 10px;border:1px solid #fc0;}
    .sysmsg-success p{color:#690;background:#eefcd3 url(/default/img/sysmsg.png) no-repeat 10px -24px;border:1px solid #990;}
    .sysmsg-error p{color:#f00;background:#feeada url(/default/img/sysmsg.png) no-repeat 10px -58px;border:1px solid #f00;}
    .sysmsg.inbox p{width:690px;}.sysmsg .close{position:absolute;top:12px;right:8px;background:url(/default/img/sysmsg.png) no-repeat 100% 100%;text-indent:-99px;cursor:pointer;display:block;width:16px;height:16px;overflow:hidden;}
    .sysmsg.inbox .close{right:260px;}
</style>
<body class="login-body">

<?php if ($_COOKIE['notice']): ?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif; ?>
<?php if ($_COOKIE['error']): ?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['error'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif; ?>
<?php if ($_COOKIE['success']): ?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif; ?>

<div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt=""/></div>

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
$this->registerJs("afterLoad();", \yii\web\View::POS_END);
?>
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


