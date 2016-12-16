<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/14
 * Time: 下午1:42
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

                <?= $form->field($model, "status")->dropDownList(\app\models\CardModel::getCard()) ?>

                <?= $form->field($model, 'number', [
                    'labelOptions' => ['class'=>'col-lg-2 control-label'],
                    'template' => '
                                {label}
                                <div class="col-lg-2">
                                {input}
                                {hint}
                                {error}
                                </div>
                                ',
                ])->textInput([
                    'id' => 'number',
                    'class' => 'form-control',
                    'type' => 'number',
                ])->hint('必须输入数字') ?>


                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <?php
                        echo Html::submitButton('导出' ,['class' =>  'btn btn-danger'])
                        ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </section>
    </div>
</div>