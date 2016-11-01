<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/11/1
 * Time: 上午9:49
 *
 * @var $this yii\web\View
 * @var $model app\models\WareType
 *
 */

$params = \app\models\Template::getParams($model->template_id);
$c = json_decode($model->content, true);
?>
<div id="temp_param_<?= $model->type_id ?>">
    <?php foreach ($params as $name => $control): ?>
        <div class="row">
            <?= $name . \yii\helpers\Html::$control(
                "WareType[$model->type_id][$name]",
                isset($c[$name]) ? $c[$name] : '',
                ['class' => 'form-control'])
            ?>
        </div>
    <?php endforeach; ?>
</div>
