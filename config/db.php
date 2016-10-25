<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=babyfs_i',
    'username' => 'root',
    'password' => '12345678',
    'charset' => 'utf8',
//    'on afterOpen'=>function($event){
//        $event->sender->createCommand("SET time_zone = 'UTC'")->execute();
//    }
];
