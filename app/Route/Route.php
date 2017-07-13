<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/13
 * Time: 22:17
 */
namespace App\Route;

class Route
{
    public static function get($uri, $config)
    {
        RouteCollection::getInstance()->addRoutes($uri, $config);
    }
}