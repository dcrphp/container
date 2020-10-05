<?php

declare(strict_types=1);

namespace DcrPHP\Container\Component;

use DcrPHP\Container\Concerns\Component;

class Elasticsearch extends Component
{
    public function __construct()
    {
        #shortname应该为类名的小写，方便container找类
        parent::setShortName('elasticsearch');
        #实现类，就是最终被实例化的类
        parent::setClassName('DcrPHP\\Data\\Elasticsearch');
        #要安装这个包 要添加的composer包列表
        parent::setComposerList(array('dcrphp/data-elasticsearch'));
        #如何配置
        parent::setConfig("config目录建立elasticsearch.php，内容:return array('host'=>array('127.0.0.1:9200'))");
        #使用方式
        parent::setExample('
            $clsConfig = new Config(__DIR__ . DIRECTORY_SEPARATOR . \'config\');
            #$clsConfig = new Config();
            #$clsConfig->set(\'elasticsearch\', array(\'host\' => array(\'127.0.0.1:9200\')));
            $clsContainer = new Container($clsConfig);
            $clsElasticsearch = $clsContainer->get("elasticsearch"); #elasticsearch的操作类(DcrPHP\\Data\\Elasticsearch)      
            $clsEs = $clsElasticsearch->getClient(); #elasticsearch的操作类(elasticsearch\elasticsearch):https://packagist.org/packages/elasticsearch/elasticsearch
        ');
    }
}
