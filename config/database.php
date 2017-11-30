<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 10:57
 */
return [
    'dsn' => 'mysql:host=127.0.0.1;dbname=test',
    'username' => 'root',
    'password' => 'root',
    'attributes' => [
        \PDO::ATTR_EMULATE_PREPARES => false,
        \PDO::ATTR_STRINGIFY_FETCHES => false,
    ]
];
