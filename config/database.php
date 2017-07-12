<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 10:57
 */
$config = [
    'master' => [
        'type' => 'MySQL',
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => 'root',
        'database' => 'test',
    ],
    'slave' => [
        'slave1' => [
            'type' => 'MySQL',
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'root',
            'database' => 'test',
        ],
        'slave2' => [
            'type' => 'MySQL',
            'host' => '127.0.0.1',
            'user' => 'root',
            'password' => 'root',
            'database' => 'test',
        ],
    ],
];

return $config;