<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;
$this->title = '用户中心';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-center-top">
    <dl>
        <dt></dt>
        <dd>
            <p><?= $user->phone?></p>
        </dd>
    </dl>
</div>
<div class="user-center-con1">
    <ul>
        <li><a href="<?= \yii\helpers\Url::to(['reset-user'])?>">修改资料</a><img src="/wap/images/user_icon1.png" /></li>
        <li><a href="<?= \yii\helpers\Url::to(['reset-password'])?>">更改密码</a><img src="/wap/images/user_icon2.png" /></li>
        <li><a href="<?= \yii\helpers\Url::to(['activate'])?>">课程卡绑定</a><img src="/wap/images/user_icon6.png" /></li>
    </ul>
</div>
<div class="user-center-con2" style="padding-bottom: 55px;">
    <ul>
        <li><a href="#">课程履历</a><img src="/wap/images/user_icon3.png" /></li>
        <li><a href="#">我的成就</a><img src="/wap/images/user_icon4.png" /></li>
        <li><a href="<?= \yii\helpers\Url::to(['logout'])?>">退出登录</a><img src="/wap/images/user_icon5.png" /></li>
    </ul>
</div>
