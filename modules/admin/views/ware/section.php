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
            $control_name = $name;
        } else {
            $control = 'fileInput';
            $control_name = $name . '_file';
        }
        ?>
        <div class="row">
            <?php if ($type != 'text'): ?>
                <?php if ($type == 'image' && isset($c[$name])): ?>
                    <img src="<?= $c[$name]; ?>" style="width: 100px">
                <?php endif ?>

                <?php if ($type == 'audio' && isset($c[$name])): ?>
                    <audio controls>
                        <source src="<?= $c[$name]; ?>" type="audio/mpeg">
                    </audio>
                <?php endif ?>

                <?php if ($type == 'video' && isset($c[$name])): ?>
                    <video width="400" controls>
                        <source src="<?= $c[$name]; ?>" type="video/mp4">
                    </video>
                <?php endif ?>

                <input type="hidden" value="<?= $c[$name]; ?>" name="<?= "WareType[$model->type_id][$name]" ?>">
            <?php endif; ?>
            <?= $name . \yii\helpers\Html::$control(
                "WareType[$model->type_id][$control_name]",
                isset($c[$name]) ? $c[$name] : '',
                ['class' => 'form-control'])
            ?>
        </div>
        <br/>
    <?php endforeach; ?>
</div>
