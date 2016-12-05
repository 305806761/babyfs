<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=$ware['title']?></title>
    <meta name="viewport"content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta content="telephone=no" name="format-detection" />
    <link rel="stylesheet" href="/default/css/style.css"/>
    <script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.jplayer.min.js"></script>

</head>
<body>
<header>
    <div class="introduce1-top">
        <h2>Lesson</h2>
        <h1><?= $ware['title'] ?></h1>
    </div>
</header>
<div class="C-con-dialogue clearfix">
    <div class="introduce2-center">
        <?= $ware['contents'] ?>
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
<div class="imgChangeBigK">
    <p class="tmBgOpacity60"></p>
    <div class="imgChangeBig" id="imgChangeBig"></div>

</div>
<!--script src="/default/js/public/jquery-1.9.1.min.js"></script-->
<script src="/default/js/public/effect.js"></script>
</body>
</html>

