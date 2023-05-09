<?php
define('ROOT_PATH', __DIR__);
$DB = [
    'mysql' => [
        'host' => getenv('MYSQL_HOST') ? getenv('MYSQL_HOST') : 'db',
        'database' => getenv('MYSQL_DATABASE') ? getenv('MYSQL_DATABASE') : 'OnlineEnterprise',
        'user' =>  getenv('MYSQL_USER') ? getenv('MYSQL_USER') : 'hmm',
        'password' =>  getenv('MYSQL_PASSWORD') ? getenv('MYSQL_PASSWORD') : 'webAss123'
    ]
];
