<?php

namespace app\ctrl;

use app\model\user as userModel;

class user
{
    public function get()
    {
        dd(userModel::all());
    }
}
