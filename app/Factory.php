<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 14:50
 */
namespace App;

use App\Database\Proxy;

class Factory
{
    /**
     * @var Proxy
     */
    protected $proxy;

    /**
     * Factory constructor.
     * @param Proxy $proxy
     */
    public function __construct(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * @param $model
     * @param $id
     * @return bool
     */
    static function getModel($model, $id)
    {
        $key = 'app_model_'.$model;
        $value = Register::get($key);

        if (! $value) {
            $class = '\\App\\Model\\' . $model;

            $value = new $class(lcfirst($model), $id);
            Register::set($key, $value);
        }

        return $value;
    }

    /**
     * @param string $id
     * @return Database\Mysqli|Proxy|bool
     */
    static function getDatabase($id = 'proxy')
    {
        if ($id == 'proxy') //判断是否启动代理模式
        {
            if (!self::$proxy)
            {
                self::$proxy = new Proxy;
            }
            return self::$proxy;
        }

        $key = 'database_'.$id;

        if ($id == 'slave') {
            $slaves = Application::getInstance()->config['database']['slave'];
            $db_conf = $slaves[array_rand($slaves)];
        } else {
            $db_conf = Application::getInstance()->config['database'][$id];
        }

        $db = Register::get($key);

        if (!$db) {
            $db = new Database\Mysqli;
            $db->connect($db_conf['host'], $db_conf['user'], $db_conf['password'], $db_conf['database']);
            Register::set($key, $db);
        }

        return $db;
    }
}