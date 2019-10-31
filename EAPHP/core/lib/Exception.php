<?php
namespace core\lib;

use Exception as BaseException;

class Exception extends BaseException
{
    public $code = 400; // HTTP 状态码 404,200...
    public $msg = '参数错误'; // 错误信息具体
    public $error_code = 10000; // 自定义错误码

    public function __construct($params = [])
    {

        if (array_key_exists('code', $params)) {
            $this->code = $params['code'];
        }
        if (array_key_exists('msg', $params)) {
            $this->msg = $params['msg'];
        }
        if (array_key_exists('error_code', $params)) {
            $this->error_code = $params['error_code'];
        }
        $result = [
            'msg' => $this->msg,
            'error_code' => $this->error_code,
        ];
        json_return($result, $this->code);
        die;
    }
}
