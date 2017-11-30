<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/12
 * Time: 10:31
 */
namespace Laravue;

use Laravue\Container\Container;
use Laravue\Config\Config as BaseConfig;

class Application extends Container
{
    /**
     * @var
     */
    public $base_dir;

    /**
     * @var
     */
    protected static $instance;

    /**
     * @var Config
     */
    public $config;

    /**
     * Application constructor.
     * @param $base_dir
     */
    protected function __construct($base_dir)
    {
        $this->base_dir = $base_dir;

        // 加载助手函数
        require $this->base_dir . '/src/helper.php';
        
        // 加载配置文件
        $this->bootConfig();

        $this->config = new Config($base_dir . '/config');
    }

    /**
     *
     */
    private function bootConfig()
    {
        $this->bind('config', function() {
            return new BaseConfig();
        });
    }

    /**
     * @param bool|string $base_dir
     * @return Application
     */
    static function getInstance($base_dir = ROOT_PATH)
    {
        if (empty(self::$instance))
        {
            self::$instance = new self($base_dir);
        }
        return self::$instance;
    }

    /**
     *
     */
    function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        list($c, $v) = explode('/', trim($uri, '/'));
        $class = 'App\\Controller\\' . ucwords($c); // 路由匹配

        $obj = $this->make($class); // 实现 controller 依赖注入

        $controller_config = config('controller');
        $decorators = [];

        if (! empty($conf_decorator = $controller_config['middleware']))
        {
            foreach($conf_decorator as $class)
            {
                $decorators[] = new $class;
            }
        }

        foreach($decorators as $decorator)
        {
            $decorator->beforeRequest($obj); // 前装饰
        }

        $return_value = $obj->$v();

        foreach($decorators as $decorator)
        {
            $decorator->afterRequest($return_value); // 后装饰
        }
    }
}