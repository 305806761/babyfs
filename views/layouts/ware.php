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
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta content="telephone=no" name="format-detection"/>
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
        <audio id="audio" src="" preload="preload" type="audio/mpeg"></audio>
    </div>
</div>

<footer>
    <div class="footer">
        <ul>
            <li class="footer-li-a<?php if (!isset($this->params['user_button'])) echo " active" ?>">
                <a href="/user/user-course">
                    <span
                        class="icon1<?php if (!isset($this->params['user_button'])) echo " active" ?>"><span></span></span>
                    <span<?php if (!isset($this->params['user_button'])) echo " class='active'" ?>>我的课程</span>
                </a>
            </li>
            <li class="footer-li-a<?php if (isset($this->params['user_button'])) echo " active" ?>">
                <a href="/user/default">
                    <span
                        class="icon2<?php if (isset($this->params['user_button'])) echo " active" ?>"><span></span></span>
                    <span<?php if (isset($this->params['user_button'])) echo " class='active'" ?>>用户中心</span>
                </a>
            </li>
        </ul>
    </div>
</footer>

<script src="/default/js/public/jquery-1.9.1.min.js"></script>
<script src="/default/js/public/effect.js"></script>
<script>
    var Answer = (function () {

        function play(file_id,answer) {
            $(".user-answered-dialogue-button > b > strong").removeClass('active');
            var audio = document.getElementById("audio");
            audio.src = answer+'?token=<?=Yii::$app->params['user']->token;?>';
            audio.loop = false;
            audio.onplaying = function () {
                $("#f"+file_id+' strong').addClass('active');
                $("#f"+file_id+' .user-answered-red-dot').remove();
            };
            audio.onended = function () {
                $("#f"+file_id+' strong').removeClass('active');
            };
            audio.play();
        }

        return {
            play:play
        }
    })();
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
