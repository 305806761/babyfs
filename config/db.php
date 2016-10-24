<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=babyfs',
    'username' => 'root',
    'password' => '12345678',
    'charset' => 'utf8',
//    'on afterOpen'=>function($event){
//        $event->sender->createCommand("SET time_zone = 'UTC'")->execute();
//    }
];
