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

//配置组件有2种方式：通过bind绑定 或 通过定义组件声明
//配置 请用short name做配置的php文件名 比如config/elasticsearch.php config/container.php
$clsConfig = new Config(__DIR__ . DIRECTORY_SEPARATOR . 'config');

//通过组件声明 就是通过定义src/Component下的类来声明
#或在config下建立elasticsearch.php 内容是:return array('host'=>array('127.0.0.1:9200'));
#$clsConfig->set('elasticsearch', array('host'=>array('127.0.0.1:9200'))); //组件声明

//通过bind绑定 如你想把 class Test{} 绑定给test则：
#$clsConfig->set('container', array('bind'=>array('test'=>'Test')));
#或在config下建立container.php 内容是:return array('bind'=>array('test'=>'Test'));

$clsContainer = Container::getInstance();
$clsContainer->setConfig($clsConfig);

#使用elasticsearch
$clsElasticsearch = $clsContainer->get('elasticsearch'); #获取了DcrPHP\Data\Elasticsearch的实例
var_dump($clsElasticsearch);
#$clsElasticsearch = $clsElasticsearch ? $clsElasticsearch : new DcrPHP\Data\Elasticsearch(); #无意义的代码之小技巧：代码提示
#$clsEs = $clsElasticsearch->getClient();

#使用Test类
#var_dump($clsContainer->get('test'));