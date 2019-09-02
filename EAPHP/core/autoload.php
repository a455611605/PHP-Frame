<?php
namespace core;

use Exception;

class autoload
{
    public static $classMap = array();
    public static function load($class)
    {
        if (isset($classMap)) { //判断是否引入，若引入，无需再次引入，直接返回true
            return true;
        }
        $class = str_replace('\\', '/', $class);
        $file = EA . '/' . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            self::$classMap[$class] = $class; //引入类后，将类名放置classMap中
            return true;
        } else {
            throw new Exception('无法加载文件' . $class . '.php');
            return false;
        }
    }
}
