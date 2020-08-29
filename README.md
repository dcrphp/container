# DcrPHP/Container容器类

## 1、安装
　　composer install dcrphp/container

## 2、说明
　　容器类可以通过简单配置，获取某个组件的支持。Container只是做成了组件的开箱即用，而没有提供任何组件功能。  

## 3、使用
　　cd example  
　　php index.php

## 4、添加组件流程标准
　　第一步：src/Component添加组件的说明。可参考Elasticsearch.php  
　　第二步：组件的实现类只有一个要求：__construct()有且只能有一个参数：DcrPHP\Config\Config，如：public function __construct(DcrPHP\Config\Config $clsConfig)  
　　第三步：组件打成composer包形式