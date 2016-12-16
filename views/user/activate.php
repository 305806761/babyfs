<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/16
 * Time: 上午9:44
 */
use yii\widgets\ActiveForm;
$this->title = '绑定卡';


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
<div class="register-con">
    <?php $form = ActiveForm::begin([
        'action' => ['/user/activate'],
    ]); ?>

    <?= $form->field($model, 'code', [
        'template' => '
          <div class="l-input-box">
            <p>{input}</p>
            <p class="prompt-error regiserNumberError">{error}</p>
          </div>
          ',
    ])->textInput([
        'class' => 'loginphoneNumber',
        'maxlength' => '16',
        'minlength' => '16',
        'placeholder' => "请输入卡号"
    ]) ?>
    <?= $form->field($model, 'password', [
        'template' => '
          <div class="l-input-box">
            <p>{input}</p>
            <p class="prompt-error regiserNumberError">{error}</p>
          </div>
          ',
    ])->textInput([
        'class' => 'loginphoneNumber',
        'maxlength' => '6',
        'minlength' => '6',
        'placeholder' => "请输入密码"
    ]) ?>
    <div class="RegiserBtn"><input type="submit" value="提交"/></div>
    <?php ActiveForm::end(); ?>




</div>
<div class="l-sign-icon"><img src="/default/img/sign-icon.png" alt=""></div>

