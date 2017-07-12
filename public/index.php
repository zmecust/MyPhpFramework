<?php

require __DIR__.'/../vendor/autoload.php'; //自动加载vendor目录

\App\Application::getInstance(
    realpath(__DIR__.'/../')
)->dispatch(); //加载配置，过滤中间件，分解路由