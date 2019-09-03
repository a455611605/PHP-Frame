<?php

namespace app\ctrl;

use app\validate\user as userValidate;

class user
{
    public function get()
    {
        (new userValidate)->goCheck();
        //...todo
    }
}
