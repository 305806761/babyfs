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
        <li><a href="/user/reset-user?user_id=<?= $user->user_id?>">修改资料</a></li>
        <li><a href="/user/reset-password?user_id=<?= $user->user_id?>">更改密码</a></li>
        <li><a href="/user/activate/">激活卡</a></li>
    </ul>
</div>
<div class="user-center-con2" style="padding-bottom: 55px;">
    <ul>
        <li><a href="#">课程履历</a></li>
        <li><a href="#">我的成就</a></li>
        <li><a href="/user/logout">退出登录</a></li>
    </ul>
</div>
