<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 *
 * @var $this yii\web\View
 * @var $selected_wares array
 * @var $wares array
 * @var $cate \app\models\SectionCat
 */

use yii\jui\Sortable;
use yii\widgets\ActiveForm;

$this->title = '获取课件';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs('
    $( function() {
        $( "#selected_wares, #wares" ).sortable({
            connectWith: ".ui-sortable"
        }).disableSelection();
    } );
');
$this->registerJsFile('/default/js/public/ware.js');
?>

<div class="row">
    <div class="col-md-12">
        <h1><?= $cate->cat_name ?></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <h4>已选择课件</h4>
    </div>
    <div class="col-md-6">
        <h4>可选择课件</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">

    </div>
    <div class="col-md-6">
        <?= \yii\helpers\Html::textInput('ware_name', null, [
            'class' => 'form-control',
            'onkeyup' => 'searchWare(this.value)'
        ]) ?>
        <br/>
    </div>
</div>

<div class="row">

    <?php $form = ActiveForm::begin(['id' => 'sel_ware']); ?>
    <div class="col-md-6">
        <?php
        echo Sortable::widget([
            'items' => $selected_wares,
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'selected_wares',
        ]);
        ?>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="col-md-6" id="ware_section">
        <?php
        echo Sortable::widget([
            'items' => $wares,
            'options' => ['tag' => 'div'],
            'itemOptions' => ['tag' => 'div'],
            'clientOptions' => ['cursor' => 'move'],
            'id' => 'wares',
        ]);
        ?>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <br/>
        <?= \yii\helpers\Html::submitButton('修改', [
            'class' => 'btn btn-success',
            'onclick' => '$("#sel_ware").submit()'
        ]); ?>
    </div>
</div>