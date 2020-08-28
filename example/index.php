<?php

use DcrPHP\Config\Config;
use DcrPHP\Container\Container;

require_once("../vendor/autoload.php");

ini_set('display_errors', 'on');

//获取支持的类
Container::classList();

//某类的安装方法
Container::classList('elasticsearch');

//使用类
$clsConfig = new Config(__DIR__ . DIRECTORY_SEPARATOR . 'config');
# $clsConfig->set('session', array('session_save_path' => 'tmp'));
$clsContainer = new Container($clsConfig);
$clsSession = $clsContainer->get('session');
$clsSession->set('name', 'Jim');
echo $clsSession->get('name');