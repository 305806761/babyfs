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
                <?php if ($value['is_buy']): ?>
                    <a href="/section/list?section_id=<?= $value['section_id'] ?>">
                        <?php
                        $img = $value['image'] ? json_decode($value['image']) : "/default/img/already-buy-img1.png";
                        ?>
                        <img src="<?= $img?>" />
                    </a>
                    <span class="active">学习中</span>
                <?php else: ?>
                    <a href="<?= $value['buyurl']?>">
                        <?php
                        $img = $value['image'] ? json_decode($value['image']) : "/default/img/already-buy-img1.png";
                        ?>
                        <img src="<?= $img?>" />
                    </a>
                    <span>未开放</span>
                <?php endif ?>
            </dt>
            <dd><?= $value['name'] ?></dd>
        </dl>
        <?php if ($key % 2 == 1): ?>
            </div>
        <?php endif ?>
    <?php endforeach; ?>
</div>
