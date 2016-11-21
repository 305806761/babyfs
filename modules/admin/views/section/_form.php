<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/11/18
 * Time: 下午2:32
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


    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-10">
            <?php
            echo '<h1 style="color: red;">'.$section->name.'<h1>';
            ?>
        </div>
    </div>


    <?= $form->field($model, 'term', [
        'labelOptions' => ['class'=>'col-lg-2 control-label'],
        'template' => '
                                {label}
                                <div class="col-lg-10">
                                {input}
                                {error}
                                </div>
                                ',
    ])->textInput([
        'id' => 'term',
        'class' => 'form-control',
    ]) ?>

    <div class="form-group field-term ">
        <label class="col-lg-2 control-label" for="term">开始时间</label>
        <div class="col-lg-10">
            <input id="start_time" type="text" readonly="readonly" size="12" name="TermModel[start_time]"
                   value="<?=$model->start_time?>"/>
            <input id="selbtn1" class="button" type="button" value="选择"
                   onclick="return showCalendar('start_time', '%Y-%m-%d', false, false, 'selbtn1');"
                   name="selbtn1">
        </div>
    </div>

    <div class="form-group field-term ">
        <label class="col-lg-2 control-label" for="term">结束时间</label>
        <div class="col-lg-10">
            <input id="end_time" type="text" readonly="readonly" size="12" name="TermModel[end_time]"
                   value="<?=$model->end_time?>"/>
            <input id="selbtn1" class="button" type="button" value="选择"
                   onclick="return showCalendar('end_time', '%Y-%m-%d', false, false, 'selbtn1');"
                   name="selbtn1">
        </div>
    </div>

    <?= $form->field($model, 'status', [
        'labelOptions' => ['class'=>'col-lg-2 control-label'],
        'template' => '
                            {label}
                            <div class="col-lg-2">
                            {input}
                            {error}
                            </div>
                            ',
    ])->dropDownList(\app\models\TermModel::getStatus()) ?>

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

<script type="text/javascript">

</script>
</section>
</div>
</div>