<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/16
 * Time: 上午9:47
 */
use yii\helpers\Html;
use app\assets\WapAsset;

WapAsset::register($this);

?>


<?php $this->beginPage() ?>
    <!doctype html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="utf-8">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="format-detection" content="telephone=no"/>
        <meta name="format-detection" content="address=no"/>
        <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="author" content="cgi.beijing"/>
        <?php $this->head() ?>
    </head>

    <?= $content ?>
    </html>
<?php $this->endPage() ?>