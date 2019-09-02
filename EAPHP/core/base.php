<?php
namespace core;

class base
{
    public static function run()
    {
        \core\lib\log::init();
        \core\lib\database::init();
        include EA . '/config/route.php';
    }
}
