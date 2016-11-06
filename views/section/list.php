<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;

$this->title = $wares['section_name'];
$this->params['breadcrumbs'][] = $this->title;
?>
<header>
    <div class="course-list-header">
        <h1><?= $wares['section_name'] ?></h1>
    </div>
</header>
<div class="course-list-box">
    <?php foreach ($wares['section_ware'] as $valueware): ?>
        <?php if (isset($valueware['ware'])): ?>
            <div class="course-list-con">
                <div class="course-list-con-top clearfix">
                    <h1 class="clearfix">
                        <span><img src="res/img/course-img2.png" alt=""/></span>
                        <span><?= $valueware['cat_name'] ?></span>
                    </h1>
                </div>
                <div class="course-list-con-bottom">
                    <?php foreach ($valueware['ware'] as $value): ?>
                        <dl class="clearfix">
                            <dt><img src="res/img/course-img1.png" alt=""/></dt>
                            <dd>
                                <a href="/ware/detail?ware_id=<?= $value['ware_id'] ?>"><h1><?= $value['title'] ?></h1>
                                </a>
                                <p>
                                    <span>monkey</span>
                                    <span>horse</span>
                                    <span>elephant</span>
                                    <span>tiger</span>
                                    <span>lion</span>
                                </p>
                            </dd>
                        </dl>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>