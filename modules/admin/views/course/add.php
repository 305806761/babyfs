<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '课程添加';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- page start-->
<?=
$this->render('_form', [
    'model' => $model,
]);
?>
