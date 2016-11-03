<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="/default/css/style.css"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.jplayer.min.js"></script>

</head>

<body>
<?php $this->beginBody() ?>

<div class="C-con-dialogue clearfix">
    <div class="introduce2-center">
<?= $content ?>
<div id="jquery_jplayer_1">&nbsp;</div>
<div id="jp_container_1">

    <div class="C-left-dialogue clearfix">
        <div class="introduce-audio">
            <dl class="clearfix">
                <dt></dt>
                <dd><!--语音 中间宽度默认150px-->
                    <span><b class="jp-play"></b></span>
                    <span style="line-height: 45px;text-align: center;" class="jp-duration"></span><!--150px-->
                    <span></span>
                </dd>
            </dl>
        </div>
    </div>
</div>
</div>
</div>

<footer>
    <div class="footer">
        <ul>
            <li class="footer-li-a<?php if(!isset($this->params['user_button'])) echo " active"?>">
                <a href="/user/user-course">
                    <span class="icon1<?php if(!isset($this->params['user_button'])) echo " active"?>"><span></span></span>
                    <span<?php if(!isset($this->params['user_button'])) echo " class='active'"?>>我的课程</span>
                </a>
            </li>
            <li class="footer-li-a<?php if(isset($this->params['user_button'])) echo " active"?>">
                <a href="/user/default">
                    <span class="icon2<?php if(isset($this->params['user_button'])) echo " active"?>"><span></span></span>
                    <span<?php if(isset($this->params['user_button'])) echo " class='active'"?>>用户中心</span>
                </a>
            </li>
        </ul>
    </div>
</footer>
<script type="text/javascript">
    function afterLoad(video){
        var video = video;
        $(document).ready(function(){

            $("#jquery_jplayer_1").jPlayer({
                ready: function () {
                    $(this).jPlayer("setMedia", {
                        //title: "北极熊，你看到了什么？",
                        mp3: video
                    });
                },
                swfPath: "",
                supplied: "mp3",
                wmode: "window",
                useStateClassSkin: true,
                autoBlur: false,
                smoothPlayBar: true,
                keyEnabled: true,
                remainingDuration: true,
                toggleDuration: true
            });
        });}
</script>
<script src="/default/js/public/jquery-1.9.1.min.js"></script>
<script src="/default/js/public/effect.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
