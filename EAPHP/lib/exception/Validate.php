<?php
namespace lib\exception;

use core\lib\Exception;

class Validate extends Exception
{
    public $code = 404; // HTTP 状态码 404,200...
    public $msg = '验证参数有误'; // 错误信息具体
    public $error_code = 10000; // 自定义错误码

    public function __construct($msg)
    {
        parent::__construct(['msg' => $msg]);
    }
}
