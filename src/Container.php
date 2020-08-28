<?php

declare(strict_types=1);


namespace DcrPHP\Container;


class Container
{
    /**
     * 展示组件的说明文档
     * @param string $shortName
     */
    public static function classList($shortName = '')
    {
        $helperDir = __DIR__ . DIRECTORY_SEPARATOR . 'Helper';
        $fileList = scandir($helperDir);
        $docList = array();
        foreach ($fileList as $fileName) {
            if (in_array($fileName, array('.', '..'))) {
                continue;
            }
            $pathInfo = pathinfo($fileName);
            $className = "DcrPHP\\Container\\Helper\\" . $pathInfo['filename'];
            $cls = new $className();
            if ($shortName) {
                if ($cls->getShortName() == $shortName) {
                    $docList[$cls->getShortName()] = $cls->getDoc();
                }
            } else {
                $docList[$cls->getShortName()] = $cls->getDoc();
            }
        }
        print_r($docList);
    }
}