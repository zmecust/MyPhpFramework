<?php

class Container
{
    /**
     * @var array
     */
    protected $instances = [];

    // 别名
    protected $aliases = [];

    // 闭包绑定
    protected $bindings = [];

    // 判断是否互相依赖
    protected $interdepend = [];


    /**
     * @param $abstract
     * @param null $concrete
     * @param bool $shared
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        $abstract = $this->normalize($abstract);
        $concrete = $this->normalize($concrete);
        // 如果直接是就绑定对象
        if (is_object($concrete)) {
            $this->instances[$abstract] = $concrete;
        }
        // 移除以前存在的绑定
        $this->dropStaleInstances($abstract);
        if (is_null($concrete)) {
            $concrete = $abstract;
        }
        // 统一转换成匿名函数，用到的时候再实例化，实现按需加载
        if (!$concrete instanceof Closure) {
            $concrete = $this->getClosure($abstract, $concrete);
        }
        // 存入绑定数组中
        $this->bindings[$abstract] = compact('concrete', 'shared');
    }

    /**
     * 绑定实例
     * @param $abstract
     * @param null $concrete
     */
    public function bindSingle($abstract, $concrete = null)
    {
        $this->bind($abstract, $concrete, true);
    }

    /**
     * 删除之前绑定的实例
     * @param $abstract
     */
    public function dropStaleInstances($abstract)
    {
        unset($this->instances[$abstract], $this->aliases[$abstract]);
    }

    /**
     * 转换成匿名函数
     * @param $abstract
     * @param $concrete
     * @return Closure
     */
    public function getClosure($abstract, $concrete)
    {
        return function ($container, $parameters) use ($abstract, $concrete) {
            $method = ($abstract == $concrete) ? 'build' : 'make';
            return $container->$method($concrete, $parameters);
        };
    }

    /**
     * 生产实例
     * @param $abstract
     * @param array $parameters
     * @return mixed|object
     * @throws Exception
     */
    public function make($abstract, array $parameters = [])
    {
        $abstract = $this->normalize($abstract);
        // 是否相互依赖关系
        if ($this->isInterdepend($abstract)) {
            throw new \Exception($this->getInterdependError());
        }
        // 如果实例已经存在，则直接返回
        if (isset($this->instances[$abstract])) {
            // 清空是否相互依赖数组
            $this->interdepend = [];
            return $this->instances[$abstract];
        }
        // 获取绑定
        $concrete = isset($this->bindings[$abstract]['concrete']) ? $this->bindings[$abstract]['concrete'] : $abstract;
        // 生成实例
        $object = $this->build($concrete, $parameters);
        if ($this->isShared($abstract)) {
            $this->instances[$abstract] = $object;
        }
        // 清空是否相互依赖数组
        $this->interdepend = [];
        return $object;
    }

    /*
     *  是否是单例
     * @param $abstract
     * @return bool
     */
    protected function isShared($abstract)
    {
        $abstract = $this->normalize($abstract);
        // 判断是否存在实例
        if (isset($this->instances[$abstract])) {
            return true;
        }
        // 是否为单例
        if (!isset($this->bindings[$abstract]['shared'])) {
            return false;
        }
        return $this->bindings[$abstract]['shared'] === true;
    }

    /**
     * 检查是否相互依赖
     * @param $abstract
     * @return bool
     */
    protected function isInterdepend($abstract)
    {
        if (isset($this->interdepend[$abstract])) {
            return true;
        }
        $this->interdepend[$abstract] = $abstract;
        return false;
    }

    /**
     * 相互依赖错误消息
     * @return string
     */
    protected function getInterdependError()
    {
        $msg = '';
        foreach ($this->interdepend as $value) {
            $msg .= $value . ' ===> ';
        }
        $msg .= reset($this->interdepend);
        // 清空是否相互依赖数组
        $this->interdepend = [];
        return $msg;
    }

    // 取出多余的斜杆
    protected function normalize($service)
    {
        return is_string($service) ? ltrim($service, '\\') : $service;
    }

    public function build($concrete, array $parameters = [])
    {
        // 如果是匿名函数
        if ($concrete instanceof Closure) {
            // 是因为传入的回调是这样的 $app->bind('route', function($app){}); 默认有一个容器实例
            return $concrete($this, $parameters);
        }
        // 不是闭包，则通过反射获取实例
        $reflector = new \ReflectionClass($concrete);
        // 若类是否可以实例化
        if (!$reflector->isInstantiable()) {
            throw new \Exception("{$concrete}=>类异常，不是实例化");
        }
        // 获取类的构造函数
        $constructor = $reflector->getConstructor();
        // 类的构造函数没有依赖参数，直接创建
        if (is_null($constructor)) {
            return new $concrete;
        }
        // 获取反射类所构造类的参数依赖，即参数类型
        $dependencies = $constructor->getParameters();
        // 把索引数组参数 $parameters 转换成关联数组，键为函数参数的名字
        $parameters = $this->keyParametersByArgument(
            $dependencies, $parameters
        );
        // 处理依赖关系
        $instances = $this->getDependencies(
            $dependencies, $parameters
        );
        // 传入原本类构造函数的参数
        return $reflector->newInstanceArgs($instances);
    }

    /**
     * @param array $dependencies
     * @param array $parameters
     * @return array
     */
    protected function keyParametersByArgument(array $dependencies, array $parameters)
    {
        foreach ($parameters as $key => $value) {
            if (is_numeric($key)) {
                unset($parameters[$key]);
                $parameters[$dependencies[$key]->name] = $value;
            }
        }
        return $parameters;
    }

    /**
     * 解决所有依赖关系
     * @param array $parameters
     * @param array $primitives
     * @return array
     */
    protected function getDependencies(array $parameters, array $primitives = [])
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            /**
             * $primitives 为键值对化后的参数，  $dbh->PDO 实例
             */
            if (array_key_exists($parameter->name, $primitives)) {
                $dependencies[] = $primitives[$parameter->name];
            } elseif (is_null($dependency)) {
                $dependencies[] = $this->resolveNonClass($parameter);
            } else {
                $dependencies[] = $this->resolveClass($parameter);
            }
        }
        return $dependencies;
    }

    protected function resolveNonClass(ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        }
        $message = "Unresolvable dependency resolving [$parameter] in class {$parameter->getDeclaringClass()->getName()}";
        throw new \Exception($message);
    }

    protected function resolveClass(ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        }
            // If we can not resolve the class instance, we will check to see if the value
            // is optional, and if it is we will return the optional parameter value as
            // the value of the dependency, similarly to how we do this with scalars.
        catch (\Exception $e) {
            if ($parameter->isOptional()) {
                return $parameter->getDefaultValue();
            }
            throw $e;
        }
    }
}
