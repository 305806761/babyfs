<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="theme theme--blue theme-new-ui    show-help" style="">
<?php $this->beginBody() ?>


<!-- ▼ Main sidebar -左边--->
<aside id="app-sidebar">
    <div id="app-first-sidebar">
        <div style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">

            <a class="team-logo-wrap" href="https://koudaitong.com/v2/setting/store#index">
                <div class="team-logo" style="background-image: url(https://img.yzcdn.cn/upload_files/2016/02/28/8f41cf9be36beb615b5b66d23c8c7e2e.jpeg?imageView2/2/w/60/h/60/q/75/format/jpeg)">
                </div>
            </a>

            <nav>
                <ul class="clearfix">
                    <li>
                        <a href="">
                            <i class="sidebar-icon sidebar-icon-dashboard"></i>
                            课程
                        </a>
                    </li>
                    <li class="active">
                        <a href="">
                            <i class="sidebar-icon sidebar-icon-ware"></i>
                            课件
                        </a>
                    </li>
                    <li class="js-guide-goods ">
                        <a href="">
                            <i class="sidebar-icon sidebar-icon-goods"></i>
                            会员
                        </a>
                    </li>
                    <li class="js-guide-trade ">
                        <a href="">
                            <i class="sidebar-icon sidebar-icon-template"></i>
                            模板
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div id="app-user-info">
        <span class="user-name">宝宝玩英语</span>
        <span class="user-arrow"></span>
        <div class="user-dropdown">
            <div class="user-dropdown-meta">
                <div>宝宝玩英语</div>
                <div>15801639097</div>
            </div>
            <div class="user-dropdown-select">
                <a class="new-select" href="https://koudaitong.com/v2/account/personal/invitecode">个人邀请奖励</a>
                <a href="https://koudaitong.com/v2/account/personal">帐号设置</a>
                <a href="https://koudaitong.com/v2/account/team#select">切换店铺</a>
                <a href="https://koudaitong.com/v2/account/user/logout">退出</a>
            </div>
        </div>
    </div>

    <div id="app-second-sidebar">
        <div style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
            <div class="second-sidebar-ware">
                课件管理
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="https://koudaitong.com/v2/showcase/dashboard">课件列表</a>
                    </li>
                    <li class="active">
                        <a href="https://koudaitong.com/v2/showcase/feature#list">生成课件</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div style="transition-timing-function: cubic-bezier(0.1, 0.57, 0.1, 1); transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">
            <div class="second-sidebar-template">
                模板管理
            </div>
            <nav>
                <ul>
                    <li>
                        <a href="https://koudaitong.com/v2/showcase/dashboard">模板列表</a>
                    </li>
                    <li class="active">
                        <a href="https://koudaitong.com/v2/showcase/feature#list">添加模板</a>
                    </li>
                </ul>
            </nav>
        </div>




    </div>
</aside><!-- ▲ Main sidebar -->

<!-- ▼ Main container 右边-->
<div id="app-container" class="container" style="">



    <div class="app" style="">
        <?= $content ?>
    </div>
</div><!-- ▲ Main container -->

<div id="app-help-container" style="min-height: 1080px;" class="show-help"><div class="help-container-head">
        <i class="app-help-icon app-help-icon-help"></i>
        <span>帮助和服务</span>
        <i class="app-help-icon app-help-icon-close"></i>
    </div>
    <div class="help-container-body">
        <div>
            <div class="help-body-title">
                帮助中心
                <a href="https://koudaitong.com/v2/service" target="_blank" class="pull-right">
                    进入 <i class="app-help-icon app-help-icon-more"></i>
                </a>
            </div>

            <div class="help-body-content">
                <p><span style="color: #333333;">什么是自定义组件？</span><br><span style="color: #999999;">为了满足商家对店铺主页个性化的要求，我们不仅提供多种精美的页面模板，还有丰富的自定义组件，商家可灵活运用自定义组件去实现各种效果，装修属于自己的店铺主页。<br>请点击使用左侧预览框下方[添加内容]区域里的自定义组件，挨个试试看效果，你会发现新的世界。</span></p>
                <p><span style="color: #999999;">微页面的草稿会每30秒自动保存一次，但建议商家每做完一步操作就保存一次草稿，养成好习惯，内容有保障。</span></p>
                <hr>
                <p><a href="https://bbs.youzan.com/forum.php?mod=viewthread&amp;tid=19502" target="_blank">店铺主页装修全攻略</a></p>
            </div>


            <div class="help-body-split-line"></div>
            <div style="margin: 0 10px;">
                <a href="http://bbs.youzan.com/forum.php?gid=57" target="_blank">
                    <i class="app-help-icon app-help-icon-service"></i>
                    联系客服
                </a>
                <a href="http://bbs.youzan.com/forum.php?mod=viewthread&amp;tid=517841&amp;extra=page%3D1" target="_blank" style="margin-left: 24px;">
                    <i class="app-help-icon app-help-icon-feedback"></i>
                    需求建议
                </a>
            </div>

            <div class="help-body-split-line"></div>
            <div class="help-body-title">联系有赞经理提供咨询服务</div>
            <div class="clearfix">
                <div class="pull-left" style="width: 80px; height: 80px; margin-left: 10px;">
                    <img src="files/afcd4e64db6aaf893142d28913a1541c.jpg" width="80" height="80">
                </div>
                <div class="pull-left" style="width: 60px; margin-left: 10px;">
                    <div style="margin: 13px 0;">宅宅</div>
                    <div>微信号:</div>
                    <div>youzanzhaizhai</div>
                </div>
            </div>


            <div class="help-body-split-line"></div>
            <div class="help-body-title">
                有赞代理商
                <a href="https://fuwu.youzan.com/" target="_blank" class="pull-right">
                    找服务 <i class="app-help-icon app-help-icon-more"></i>
                </a>
            </div>

            <ul class="fuwu-list">

                <li class="fuwu-item">
                    <a href="https://fuwu.youzan.com/detail?id=259" target="_blank">
                        <div class="fuwu-item-logo" style="background-image: url(https://img.yzcdn.cn/upload_files/2016/01/28/FvoVbJNyWaaETo0IeWoV444sXA7U.jpg?imageView2/2/w/64/h/64/q/75/format/jpg)"></div>
                        <div class="fuwu-item-info">
                            <div class="fuwu-item-name">北京白石互动网络科技有限公司</div>
                            <div class="fuwu-item-province">北京市 北京市</div>
                        </div>
                    </a>
                </li>

            </ul>

        </div>
    </div>
</div>
<div id="app-footer">
    <a href="https://youzan.com/" class="logo" target="_blank"></a>
</div>

<script src="files/stacktrace.js" onerror="_cdnFallback(this)"></script>
<!-- ▼ App JS -->
<script>
    "use strict";!function(n,e){"function"==typeof define&&define.amd?define([],e(n,n.document)):n.Loader=e(n,n.document)}(this,function(n,e){function t(n){return"complete"===n.readyState||"loaded"===n.readyState}function o(n,t,o){var i=e.createElement("link");i.rel="stylesheet",a(i,o,"css"),i.async=!0,i.href=n,s.appendChild(i)}function i(n,t,o){var i=e.createElement("script");i.charset="utf-8",a(i,o,"js"),i.async=!t.sync,i.src=n,s.appendChild(i)}function c(n,e){var t;n.sheet&&(t=!0),setTimeout(function(){t?e():c(n,e)},20)}function a(e,o,i){function a(){e.onload=e.onreadystatechange=null,e=null,o()}var r="onload"in e,u="css"===i;return!u||!l&&r?void(r?(e.onload=a,e.onerror=function(){e.onerror=null,n._cdnFallback(e)}):e.onreadystatechange=function(){t(e)&&a()}):void setTimeout(function(){c(e,o)},1)}function r(n,e,t,c){function a(){var t=e.indexOf(n);t>-1&&e.splice(t,1),0===e.length&&c()}f.test(n)?o(n,t,a):i(n,t,a)}function u(n,e,t){var o=function(){t&&t()};if(n=Array.prototype.slice.call(n||[]),0===n.length)return void o();for(var i=0,c=n.length;c>i;i++)r(n[i],n,e,o)}function d(e,o){if(t(e))o();else{var i=1500,c=!1;n.addEventListener("load",function(){c||(o(),c=!0)}),setTimeout(function(){c||(o(),c=!0)},i)}}var f=new RegExp("\\.css"),s=e.head||e.getElementsByTagName("head")[0],l=+navigator.userAgent.replace(/.*(?:AppleWebKit|AndroidWebKit)\/?(\d+).*/i,"$1")<536,y={async:function(n,t){d(e,function(){u(n,{},t)})},sync:function(n,t){d(e,function(){u(n,{sync:!0},t)})}};return n.Loader=y,y});	</script>
<script src="files/require.js" onerror="_cdnFallback(this)"></script><script src="files/global_f2429a35bc.js" onerror="_cdnFallback(this)" crossorigin="anonymous"></script><script src="files/ueditor_002.js"></script>
<script src="files/ueditor.js"></script>


<!-- <script src="https://b.yzcdn.cn/v2/vendor/ueditor/dist/ueditor.config.js"></script>
<script src="https://b.yzcdn.cn/v2/vendor/ueditor/dist/ueditor.all.js"></script> -->

<script src="files/feature_15281b331d.js" onerror="_cdnFallback(this)" crossorigin="anonymous"></script>

<script>
    window.onReady('requirejs', function() {
        var req = require.config({
            baseUrl: 'https://static.koudaitong.com/v2/www/pages/showcase/feature'
        });
        window.req = req

        req(['main'], function(App) {
            if (App && App.initialize && (Object.prototype.toString.call(App.initialize) == '[object Function]')) {
                App.initialize();
            }
        }, function(err) {
            if (window.TraceKit && TraceKit.report) {
                TraceKit.report(err);
            }
        });
    })
</script><!-- ▲ App JS -->

<div style="display:none;">
    <script type="text/javascript">
        // 在其他资源全部加载完成后，加载统计的脚本
        (function() {

            var protocol = (("https:" == document.location.protocol) ? " https://" : " http://");

            // Baidu统计
            var _hmt = _hmt || [];
            (function() {
                var hm = document.createElement("script");
                hm.src = "//hm.baidu.com/hm.js?7fff7ceede91c07fb0a2f9c1850d7987";
                var s = document.getElementsByTagName("script")[0];
                s.parentNode.insertBefore(hm, s);
            })();

            // 页面按钮点击，访问路径统计
            var _vds = _vds || [];
            _vds.push(['setAccountId', '767813e963734402a8256e1096b88331']);
            _vds.push(['setOrigin', protocol + 'youzan.growing.io']);
            window._vds = _vds;
            Loader.async([protocol + 'dn-growing.qbox.me/vds.js']);

        })();

        try {
            if (window.console && window.console.log) {
                console.log("%c", "padding:20px 200px; line-height:80px;background:url('http://b.yzcdn.cn/v2/image/intro/logo.png') no-repeat center center");
                console.log('如何让我遇见你，在你最美的时候\n加入有赞，去中心化的消费平台，你，可以让世界更美好一些\n');
                console.log("请将简历发送至 %c hr@qima-inc.com（邮件标题请以“姓名-应聘XX职位-来自console”命名）", "color:red");
                console.log("职位介绍：http://job.youzan.com\n\n");
            }
        } catch (e) {}

    </script>
</div>
<!--结束-->
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 宝宝玩英语 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
