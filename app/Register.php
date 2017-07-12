<?php
/**
 * Created by PhpStorm.
 * User: zm
 * Date: 2017/7/12
 * Time: 14:51
 */
namespace App;

class Register
{
    /**
     * @var
     */
    protected static $objects;

    /**
     * @param $alias
     * @param $object
     */
    static function set($alias, $object) //注册器模式
    {
        self::$objects[$alias] = $object;
    }

    /**
     * @param $key
     * @return bool
     */
    static function get($key)
    {
        if (!isset(self::$objects[$key]))
        {
            return false;
        }
        return self::$objects[$key];
    }

    /**
     * @param $alias
     */
    function _unset($alias)
    {
        unset(self::$objects[$alias]);
    }
}