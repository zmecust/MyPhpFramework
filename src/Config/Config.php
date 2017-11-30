<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/11/12
 * Time: 10:35
 */
namespace Laravue\Config;

class Config
{
    /**
     * @var
     */
    protected $path;

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * Config constructor.
     * @param $path
     */
    public function __construct()
    {
        $this->path = ROOT_PATH . '/config';
    }

    /**
     * @param mixed $key
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (empty($this->configs[$key])) {
            $file_path = $this->path . '/' . $key . '.php';
            $config = require $file_path;
            $this->configs[$key] = $config;
        }
        return $this->configs[$key];
    }
}