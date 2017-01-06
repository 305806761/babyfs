<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="/wap/css/index.css"/>
    <script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.min.js"></script>
    <script type="text/javascript" src="http://www.babyfs.cn/skin/jplayer/jquery.jplayer.min.js"></script>

</head>

<body>
<?php $this->beginBody() ?>

<?= $content ?>


<!--script src="/default/js/public/jquery-1.9.1.min.js"></script-->
<script src="/wap/js/index.js"></script>
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
