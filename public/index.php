<?php

define('ROOT_PATH', realpath(__DIR__ . '/../'));

// 自动加载 vendor 目录
require ROOT_PATH . '/vendor/autoload.php';

$app = Laravue\Application::getInstance(ROOT_PATH);

// 加载配置，过滤中间件，分解路由
$app->dispatch();