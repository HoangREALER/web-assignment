<?php
define('ROOT_PATH', __DIR__);
$DB = [
    'mysql' => [
        'host' => getenv('MYSQL_HOST') ? getenv('MYSQL_HOST') : 'localhost',
        'database' => getenv('MYSQL_DATABASE') ? getenv('MYSQL_DATABASE') : 'OnlineStore',
        'user' =>  getenv('MYSQL_USER') ? getenv('MYSQL_USER') : 'root',
        'password' =>  getenv('MYSQL_PASSWORD') ? getenv('MYSQL_PASSWORD') : 'webAss@123'
    ]
];
