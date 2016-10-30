<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;

$this->title = '我的课程';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lessons-big-box clearfix">

    <?php foreach ($course as $key => $value): ?>
        <?php if ($key % 2 == 0): ?>
            <div class="lessons-con clearfix">
        <?php endif ?>
        <dl>
            <dt>
                <img src="/default/img/already-buy-img1.png" alt=""/>
                <?php if ($value['is_buy']): ?>
                    <span class="active">学习中</span>
                <?php else: ?>
                    <span>未开放</span>
                <?php endif; ?>
            </dt>
            <dd><?= $value['name'] ?></dd>
        </dl>
        <?php if ($key % 2 == 1): ?>
            </div>
        <?php endif ?>
    <?php endforeach; ?>
</div>
