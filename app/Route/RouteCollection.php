<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/13
 * Time: 22:58
 */
namespace App\Route;

class RouteCollection
{
    protected $routes = [];

    private static $_instance;    //保存类实例的私有静态成员变量

    //定义一个私有的构造函数，确保单例类不能通过new关键字实例化，只能被其自身实例化
    private final function __construct() {}

    //定义私有的__clone()方法，确保单例类不能被复制或克隆
    private function __clone() {}

    //对外提供获取唯一实例的方法
    public static function getInstance()
    {
        //检测类是否被实例化
        if ( ! (self::$_instance instanceof self) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function addRoutes($uri, $config)
    {
        $this->routes[$uri] = explode('@', $config);
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}