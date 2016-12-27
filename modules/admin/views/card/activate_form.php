<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/15
 * Time: 上午10:17
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\Sortable;


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

                <?= \app\models\widgets\SelectClass::widget([
                    'view' => 'linkage',
                    'className' => \app\models\CardModel::className(),
                    'model' => $model,
                    'form' => $form,
                    'type' => 88,
                ])?>

                <?= $form->field($model, 'start_code', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-3">
                                {input}
                                {hint}
                                {error}
                                </div>
                                ',
                ])->textInput([
                    'class' => 'form-control',
                    'type' => 'number',
                ])->hint('开头不能为0的13位数字') ?>

                <?= $form->field($model, 'end_code', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-3">
                                {input}
                                {hint}
                                {error}
                                </div>
                                ',
                ])->textInput([
                    'class' => 'form-control',
                    'type' => 'number',
                ])->hint('开头不能为0的13位数字') ?>

                <div class="form-group field-cardmodel-expired_at required">

                    <label class="col-lg-2 control-label" for="cardmodel-expired_at">截止日期</label>
                    <div class="col-lg-3">
                        <?= \yii\jui\DatePicker::widget([
                            'model' => $model,
                            'attribute' => 'expired_at',
                            'language' => 'zh-CN',
                            'dateFormat' => 'yyyy-MM-dd',
                        ]); ?>
                    </div>
                </div>

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