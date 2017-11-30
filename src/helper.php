<?php

use Laravue\Application;

/**
 * 获取配置
 */
if (! function_exists('config')) {
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

/**
 * 获取 app
 */
if (! function_exists('app')) {
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Application::getInstance();
        }

        return Application::getInstance()->make($make, $parameters);
    }
}

