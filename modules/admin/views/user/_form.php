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
                <div class="form-group field-term ">
                    <label class="col-lg-2 control-label" >手机号</label>
                    <div class="col-lg-10">
                    <?=$userInfo->phone?>
                    </div>
                </div>

                <div class="form-group field-term ">
                    <label class="col-lg-2 control-label" >课程</label>
                    <div class="col-lg-10">
                        <?=$courseInfo->name?>
                    </div>
                </div>

                <div class="form-group field-term ">
                    <label class="col-lg-2 control-label" >阶段</label>
                    <div class="col-lg-10">
                        <?=$sectionInfo->name?>
                    </div>
                </div>
                <div class="form-group field-term ">
                    <label class="col-lg-2 control-label" >学期</label>
                    <div class="col-lg-5">
                        <?= $form->field($model, 'term_id')->dropDownList(\app\models\TermModel::getTermNames()) ?>
                    </div>
                </div>

                <div class="form-group field-term ">
                    <label class="col-lg-2 control-label" for="term">开课时间</label>
                    <div class="col-lg-10">
                        <input id="create_time" type="text" readonly="readonly" size="12" name="UserCourse[create_time]"
                               value="<?=$model->create_time?>"/>
                        <input id="selbtn1" class="button" type="button" value="选择"
                               onclick="return showCalendar('create_time', '%Y-%m-%d', false, false, 'selbtn1');"
                               name="selbtn1">
                    </div>
                </div>

                <div class="form-group field-term ">
                    <label class="col-lg-2 control-label" for="term">结束时间</label>
                    <div class="col-lg-10">
                        <input id="expire_time" type="text" readonly="readonly" size="12" name="UserCourse[expire_time]"
                               value="<?=$model->expire_time?>"/>
                        <input id="selbtn1" class="button" type="button" value="选择"
                               onclick="return showCalendar('expire_time', '%Y-%m-%d', false, false, 'selbtn1');"
                               name="selbtn1">
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

            <script type="text/javascript">

            </script>
        </section>
    </div>
</div>