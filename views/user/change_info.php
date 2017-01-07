<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 17/1/7
 * Time: 下午2:55
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\WapAsset;

$this->title = '修改资料';
$this->params['breadcrumbs'][] = $this->title;
WapAsset::register($this);

?>
<body class="register-body">
<?php $this->beginBody() ?>
<div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt="" /></div>
<div class="register-con">
    <div class="u-div-phone"><?=$model->phone?></div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username', [
        'template' => '
                                <div class="r-input-box">
                                <p>{input}</p>
                                {error}
                                </div>
                                ',
    ])->textInput([
        'class' => 'loginUser',
        'placeholder' => "用户名",
    ]) ?>


    <div class="RegiserBtn">
        <?= Html::buttonInput('修改', ['onclick'=>'javascript:this.form.submit()']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<footer>
    <div class="footer">
        <ul>
            <li class="footer-li-a<?php if(!isset($this->params['user_button'])) echo " active"?>">
                <a href="/user/user-course">
                    <span class="icon1<?php if(!isset($this->params['user_button'])) echo " active"?>"><span></span></span>
                    <span<?php if(!isset($this->params['user_button'])) echo " class='active'"?>>我的课程</span>
                </a>
            </li>
            <li class="footer-li-a<?php if(isset($this->params['user_button'])) echo " active"?>">
                <a href="/user/default">
                    <span class="icon2<?php if(isset($this->params['user_button'])) echo " active"?>"><span></span></span>
                    <span<?php if(isset($this->params['user_button'])) echo " class='active'"?>>用户中心</span>
                </a>
            </li>
        </ul>
    </div>
</footer>
<?php $this->endBody() ?>
</body>