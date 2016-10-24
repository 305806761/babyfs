<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/8
 * Time: 14:10
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Course</h1>
<ul>
    <?php foreach ($course as $country): ?>
        <li>
            <?= Html::encode("{$country->name} ({$country->code})") ?>:
        </li>
    <?php endforeach; ?>
</ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>
