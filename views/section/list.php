<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;

$this->title = $wares['section_name'] ?  $wares['section_name'] : '还没有到开课时间哦';
$this->params['breadcrumbs'][] = $this->title;
?>

    <header>
        <div class="course-list-header">
            <h1><?= $this->title ?></h1>
        </div>
    </header>
<?php if ($wares): ?>
    <div class="course-list-box">
        <?php foreach ($wares['section_ware'] as $valueware): ?>
            <?php if (isset($valueware['ware'])): ?>
                <div class="course-list-con">
                    <div class="course-list-con-top clearfix">
                        <h2 class="clearfix">
                            <?php
                            $img = $valueware['cat_image'] ? json_decode($valueware['cat_image']) : "/wap/images/icon_courseList.png";
                            ?>
                            <span><img src="<?= $img?>" /></span>
                            <span><?= $valueware['cat_name'] ?></span>
                        </h2>
                    </div>
                    <div class="course-list-con-bottom">
                        <?php foreach ($valueware['ware'] as $value): ?>
                            <dl class="clearfix">
                                <?php
                                $img = $value['ware']['image'] ? json_decode($value['ware']['image']) : "/wap/images/icon_courseList2.png";
                                ?>
                                <dt><img src="<?= $img?>" /></dt>
                                <dd>
                                    <a href="/ware/detail?ware_id=<?= $value['ware']['ware_id'] ?>">
                                        <h2><?= $value['ware']['title'] ?></h2>
                                    </a>
                                    <p>
                                        <?= $value['ware']['small_text'] ?>
                                    </p>
                                </dd>
                            </dl>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
