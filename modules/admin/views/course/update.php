<?php

/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/12/2
 * Time: 13:19
 */
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>
<?=
$this->render('_form', [
    'model' => $model,
]);
?>