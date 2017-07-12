<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 10:31
 */
namespace App;

use App\Request\Request;

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
        $this->config = new Config($base_dir.'/config');
    }

    /**
     * @param string $base_dir
     * @return Application
     */
    static function getInstance($base_dir = '')
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
        if (empty(array_slice(explode('/', trim($uri, '/')), 2))) {
            $path = $this->base_dir.'/template/welcome.php';
            include $path;
        } else {
            list($c, $v) = array_slice(explode('/', trim($uri, '/')), 2);
            $c = ucwords($c);
            $class = '\\App\\Controller\\'.$c;
            $obj = new $class($c, $v);
            $return_value = $obj->$v();

            $controller_config = $this->config['controller'];
            $decorators = array();

            if (isset($controller_config['decorator']))
            {
                $conf_decorator = $controller_config['decorator'];
                foreach($conf_decorator as $class)
                {
                    $decorators[] = new $class;
                }
            }

            foreach($decorators as $decorator) //前装饰(前过滤，验证权限)
            {
                $decorator->beforeRequest($obj);
            }

            foreach($decorators as $decorator) //后装饰(后过滤, 模板渲染)
            {
                $decorator->afterRequest($return_value);
            }
        }
    }
}