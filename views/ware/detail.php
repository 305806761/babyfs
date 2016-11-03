<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;

$this->title = $ware['title'];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("afterLoad();");
?>
<header>
    <div class="introduce1-top">
        <h2>Lesson <?= $ware['ware_id'] ?></h2>
        <h1><?= $ware['title'] ?></h1>
    </div>
</header>

        <?= $ware['contents'] ?>