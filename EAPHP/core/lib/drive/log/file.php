<?php
//文件驱动
namespace core\lib\drive\log;

use core\lib\conf;

class file
{
    protected $path; //日志存储路径
    public function __construct()
    {
        $this->path = conf::get('OPTION', 'log')['PATH'];
    }
    public function log($message,$fileName = 'log')
    {
        /**
         * 1.判断文件存储目录是否存在
         *      创建目录
         * 2.写入日志
         */
        if(!is_dir($this->path.date('Ymd'))){
            mkdir($this->path.date('Ymd'),'0777',true);
        }
        return file_put_contents($this->path.date('Ymd').'\\'.$fileName.'.php',date('Y-m-d H:i:s') .json_encode($message).PHP_EOL,FILE_APPEND);
    }
}
