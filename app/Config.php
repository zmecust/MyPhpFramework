<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 10:35
 */
namespace App;

class Config implements \ArrayAccess //初始化配置文件
{
    /**
     * @var
     */
    protected $path;

    /**
     * @var array
     */
    protected $configs = array();

    /**
     * Config constructor.
     * @param $path
     */
    function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    function offsetGet($key)
    {
        if (empty($this->configs[$key]))
        {
            $file_path = $this->path.'/'.$key.'.php';
            $config = require $file_path;
            $this->configs[$key] = $config;
        }
        return $this->configs[$key];
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @throws \Exception
     */
    function offsetSet($key, $value)
    {
        throw new \Exception("cannot write config file.");
    }

    /**
     * @param mixed $key
     * @return bool
     */
    function offsetExists($key)
    {
        return isset($this->configs[$key]);
    }

    /**
     * @param mixed $key
     */
    function offsetUnset($key)
    {
        unset($this->configs[$key]);
    }
}