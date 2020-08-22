# DcrPHP/Container容器类

## 1、安装
　　composer install dcrphp/container

## 2、说明
　　容器类可以通过简单配置，就启动某个组件的支持  

## 3、使用
```
　　$clsConfig = new DcrPHP\Config\Config();
　　$clsConfig->set('container', array('component'=>array('config'=>'DcrPHP\Config\Config','log'=>'DcrPHP\Log\Log')));
　　$clsContainer = new Container();
　　//取组件:
　　$clsLog = $clsContainer->get('log'); //$clsContainer->get('DcrPHP\Log\Log');
```    

## 4、扩展
　　请在src/Driver/目录下以Php.php为例加类，比如想加实别ini，添加Ini.php,调用时setDriver('ini')即可

## 5、说明
　　配置读取的以文件名为item名，比如app.php里的配置会读取成:  
```
　　$config['app']['default_timezone'] = 'PRC';
　　$config['app']['debug'] = 1;
``` 
