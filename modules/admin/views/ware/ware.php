<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/10/30
 * Time: 下午5:35
 * @var $this yii\web\View
 * @var $model app\models\WareType
 */

use yii\widgets\ActiveForm;

?>

<?php $form = new ActiveForm(); ?>

<div style="border-top: 1px solid #ccc; padding-top: 15px; margin-top: 15px;" id="section_<?= $model->type_id?>">
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, "[$model->type_id]template_id")->dropDownList(\app\models\Template::getTemp(), [
                'onchange' => "updateCode(this, '$model->type_id');"
            ]) ?>
        </div>
        <div class="col-md-3" id="temp_code_<?= $model->type_id ?>">
            <?= $form->field($model, "[$model->type_id]temp_code_id")
                ->dropDownList(\app\models\Template::getTempCodes($model->template_id)) ?>
        </div>
        <div class="col-md-6" style="margin-top: 25px">
            <?= \yii\helpers\Html::button('删除章节', [
                'class' => 'btn btn-danger',
                'onclick'=>"removeSection('$model->type_id')",
                'style'=>'float: right']) ?>
        </div>
    </div>

    <?php
    $params = \app\models\Template::getParams($model->template_id);
    ?>
    <div id="temp_param_<?= $model->type_id ?>">
        <?php foreach ($params as $name => $control): ?>
            <div class="row">
                <?= $name . \yii\helpers\Html::$control("WareType[$model->type_id]$name", '', ['class' => 'form-control']) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
