<?php
namespace app\validate;

class user extends Base
{

    protected $rule = [
        'username' => 'max:4',
        'password' => 'min:6',
    ];
    protected $message = [
        'username' => '用户名长度超过限制',
        'password' => '密码长度不能小于6',
    ];
}
