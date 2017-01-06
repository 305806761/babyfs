<?php

return [
    'adminEmail' => 'admin@example.com',
    'youzan_appid' => '125ec687338926758c',
    'youzan_secret' => '00bf023ac1dc1f20d1e63f9275eb862f',
    //date("Y-m-d",strtotime("-1 month"))
    'course_expire' => strtotime("+2 year"),
    'free' => [13,14],
    'template_types' => [
        'text' => '文字',
        'image' => '图片',
        'video' => '视频',
        'audio' => '音频',
        'text_array' => '文字组',
    ],

];
