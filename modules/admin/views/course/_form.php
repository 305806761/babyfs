<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/12/2
 * Time: 13:18
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?= Html::encode($this->title) ?>
</header>
<div class="panel-body">
    <?php $form = ActiveForm::begin([
        'options'=>[
            'class'=>'form-horizontal tasi-form',
            'role'=>'form',
        ]
    ]); ?>

    <?= $form->field($model, 'name', [
        'labelOptions' => ['class'=>'col-lg-2 control-label'],
        'template' => '
                                {label}
                                <div class="col-lg-5">
                                {input}
                                {error}
                                </div>
                                ',
    ])->textInput([
        'maxlength' => 100,
        'class' => 'form-control',
    ]) ?>

    <?= $form->field($model, 'code', [
        'labelOptions' => ['class'=>'col-lg-2 control-label'],
        'template' => '
                                {label}
                                <div class="col-lg-5">
                                {input}
                                {error}
                                </div>
                                ',
    ])->textInput([
        'maxlength' => 10,
        'class' => 'form-control',
    ]) ?>


    <?= $form->field($model, 'type', [
        'labelOptions' => ['class'=>'col-lg-2 control-label'],
        'template' => '
                            {label}
                            <div class="col-lg-2">
                            {input}
                            {error}
                            </div>
                            ',
    ])->dropDownList(\app\models\TermModel::getCourseType()) ?>

    <?= $form->field($model, 'price', [
        'labelOptions' => ['class'=>'col-lg-2 control-label'],
        'template' => '
                                {label}
                                <div class="col-lg-2">
                                {input}
                                {error}
                                </div>
                                ',
    ])->textInput([
        'maxlength' => 10,
        'class' => 'form-control',
    ]) ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?=
            Html::submitButton($model->isNewRecord ? '添加': 更新, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])
            ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</section>
</div>
</div>
<!-- page end-->