<?php

namespace Laravue\Container;

//服务容器
class Container
{
    protected $binds;

    protected $instances;

    public function bind($abstract, $concrete)
    {
        if ($concrete instanceof Closure) {
            $this->binds[$abstract] = $concrete;
        } else {
            $this->instances[$abstract] = $concrete;
        }
    }

    public function make($abstract, $parameters = [])
    {
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        array_unshift($parameters, $this); //在数组前面添加$this (array_shift\array_push\array_pop)

        return call_user_func_array($this->binds[$abstract], $parameters); //执行回调函数
    }
}