<?php

namespace app\validate;

use core\lib\Validate;

class Base extends Validate
{
    public function goCheck()
    {
        if (!$this->check(input())) {
            throw new \Exception($this->error);
        }
    }
}
