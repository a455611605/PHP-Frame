<?php
namespace lib\exception;

use core\lib\Exception;

class User extends Exception
{
    public $code = 404; // HTTP 状态码 404,200...
    public $msg = '要查询的用户不存在'; // 错误信息具体
    public $error_code = 10000; // 自定义错误码
}
