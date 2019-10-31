<?php
namespace core;

use core\lib\Route;

class base
{
    public static function run()
    {
        if (conf('APP_DEBUG', 'app')) {
            $whoops = new \Whoops\Run;
            $option = new \Whoops\Handler\PrettyPageHandler();
            $option->setPageTitle('框架出错了');
            $whoops->pushHandler($option);
            $whoops->register();
            ini_set('display_errors', 'On');
        } else {
            ini_set('display_errors', 'Off');
        }
        include EA . '/config/route.php';
        \core\lib\log::init();
        \core\lib\database::init();
        Route::run();
    }
}
