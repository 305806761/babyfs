<?php

return [
    'adminEmail' => 'admin@example.com',
    'youzan_appid' => '125ec687338926758c',
    'youzan_secret' => '00bf023ac1dc1f20d1e63f9275eb862f',
    //date("Y-m-d",strtotime("-1 month"))
    'course_expire' => strtotime("+2 year"),
    'template_types' => [
        'text' => '文字',
        'image' => '图片',
        'video' => '视频',
        'audio' => '音频',
        'text_array' => '文字组',
    ],
    'wechat' => [
        'class' => 'callmez\wechat\sdk\Wechat',
        'appId' => 'wx57d7c046fc6a6786',
        'appSecret' => '52af7a93d0ecc82ea1aa1436a82f51b9',
        'token' => 'babyfs'
    ]
];
