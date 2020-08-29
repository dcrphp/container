# DcrPHP/Container容器类

## 1、安装
　　composer install dcrphp/container

## 2、说明
　　容器类可以通过简单配置，获取某个组件的支持。Container只是做成了组件的开箱即用，而没有实现或提供任何组件功能。  

## 3、使用
　　cd example  
　　php index.php

## 4、添加组件流程标准 
　　第一步：组件的实现类，如果想用Config





























.

配置可以在__construct()加一个参数：DcrPHP\Config\Config，如：public function __construct(DcrPHP\Config\Config $clsConfig)  
　　第二步：组件打成composer包形式  
　　第三步：src/Component新建个类且参考Elasticsearch.php添加组件的相关说明  
　　第四步：如果实现类改动涉及到容器，请容器也修改