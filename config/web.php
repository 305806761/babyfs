<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'zh-CN',
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert  a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'babyfs',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            //'useFileTransport' => false,    //这里一定要改成false，不然邮件不会发送
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.exmail.qq.com',  //每种邮箱的host配置不一样
//                'username' => 'bbwyy@babyfs.cn',
//                'password' => 'Qimeng1234',
//                'port' => '25',
//                'encryption' => 'tls',
//
//            ],
//            'messageConfig'=>[
//                'charset'=>'UTF-8',
//                'from'=>['bbwyy@babyfs.cn'=>'北京启萌教育科技有限公司']
//            ],

        ],
        'formatter' => [
            'dateFormat' => 'yyyy-MM-dd',
            'datetimeFormat' => 'yyyy-MM-dd HH:mm:ss',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CNY',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['test'],
                    'logFile' => '@app/runtime/logs/test.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
            ],
        ],

        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],

        'wechat' => [
            'class' => 'callmez\wechat\sdk\Wechat',
            'appId' => 'wx57d7c046fc6a6786',
            'appSecret' => '52af7a93d0ecc82ea1aa1436a82f51b9',
            'token' => 'babyfs'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //$config['bootstrap'][] = 'debug';
    //$config['modules']['debug'] = [
    //    'class' => 'yii\debug\Module',
    //];

    //$config['bootstrap'][] = 'gii';
    //$config['modules']['gii'] = [
    //    'class' => 'yii\gii\Module',
    //];
}

return $config;
