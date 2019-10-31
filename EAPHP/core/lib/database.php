<?php

namespace core\lib;

use think\Db;

class database
{
    public static function init()
    {
        Db::setConfig(conf::all('database'));
    }
}
