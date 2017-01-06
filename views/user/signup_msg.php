<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 17/1/5
 * Time: 下午5:55
 */

use app\assets\WapAsset;

$this->title = '注册结果';
$this->params['breadcrumbs'][] = $this->title;
WapAsset::register($this);
?>

<body class="register-body">
<?php $this->beginBody() ?>
    <div class="l-logo-babyfs"><img src="/wap/images/logo_babyfs.png" alt="" /></div>
    <div class="register-con">
        <div class="ru-div">
            <p><?=$model['title']?></p>
            <p><?=$model['msg']?></p>
        </div>
    </div>
<?php $this->endBody() ?>
</body>