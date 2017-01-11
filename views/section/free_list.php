<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;
use app\assets\WapAsset;
WapAsset::register($this);
$this->title = $wares['section_name'] ?  $wares['section_name'] : '没开课或无权限';
$this->params['breadcrumbs'][] = $this->title;
?>
<body>
<?php $this->beginBody() ?>
<?php if($_COOKIE['notice']):?>
    <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['error']):?>
    <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['error'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>
<?php if($_COOKIE['success']):?>
    <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
<?php endif;?>

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
                                    <a href="<?= \yii\helpers\Url::to(['ware/view','ware_id'=>$value['ware']['ware_id'],'section_id'=>$valueware['section_id'], 'time'=> $time])?>">
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
<footer>
    <div class="footer">
        <ul>
            <li class="footer-li-a<?php if(!isset($this->params['user_button'])) echo " active"?>">
                <a href="">
                    <span class="icon1<?php if(!isset($this->params['user_button'])) echo " active"?>"><span></span></span>
                    <span<?php if(!isset($this->params['user_button'])) echo " class='active'"?>>我的课程</span>
                </a>
            </li>
            <li class="footer-li-a<?php if(isset($this->params['user_button'])) echo " active"?>">
                <a href="">
                    <span class="icon2<?php if(isset($this->params['user_button'])) echo " active"?>"><span></span></span>
                    <span<?php if(isset($this->params['user_button'])) echo " class='active'"?>>用户中心</span>
                </a>
            </li>
        </ul>
    </div>
</footer>

<script>
    $(".J_Close").click(
        function () {
            $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                $(this).slideUp(400);
            });
            <?php Yii::$app->session->remove('')?>
            return false;
        }
    );
</script>
<?php $this->endBody() ?>
</body>