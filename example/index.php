<?php

use DcrPHP\Config\Config;
use DcrPHP\Container\Container;

require_once("../vendor/autoload.php");

ini_set('display_errors', 'on');

//获取支持的类 只获取 src/Component 下声明的类
#Container::classList();

//某类的文档说明 参数为使用名  只获取 src/Component 下声明的类
#Container::classList('elasticsearch');

//使用：
//配置组件有2种方式：通过配置文件的auto_bind绑定 或 通过定义组件声明
//写组件的配置文件时,请用组件short name做配置的php文件名 比如config/elasticsearch.php config/container.php
$clsConfig = new Config(__DIR__ . DIRECTORY_SEPARATOR . 'config');

//通过组件声明 就是通过定义src/Component下的类来声明
#组件要用的配置可以通过Container::classList('elasticsearch');来查看

//通过auto_bind绑定 如你想把 class Test{} 绑定给test则：
# class Test{}
#$clsConfig->set('container', array('auto_bind'=>array('test'=>'Test')));
#或在config下建立container.php 内容是:return array('auto_bind'=>array('test'=>'Test')); 可以看config下的container.php案例

#用config类去初始化 后面要用直接用Container::getInstance();
$clsContainer = Container::getInstance($clsConfig);

#使用elasticsearch
$clsElasticsearch = $clsContainer->get('elasticsearch'); #获取了DcrPHP\Data\Elasticsearch的实例
var_dump($clsElasticsearch);
#$clsElasticsearch = $clsElasticsearch ? $clsElasticsearch : new DcrPHP\Data\Elasticsearch(); #无意义的代码之小技巧：代码提示
#$clsEs = $clsElasticsearch->getClient();
#var_dump($clsEs->get(array('index' => 'test', 'id' => 1)));

#使用Test类
#var_dump($clsContainer->get('test'));