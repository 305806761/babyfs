<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .sysmsg{clear:both;position:relative;width:90%;margin:8px auto;}
        .sysmsg p{font-size:16px;color:#f60;padding:8px 0 8px 40px;background:#f9feda url(/default/img//sysmsg.png) no-repeat 10px 10px;border:1px solid #fc0;}
        .sysmsg-success p{color:#690;background:#eefcd3 url(/default/img/sysmsg.png) no-repeat 10px -24px;border:1px solid #990;}
        .sysmsg-error p{color:#f00;background:#feeada url(/default/img/sysmsg.png) no-repeat 10px -58px;border:1px solid #f00;}
        .sysmsg.inbox p{width:690px;}.sysmsg .close{position:absolute;top:12px;right:8px;background:url(/default/img/sysmsg.png) no-repeat 100% 100%;text-indent:-99px;cursor:pointer;display:block;width:16px;height:16px;overflow:hidden;}
        .sysmsg.inbox .close{right:260px;}
    </style>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '后台管理系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse', //  navbar-fixed-top
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => '首页', 'url' => ['/op/index']],
            ['label' => '关于我们', 'url' => ['/site/about']],
            ['label' => '联系我们', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
            ['label' => '登陆', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'navbar-form'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
    <style type="text/css">
        body {
            background: #80BDCB;
        }

        .main_column_left {
            width: 15%;
            float: left;
            margin: 10px;

        }

        .right_column {
            width: 75%;
            padding-top: 15px;
            float: left;
        }

        #tabbar-div {
            background: #278296;
            padding-left: 10px;
            height: 21px;
            padding-top: 0px;
        }

        #tabbar-div p {
            margin: 1px 0 0 0;
        }

        .tab-front {
            background: #80BDCB;
            line-height: 20px;
            font-weight: bold;
            padding: 4px 15px 4px 18px;
            border-right: 2px solid #335b64;
            cursor: hand;
            cursor: pointer;
        }

        .tab-back {
            color: #F4FAFB;
            line-height: 20px;
            padding: 4px 15px 4px 18px;
            cursor: hand;
            cursor: pointer;
        }

        .tab-hover {
            color: #F4FAFB;
            line-height: 20px;
            padding: 4px 15px 4px 18px;
            cursor: hand;
            cursor: pointer;
            background: #2F9DB5;
        }

        #top-div {
            padding: 3px 0 2px;
            background: #BBDDE5;
            margin: 5px;
            text-align: center;
        }

        #main-div {
            border: 1px solid #345C65;
            padding: 5px;
            margin: 5px;
            background: #FFF;
        }

        #menu-list {
            padding: 0;
            margin: 0;
        }

        #menu-list ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
            color: #335B64;
        }

        #menu-list li {
            padding-left: 16px;
            line-height: 16px;
            cursor: hand;
            cursor: pointer;
        }

        #main-div a:visited, #menu-list a:link, #menu-list a:hover {
            color: #335B64
            text-decoration: none;
        }

        #menu-list a:active {
            color: #EB8A3D;
        }

        .explode {
            /* background: url(images/menu_minus.gif) no-repeat 0px 3px;*/
            font-weight: bold;
        }

        .collapse {
            /* background: url(images/menu_plus.gif) no-repeat 0px 3px;*/
            font-weight: bold;
        }

        .menu-item {
            /* background: url(images/menu_arrow.gif) no-repeat 0px 3px;*/
            font-weight: normal;
        }

        #help-title {
            font-size: 14px;
            color: #000080;
            margin: 5px 0;
            padding: 0px;
        }

        #help-content {
            margin: 0;
            padding: 0;
        }

        .tips {
            color: #CC0000;
        }

        .link {
            color: #000099;
        }
    </style>


    <div class="container" style="width:1270px;">
        <div class="main_column_left" style="margin-left: -10px;">
            <div id="main-div">
                <div id="menu-list">
                    <ul id="menu-ul">

                        <!--课程-->
                        <li class="explode"><a href="" target="main-frame">课程管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>

                                <li class="menu-item"><a href="<?= Url::to(['course/add']) ?>"
                                                         target="main-frame">添加课程</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['course/list']) ?>"
                                                         target="main-frame">课程列表</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['section/add']) ?>"
                                                         target="main-frame">添加阶段</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['section/list']) ?>" target="main-frame">阶段列表</a>
                                </li>
                                <li class="menu-item"><a href="<?= Url::to(['section/list-term']) ?>" target="main-frame">阶段学期列表</a>
                                </li>

                                <li class="menu-item"><a href="<?= Url::to(['holiday/index']) ?>" target="main-frame">设置假日和课程日</a>
                                </li>

                            </ul>

                        </li>

                        <!--课件-->
                        <li class="explode"><a href="" target="main-frame">课件管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>
                                <li class="menu-item"><a href="<?= Url::to(['section/list-cat']) ?>"
                                                         target="main-frame">课件分组列表</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['ware/add']) ?>"
                                                         target="main-frame">添加课件</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['ware/list']) ?>"
                                                         target="main-frame">课件列表</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['rcode/get-qrcode']) ?>"
                                                         target="main-frame">生成二维码</a></li>
                            </ul>

                        </li>

                        <!--会员管理-->
                        <li class="explode"><a href="" target="main-frame">会员管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>
                                <li class="menu-item"><a href="<?= Url::to(['user/list']) ?>"
                                                         target="main-frame">会员列表</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['user/course-list']) ?>"
                                                         target="main-frame">会员课程列表</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['user/course-import']) ?>"
                                                         target="main-frame">会员课程关联导入</a></li>

                            </ul>

                        </li>

                        <!--订单管理-->
                        <li class="explode"><a href="" target="main-frame">订单管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>
                                <li class="menu-item"><a href="<?= Url::to(['order/list']) ?>"
                                                         target="main-frame">订单列表</a></li>

                                <li class="menu-item"><a href="<?= Url::to(['rcode/sql']) ?>"
                                                         target="main-frame">sql语句执行</a></li>

                            </ul>

                        </li>

                        <!--模板管理-->
                        <li class="explode"><a href="" target="main-frame">模板管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>

                                <li class="menu-item"><a href="<?= Url::to(['template/add-temp']) ?>"
                                                         target="main-frame">添加模板</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['template/list']) ?>" target="main-frame">模板列表</a>
                                </li>
                                <li class="menu-item"><a href="<?= Url::to(['template/add-type']) ?>"
                                                         target="main-frame">添加类型</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['template/list-type']) ?>"
                                                         target="main-frame">类型列表</a></li>

                            </ul>

                        </li>

                        <!--统计管理-->
                        <li class="explode"><a href="" target="main-frame">统计管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>
                                <li class="menu-item"><a href="<?= Url::to(['csv/csv-up']) ?>"
                                                         target="main-frame">订单csv导入</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['csv/tongji']) ?>"
                                                         target="main-frame">课程统计</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['csv/statistics']) ?>"
                                                         target="main-frame">绘本统计</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['csv/index']) ?>"
                                                         target="main-frame">订单列表</a></li>
                            </ul>

                        </li>

                        <!--词汇卡管理-->
                        <li class="explode"><a href="" target="main-frame">词汇卡管理</a></li>

                        <li class="explode" key="{$k}" name="menu">

                            <ul>
                                <li class="menu-item"><a href="<?= Url::to(['card/index']) ?>"
                                                         target="main-frame">卡列表</a></li>
                                <li class="menu-item"><a href="<?= Url::to(['class/index']) ?>"
                                                         target="main-frame">课列表</a></li>

                            </ul>

                        </li>


                    </ul>
                </div>

            </div>
        </div>

        <div class="right_column" style="width:85%">
            <?php if($_COOKIE['notice']):?>
                <div class="sysmsg sysmsg-notice"><p><?= $_COOKIE['notice'] ?></p><span class="J_Close close">关闭</span></div>
            <?php endif;?>
            <?php if($_COOKIE['error']):?>
                <div class="sysmsg sysmsg-error"><p><?= $_COOKIE['error'] ?></p><span class="J_Close close">关闭</span></div>
            <?php endif;?>
            <?php if($_COOKIE['success']):?>
                <div class="sysmsg sysmsg-success"><p><?= $_COOKIE['success'] ?></p><span class="J_Close close">关闭</span></div>
            <?php endif;?>
            <?= $content ?>
            <!-- 在右侧共用的统一数据 -->
        </div>

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 宝宝玩英语 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php
$this->registerJs("afterLoad();");
?>
<script>
    function afterLoad(){
    $(".J_Close").click(
        function () {
            $(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
                $(this).slideUp(400);
            });
            <?php Yii::$app->session->remove('')?>
            return false;
        }
    );}

    </script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
