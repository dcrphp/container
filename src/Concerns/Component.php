<?php

namespace DcrPHP\Container\Concerns;

abstract class Component
{
    protected $shortName;
    protected $className;
    protected $composerList;
    protected $docConfig;
    protected $example;

    /**
     * 类的简化名 比如session config
     * @param $shortName
     * @return mixed
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;
    }

    /**
     * 获取短名
     * @return mixed
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * 使用的类名
     * @param $className
     * @return mixed
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * 获取短名
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * 启用组件要用到的composer列表
     * @param $composerList
     * @return mixed
     */
    public function setComposerList($composerList)
    {
        $this->composerList = $composerList;
    }

    /**
     * 启用这个组件的配置的说明
     * @param $docConfig
     * @return mixed
     */
    public function setConfig($docConfig)
    {
        $this->docConfig = $docConfig;
    }

    /**
     * 启用组件要用到的composer列表
     * @param $example
     * @return mixed
     */
    public function setExample($example)
    {
        $this->example = $example;
    }

    public function getDoc()
    {
        return PHP_EOL . "使用名:{$this->shortName}" . PHP_EOL . "类名:{$this->className}" . PHP_EOL . "composer添加:" . implode(',', $this->composerList) . PHP_EOL . '配置方式:' . $this->docConfig . PHP_EOL . '使用案例:' . $this->example . PHP_EOL;
    }
}
