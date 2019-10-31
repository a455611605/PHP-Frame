<?php
//这里可以写助手函数

use core\lib\conf;

function input()
{
    return array_merge($_GET, $_POST);
}

function json_return(array $data, $code)
{
    http_response_code($code);
    header('Content-Type:application/json');
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    echo $json;
}

function conf($name, $file)
{
    return conf::get($name, $file);
}
