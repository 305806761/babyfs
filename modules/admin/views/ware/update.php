<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/13
 * Time: 12:01
 *
 * @var $this yii\web\View
 * @var $model app\models\Ware
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\Sortable;

$this->title = '课件生成';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('/default/js/public/ware.js');
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-9">
        <?= $form->field($model, 'small_text')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="row" style="margin: 20px">
    <?php
    echo Sortable::widget([
        'items' => $items,
        'options' => ['tag' => 'div'],
        'itemOptions' => ['tag' => 'div'],
        'clientOptions' => ['cursor' => 'move'],
        'id' => 'template_params',
    ]);
    ?>
</div>

<div class="form-group">
    <?= Html::button('新增章节', ['class' => 'btn btn-info', 'onclick' => 'newSection()']) ?>
    <?= Html::submitButton($model->isNewRecord ? '新建课件' : '修改课件', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
