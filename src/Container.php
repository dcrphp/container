<?php

declare(strict_types=1);


namespace DcrPHP\Container;


use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{

    /**
     * @var null 实例
     */
    private static $instance = null;

    /**
     * @var array 绑定的列表
     */
    private $autoBindList = [];

    /**
     * @var array 用于存窗口的实例列表 这里存的是类名=>实例 如array('DcrPHP\Config\Config'=>$clsConfig)
     */
    private $instanceList = [];

    /**
     * 禁止实例化
     */
    private function __construct()
    {
    }

    /**
     * 禁止克隆
     */
    private function __clone()
    {
    }

    /**
     * 获取实例
     */
    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
            self::$instance->autoBind();
        }
        return self::$instance;
    }

    /**
     * @param $abstract 绑定名称
     * @param null $concrete 名称或实例
     */
    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->autoBindList[$abstract] = $concrete;
    }

    /**
     * 自动绑定的类
     */
    public function autoBind()
    {
        $bindList = self::$instance->get('DcrPHP\\Config\\Config')->get('container.bind');
        if ($bindList) {
            foreach ($bindList as $key => $bindInfo) {
                $this->bind($key, $bindInfo);
            }
        }
    }

    /**
     * @param $clsConfig
     * @throws \Exception
     */
    public function setConfig($clsConfig)
    {
        $this->instance("DcrPHP\Config\Config", $clsConfig);
    }

    /**
     * 获取绑定的实例类名
     *
     * @param string $abstract 可以是short_name或class_name
     * @return mixed $concrete
     * @throws \Exception
     */
    protected function getConcrete($abstract)
    {
        //先从自动的绑定里找
        if (isset($this->autoBindList[$abstract])) {
            return $this->autoBindList[$abstract];
        }
        //再从定义里找
        if(!class_exists($abstract)){
            //类不存在 说明用的可能是短名
            //从component找到类名
            $className = "DcrPHP\\Container\\Component\\" . ucfirst($abstract);
            if(!class_exists($className)){
                throw new \Exception('没有找到本类，请确定component下有这个类的定义');
            }
            $cls = new $className();
            $abstract = $cls->getClassName();
            if(!class_exists($abstract)){
                self::classList($cls->getShortName());
                throw new \Exception('没有这个类，请先配置好composer');
            }
        }

        return $abstract;
    }

    /**
     * 绑定类实例
     * @param $abstract 可以是short_name或class_name
     * @param $instance 实例
     * @return object
     * @throws \Exception
     */
    public function instance($abstract, $instance)
    {
        $concrete = $this->getConcrete($abstract);
        $this->instanceList[$concrete] = $instance;
        return $instance;
    }

    /**
     * @param $abstract 可以是short_name或class_name
     * @return mixed|object
     * @throws \ReflectionException|\Exception
     */
    public function make($abstract)
    {
        $concrete = $this->getConcrete($abstract);

        if (isset($this->instanceList[$concrete])) {
            return $this->instanceList[$concrete];
        }

        //开始实例化
        $reflector = new \ReflectionClass($concrete);

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            $instance = new $concrete();
            $this->instance($concrete, $instance);
            return $instance;
        }
        //构造函数是私有的
        if ($constructor->isPrivate()) {
            $instance = $concrete::getInstance();
            $this->instance($concrete, $instance);
            return $instance;
        }
        //解决构造参数里的实例
        $dependenciesList = $constructor->getParameters();

        $dependencies = $this->resolveConstructor($dependenciesList);

        $instance = $reflector->newInstanceArgs($dependencies);

        $this->instance($concrete, $instance);
        return $instance;
    }

    /**
     * 解决构造函数
     * @param $dependencies 参数列表
     * @return array
     * @throws \ReflectionException
     */
    public function resolveConstructor($dependencies)
    {
        if (empty($dependencies)) {
            return [];
        }
        foreach ($dependencies as $dependency) {
            $results[] = is_null($dependency->getClass())
                ? $this->resolvePrimitive($dependency)
                : $this->resolveClass($dependency);
        }
        return $results;
    }

    /**
     * 解决构造函数里的非类数值
     * @param $parameter
     * @return object
     * @throws \ReflectionException
     */
    public function resolvePrimitive(\ReflectionParameter $parameter)
    {
        if ($parameter->isDefaultValueAvailable()) {
            return $parameter->getDefaultValue();
        } else {
            return [];
        }
    }

    /**
     * 解决构造函数里的类实例化
     * @param $parameter
     * @return mixed|object
     * @throws \Exception
     */
    public function resolveClass(\ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * 展示组件的说明文档
     * @param string $shortName
     */
    public static function classList($shortName = '')
    {
        //得出component directory
        $clsRC = new \ReflectionClass(__CLASS__);
        $pathInfo = pathinfo($clsRC->getFileName());
        $componentDir = $pathInfo['dirname'] . DIRECTORY_SEPARATOR . 'Component';

        $fileList = scandir($componentDir);
        $docList = array();
        foreach ($fileList as $fileName) {
            if (in_array($fileName, array('.', '..'))) {
                continue;
            }
            $pathInfo = pathinfo($fileName);
            $className = "DcrPHP\\Container\\Component\\" . $pathInfo['filename'];
            $cls = new $className();
            if ($shortName) {
                if ($cls->getShortName() == $shortName) {
                    $docList[$cls->getShortName()] = $cls->getDoc();
                }
            } else {
                $docList[$cls->getShortName()] = $cls->getDoc();
            }
        }
        foreach ($docList as $doc) {
            echo $doc . PHP_EOL;
        }
    }

    /**
     * 获取组件
     * @param string $abstract 可以是short_name或class_name
     * @return mixed
     * @throws \Exception
     */
    public function get($abstract)
    {
        if (!$this->has($abstract)) {
            return $this->make($abstract);
        } else {
            $className = $this->getConcrete($abstract);
            return $this->instanceList[$className];
        }
    }

    /**
     * 组件是否存在
     * @param string $abstract 可以是short_name或class_name
     * @return bool
     * @throws \Exception
     */
    public function has($abstract)
    {
        $className = $this->getConcrete($abstract);
        return in_array($className, $this->instanceList);
    }
}