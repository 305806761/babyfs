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

                <?php if ($value['is_buy']): ?>
                 <dl class="active">
                    <dt>
                        <a href="/section/list?section_id=<?= $value['section_id'] ?>&term_id=<?= $value['term_id']?>">
                            <?php
                            $img = $value['section']['image'] ? json_decode($value['section']['image']) : "/wap/images/my_lessons_img1.png";
                            ?>
                            <img src="<?= $img?>" />
                        </a>
                        <span>学习中</span>
                    </dt>
                     <dd><?= $value['section']['name'] ?></dd>
                </dl>
                <?php else: ?>
                <dl>
                    <dt>
                        <a href="<?= $value['section']['buyurl']?>">
                            <?php
                            $img = $value['section']['image'] ? json_decode($value['section']['image']) : "/wap/images/my_lessons_img1.png";
                            ?>
                            <img src="<?= $img?>" />
                        </a>
                        <span>未开放</span>
                    </dt>
                    <dd><?= $value['section']['name'] ?></dd>
                </dl>

        <?php endif ?>
        <?php if ($key % 2 == 1): ?>
            </div>
        <?php endif ?>
    <?php endforeach; ?>
</div>
