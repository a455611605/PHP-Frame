<?php
namespace core;

use core\lib\Route;

class base
{
    public static function run()
    {
        include EA . '/config/route.php';
        \core\lib\log::init();
        \core\lib\database::init();
        Route::run();
    }
}
