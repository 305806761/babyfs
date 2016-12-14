<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/9
 * Time: 上午10:02
 */

namespace app\assets;


use app\assets\AppAsset;

class LoginAsset extends AppAsset
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/default/one/css/default.css',
        '/default/one/css/jquery.mobile.flatui.css',
        '/default/one/css/global.css',
        '/default/one/css/index.css',
    ];

    public $js = [
        '/statics/money/js/jquery.mobile-1.4.0-rc.1.js',
        '/statics/money/js/iscroll.js',
        '/statics/money/js/swiper.min.js',
        '/statics/money/js/dropload.min.js',
        '/statics/money/js/common.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}