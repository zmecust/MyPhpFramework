<?php
return [
    // 'cachePath' => PUBLIC_PATH . '/storage/cache/'
    'redis' => [
        'host' => 'localhost',
        'port' => 6379,
        'database' => 0,
        'password' => false,
        // 'options' => [Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP],
    ]
];
