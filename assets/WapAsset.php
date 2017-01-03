<?php
/**
 * Created by PhpStorm.
 * User: pengboyu
 * Date: 16/12/9
 * Time: 上午10:02
 */

namespace app\assets;


use app\assets\AppAsset;

class WapAsset extends AppAsset
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'wap/css/index.css',
    ];

    public $js = [
        'wap/js/jquery-1.9.1.min.js',
        'wap/js/index.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
//        'yii\bootstrap\BootstrapAsset',
    ];

}