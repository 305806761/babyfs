<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/16
 * Time: 上午9:47
 */
use yii\helpers\Html;
$this->registerJsFile("/default/js/public/jquery-1.9.1.min.js");
$this->registerJsFile("/default/js/public/effect.js");


?>



<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="format-detection" content="telephone=no" />
        <meta name="format-detection" content="address=no" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="author" content="cgi.beijing" />
        <link rel="stylesheet" href="/default/css/style.css" />
        <style>
            .sysmsg{clear:both;position:relative;width:90%;margin:8px auto;}
            .sysmsg p{font-size:16px;color:#f60;padding:8px 0 8px 40px;background:#f9feda url(/default/img//sysmsg.png) no-repeat 10px 10px;border:1px solid #fc0;}
            .sysmsg-success p{color:#690;background:#eefcd3 url(/default/img/sysmsg.png) no-repeat 10px -24px;border:1px solid #990;}
            .sysmsg-error p{color:#f00;background:#feeada url(/default/img/sysmsg.png) no-repeat 10px -58px;border:1px solid #f00;}
            .sysmsg.inbox p{width:690px;}.sysmsg .close{position:absolute;top:12px;right:8px;background:url(/default/img/sysmsg.png) no-repeat 100% 100%;text-indent:-99px;cursor:pointer;display:block;width:16px;height:16px;overflow:hidden;}
            .sysmsg.inbox .close{right:260px;}
        </style>
        <?php $this->head() ?>
    </head>

    <body class="login-body">
    <?php $this->beginBody() ?>
        <?=$content?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>