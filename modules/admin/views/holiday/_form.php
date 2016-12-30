<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'type')->dropDownList(\app\models\Holiday::$types) ?>
        </div>
    </div>
    <?='这个是日期时间，仅供参考：'.$model->day?>
    <?= $form->field($model, 'term_id')->checkboxList($arrayData)?>


    <div class="row">
        <div class="col-md-3">
            开始日期
            <?= \yii\jui\DatePicker::widget([
                'model' => $model,
                'attribute' => 'start_time',
                'language' => 'zh-CN',
                'dateFormat' => 'yyyy-MM-dd',
            ]); ?>
            <br/>
            <br/>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            结束日期
            <?= \yii\jui\DatePicker::widget([
                'model' => $model,
                'attribute' => 'end_time',
                'language' => 'zh-CN',
                'dateFormat' => 'yyyy-MM-dd',
            ]); ?>
            <br/>
            <br/>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新建' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
