<?php

namespace app\ctrl;

use app\validate\user as UserValidate;

class user
{

    public function get()
    {
        (new UserValidate())->goCheck();
    }

    /**
     * test
     */
    public function test()
    {
        //获取类名
        $className = get_class($this);
        //构造一个对象
        $class = new \ReflectionClass($className);
        $ref = new \ReflectionMethod($className, 'test');

        // 获取文档
        $note = $ref->getDocComment();
        $funcs = preg_match('/\s(\w+)/u', $note, $values);
        dd($funcs);
    }

}
