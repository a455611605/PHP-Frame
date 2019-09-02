<?php
namespace core\lib;

class log
{
    /**
     * 1.确定日志存储方式
     * 2.写日志
     */
    protected static $class;
    /**
     * 初始化，确定存储方式
     *
     * @return void
     */
    public static function init()
    {
        $drive = conf::get('DRIVE', 'log');
        $class = '\core\lib\drive\log\\' . $drive;
        self::$class = new $class;
    }

    public function log($message, $file = 'log')
    {
        self::$class->log($message, $file);
    }
}
