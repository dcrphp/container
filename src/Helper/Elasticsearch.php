<?php

declare(strict_types=1);


namespace DcrPHP\Container\Helper;


use DcrPHP\Container\Concerns\Helper;

class Elasticsearch extends Helper
{
    public function __construct()
    {
        parent::setShortName('elasticsearch');
        parent::setClassName('DcrPHP\\Data\\Elasticsearch');
        parent::setComposerList(array('dcrphp/data-elasticsearch'));
        parent::setConfig("config目录建立elasticsearch.php，内容:return array('host'=>array('127.0.0.1:9200'))");
        parent::setDoc('使用方式:
            $clsConfig = new Config(__DIR__ . DIRECTORY_SEPARATOR . \'config\');
            $clsContainer = new Container($clsConfig);
            $clsContainer->get("elasticsearch"); #elasticsearch的操作类(DcrPHP\\Data\\Elasticsearch)
        ');
    }
}