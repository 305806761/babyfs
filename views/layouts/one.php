<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/8
 * Time: 下午6:31
 */

use yii\helpers\Html;

app\assets\LoginAsset::register($this);
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
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody() ?>
<div data-role="page">
    <?=$content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>