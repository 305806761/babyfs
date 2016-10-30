<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/10/30
 * Time: 下午5:35
 */

use yii\widgets\ActiveForm;

?>

<?php $form = new ActiveForm(); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'template_id')->dropDownList([1, 2]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'temp_code_id')->dropDownList([1, 2]) ?>
    </div>
</div>

<div class="row">
    <?= $form->field($model, 'content')->textarea() ?>
</div>