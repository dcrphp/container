<?php

use DcrPHP\Config\Config;
use DcrPHP\Container\Container;

require_once("../vendor/autoload.php");

ini_set('display_errors', 'on');

//获取支持的类
Container::classList();

//某类的文档说明
Container::classList('elasticsearch');

//使用类
//配置 请用short name做php文件名 比如config/elasticsearch.php 内容是:return array('host'=>array('127.0.0.1:9200'))
$clsConfig = new Config(__DIR__ . DIRECTORY_SEPARATOR . 'config');
# $clsConfig->set('elasticsearch', array('host'=>array('127.0.0.1:9200')));
$clsContainer = Container::getInstance();
$clsContainer->setConfig($clsConfig);

//获取es的组件
$clsEs = $clsContainer->get('elasticsearch');