<?php

namespace core\lib;

class Validate
{
    //参数验证规则
    protected $rule = [];
    //参数验证失败信息
    protected $message = [];
    //验证失败返回的错误信息
    public $error = [];

    public function check($input, $rule = [], $message = [])
    {
        if (empty($rule)) {
            // 读取验证规则
            $rule = $this->rule;
        }
        if (empty($message)) {
            // 读取错误信息
            $message = $this->message;
        }
        foreach ($rule as $field => $rules) {
            if (!isset($input[$field])) {
                continue;
            }
            $ruleList = explode('|', $rules);
            foreach ($ruleList as $rule) {
                $param = null;
                if (strstr($rule, ':') !== false) {
                    $pramas = explode(':', $rule);
                    $rule = $pramas[0];
                    $param = $pramas[1];
                }
                $method = $rule;
                if (!$this->$method($input[$field], $param)) {
                    $this->error = $message[$field];
                    return false;
                }
            }
        }
        return true;
    }

    public function required($field)
    {
        if (isset($field) && ($field === false || $field === 0 || $field === 0.0 || $field === '0' || !empty($field))) {
            return true;
        } else {
            return false;
        }
    }

    public function tel($field)
    {
        if (preg_match("/^1[345678]{1}\d{9}$/", $field)) {
            return true;
        } else {
            return false;
        }
    }

    public function email($field)
    {
        if (preg_match("/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/", $field)) {
            return true;
        } else {
            return false;
        }
    }

    public function max($field, $param = null)
    {
        if (function_exists('mb_strlen')) {
            if (mb_strlen($field) <= (int) $param) {
                return true;
            } else {
                return false;
            }
        } else {
            if (strlen($field) <= (int) $param) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function min($field, $param = null)
    {
        if (function_exists('mb_strlen')) {
            if (mb_strlen($field) >= (int) $param) {
                return true;
            } else {
                return false;
            }
        } else {
            if (strlen($field) >= (int) $param) {
                return true;
            } else {
                return false;
            }
        }
    }

}
