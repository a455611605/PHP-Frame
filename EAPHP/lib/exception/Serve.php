<?php
namespace lib\exception;

use core\lib\Exception;

class Serve extends Exception
{
    public $code = 500; // HTTP 状态码 404,200...
    public $msg = '服务器内部错误'; // 错误信息具体
    public $error_code = 10000; // 自定义错误码
}
