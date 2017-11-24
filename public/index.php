<?php
define('PUBLIC_PATH', realpath(__DIR__ . '/../'));

require __DIR__ . '/../vendor/autoload.php'; //自动加载vendor目录

\Laravue\Application::getInstance(PUBLIC_PATH)->dispatch(); //加载配置，过滤中间件，分解路由