<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 11:25
 */

use yii\helpers\Html;
?>
<header>
    <div class="introduce1-top">
        <h1><?php if($ware['title']){echo 'Lesson';}else{echo'您没有权限或者权限已经失效！'; }?></h1>
        <h2><?= $ware['title'] ?></h2>
    </div>
</header>
<div class="framework">
    <?= $ware['contents'] ?>
</div>

<footer>
    <div class="footer">
        <ul>
            <li class="footer-li-a<?php if (!isset($this->params['user_button'])) echo " active" ?>">
                <a href="">
                    <span
                        class="icon1<?php if (!isset($this->params['user_button'])) echo " active" ?>"><span></span></span>
                    <span<?php if (!isset($this->params['user_button'])) echo " class='active'" ?>>我的课程</span>
                </a>
            </li>
            <li class="footer-li-a<?php if (isset($this->params['user_button'])) echo " active" ?>">
                <a href="">
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
    <div class="imgChangeBig" id="imgChangeBig"><img src="" /></div>
</div>

