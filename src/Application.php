<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/12
 * Time: 10:31
 */
namespace Laravue;

class Application
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
        $this->config = new Config($base_dir . '/config');
    }

    /**
     * @param string $base_dir
     * @return Application
     */
    static function getInstance($base_dir = 'PUBLIC_PATH')
    {
        if (empty(self::$instance))
        {
            self::$instance = new self($base_dir);
        }
        return self::$instance;
    }

    function dispatch()
    {
        $uri = $_SERVER['REQUEST_URI'];
        list($c, $v) = explode('/', trim($uri, '/'));
        $class = '\\App\\Controller\\' . ucwords($c); //路由匹配
        $obj = new $class($c, $v);

        $controller_config = $this->config['controller'];
        $decorators = array();
        
        if (! empty($conf_decorator = $controller_config['decorator']))
        {
            foreach($conf_decorator as $class)
            {
                $decorators[] = new $class;
            }
        }

        foreach($decorators as $decorator)
        {
            $decorator->beforeRequest($obj); //前装饰
        }

        $return_value = $obj->$v();

        foreach($decorators as $decorator)
        {
            $decorator->afterRequest($return_value); //后装饰
        }
    }
}