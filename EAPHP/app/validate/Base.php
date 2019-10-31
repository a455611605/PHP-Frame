<?php

namespace app\validate;

use core\lib\Validate;
use lib\exception\Validate as ValidateException;

class Base extends Validate
{
    public function goCheck()
    {
        if (!$this->check(input())) {
            throw new ValidateException($this->error);
        }
    }
}
