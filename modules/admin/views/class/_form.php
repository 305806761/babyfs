<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/14
 * Time: 下午5:07
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                <?=$this->title?>
            </header>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'options'=>[
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                    ]
                ]); ?>


                <?= $form->field($model, 'name', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-2">
                                {input}
                                {error}
                                </div>
                                ',
                ])->textInput([
                    'id' => 'name',
                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'price', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-md-3">
                                    <div class="input-group m-bot15">
                                    <span class="input-group-addon">¥</span>
                                    {input}
                                    <span class="input-group-addon">元</span>
                                    </div>
                                    {error}
                                </div>
                                ',
                ])->textInput([
                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'order_sort', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-2">
                                {input}
                                {error}
                                </div>
                                ',
                ])->textInput([
                    'type' => 'number',
                    'id' => 'order_sort',
                    'class' => 'form-control',
                ]) ?>

                <?= $form->field($model, 'status', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                            {label}
                            <div class="col-lg-2">
                            {input}
                            {error}
                            </div>
                            ',
                ])->dropDownList(\app\models\ClassModel::getStatus()) ?>

                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <?php
                        echo Html::submitButton($model->isNewRecord ? '添加' : '更新', [
                            'class' => $model->isNewRecord ? 'btn btn-danger' : 'btn btn-danger'])
                        ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </section>
    </div>
</div>