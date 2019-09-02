<?php

namespace core\lib;

use think\Db;

class database
{
    public static function init()
    {
        $conf = conf::all('database');
        Db::setConfig($conf);
    }
}
