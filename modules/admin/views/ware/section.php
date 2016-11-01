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

$params = [];
if ($temp = \app\models\Template::findOne($model->template_id)) {
    if ($temp->param) {
        $params = json_decode($temp->param, true);
    }
}
$c = json_decode($model->content, true);
?>
<div id="temp_param_<?= $model->type_id ?>">
    <?php foreach ($params as $name => $type): ?>
        <?php
        if ($type == 'text') {
            $control = 'textInput';
        } else {
            $control = 'fileInput';
        }
        ?>
        <div class="row">
            <?php if ($type == 'image' && isset($c[$name])): ?>
                <img src="<?= $c[$name]; ?>" style="width: 100px">
                <input type="hidden" value="<?= $c[$name]; ?>" name="<?= $name ?>">
            <?php endif ?>
            <?= $name . \yii\helpers\Html::$control(
                "WareType[$model->type_id][$name]",
                isset($c[$name]) ? $c[$name] : '',
                ['class' => 'form-control'])
            ?>
        </div>
        <br/>
    <?php endforeach; ?>
</div>
