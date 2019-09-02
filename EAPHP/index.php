<?php

/**
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */
define('EA', $_SERVER['DOCUMENT_ROOT']); //框架所在目录
define('CORE', EA . '/core'); //核心文件所属目录
define('APP', EA . '/app'); //项目核心目录（控制器、模型、视图）
define('DEBUG', true); //开启调试模式
include 'vendor/autoload.php';

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $option = new \Whoops\Handler\PrettyPageHandler();
    $option->setPageTitle('框架出错了');
    $whoops->pushHandler($option);
    $whoops->register();
    ini_set('display_errors', 'On');
} else {
    ini_set('display_errors', 'Off');
}
include CORE . '/base.php'; //引入核心文件
include CORE . '/autoload.php'; //引入自动加载类库文件
include CORE . '/common/function.php';
spl_autoload_register('\core\autoload::load');
\core\base::run();
