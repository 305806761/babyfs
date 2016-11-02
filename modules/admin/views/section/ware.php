<?php
/**
 * Created by PhpStorm.
 * User: caoxiang
 * Date: 2016/11/2
 * Time: 上午9:00
 *
 * @var $ware \app\models\Ware
 */

?>

<div class="panel panel-default">
    <div class="panel-body">
        <span class="badge"><?= $ware->ware_id ?></span> <?= $ware->title ?>
        <?= \yii\helpers\Html::hiddenInput('sel_ware[]', $ware->ware_id) ?>
    </div>
</div>
