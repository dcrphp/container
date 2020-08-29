# DcrPHP/Container容器类

## 1、安装
　　composer install dcrphp/container

## 2、说明
　　容器类可以通过简单配置，获取某个组件的支持。Container只是做成了组件的开箱即用，而没有提供任何组件功能。  

## 3、使用
　　cd example  
　　php index.php

## 4、添加组件流程
　　src/Component添加组件的使用说明，参考Elasticsearch.php的类配置说明
　　实现的组件类__construct()里要用DcrPHP\Config\Config初始化:public function __construct(DcrPHP\Config\Config $clsConfig)