<?php

namespace core\lib;

class conf
{
    public static $conf = array();

    /**
     * 加载该配置文件的一个配置项
     *
     * @param [type] $name 配置项
     * @param [type] $file 配置文件
     * @return 配置项
     */
    public static function get($name, $file)
    {
        /**
         * 1.判断文件是否存在
         * 2.判断配置项是否存在
         */
        $file = EA . '/config//' . $file . '.php';
        if (isset(self::$conf[$file])) {
            return self::$conf[$file][$name];
        }
        if (is_file($file)) {
            $conf = include $file;
            if (isset($conf[$name])) {
                self::$conf[$file] = $conf;
                return $conf[$name];
            } else {
                throw new \Exception($file . ' 没有这个配置项 ' . $name);
            }
        } else {
            throw new \Exception('找不到配置文件' . $file);
        }
    }

    /**
     * 加载该文件所有配置项
     *
     * @param [type] $file 配置文件
     * @return 配置文件

     */
    public static function all($file)
    {
        $file = EA . '/config//' . $file . '.php';
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        }
        if (is_file($file)) {
            $conf = include $file;
            self::$conf[$file] = $conf;
            return self::$conf[$file];
        } else {
            throw new \Exception('找不到配置文件' . $file);
        }
    }
}
