<?php

namespace core\lib;

class Route
{

    // 路由规则
    private static $rules = [
        'get' => ['/$' => 'index/index'],
        'post' => [],
        'put' => [],
        'delete' => [],
        '*' => ['/$' => 'index/index'],
    ];
    /**
     * 绑定路由
     * @param  string $rule  路由规则
     * @param  string $route 路由地址
     * @param  string $type  请求类型
     */
    public static function rule($rule, $route = '', $type = '*')
    {
        $rule = strtolower($rule);
        //判断规则前是否有'/'，若有，取本身，若无，则在前加上'/'
        $rule = '/' == substr($rule, 0, 1) ? $rule : '/' . $rule;
        $route = strtolower($route);
        $type = strtolower($type);
        if ($type == '*') { //所有请求类型
            foreach (self::$rules as $key => $value) {
                self::$rules[$key][$rule] = $route;
            }
        } else {
            self::$rules[$type][$rule] = $route;
            self::$rules['*'][$rule] = $route;
        }
    }
    /**
     * 调用类的静态方法不存在时，执行该方法
     * 提供快捷绑定
     * 如 Route::get() Route::post()
     * 仅为概念简写，实际应用请按需修改及验证
     */
    public static function __callStatic($func, $arguments)
    {
        $arguments[] = $func;
        if ($arguments[0] == '/') {
            $arguments[0] = $arguments[0] . '$';
        }
        self::rule(...$arguments);
    }
    /**
     * 解析当前请求URL
     * @return array    路由信息数组
     */
    public static function parseUrl()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $analysis['status'] = 404;
        $analysis['type'] = $method;
        $analysis['param'] = [];
        if (isset(self::$rules[$method][$uri])) { //匹配成功，并且没参数
            $analysis['status'] = 200;
            $analysis['rule'] = $uri;
            $analysis['route'] = self::$rules[$method][$uri];
        } else { //有参数或者匹配失败
            // 列表匹配
            foreach (self::$rules[$method] as $rule => $route) { //循环所有路由，直到匹配成功
                if (substr($rule, -1) == '$' && substr_count($rule, '/') != substr_count($uri, '/')) {
                    //完全匹配路由
                    continue;
                }
                $reg = '/^' . str_replace('/', '\/', preg_replace('/:[a-z]+(?=\/|\$|$)/', '\S+', $rule)) . '/';
                if (!preg_match($reg, $uri)) {
                    continue;
                }
                $analysis['status'] = 200;
                $analysis['rule'] = $rule;
                $analysis['route'] = $route;
                $analysis['param'] = self::Params($analysis, $uri);
                break;
            }
        }
        return $analysis;
    }
    /**
     * 处理请求参数
     * @param  array $param    PATH_INFO参数
     * @return array
     */
    public static function Params($analysis, $uri)
    {
        if (isset($analysis['route'])) {
            $param = [];
            $rule_list = explode('/', trim($analysis['rule'], '/'));
            $path_list = explode('/', trim($uri, '/'));
            if (strpos($analysis['rule'], ':') !== false) {
                foreach ($rule_list as $key => $value) {
                    if (substr($value, 0, 1) == ':') {
                        $param[trim($value, ':$')] = $path_list[$key];
                    }
                }
            }
            // 获取剩余参数
            for ($i = count($rule_list); $i < count($path_list); $i += 2) {
                if (isset($path_list[$i + 1])) {
                    $param[$path_list[$i]] = $path_list[$i + 1];
                }
            }
            return array_merge($param, $_GET, $_POST);
        }
    }

    public static function run()
    {
        $analysis = self::parseUrl();
        if ($analysis['status'] === 404) {
            throw new \Exception('未定义路由' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        }
        $parts = explode('/', trim($analysis['route'], '/'));
        $ctrl = $parts[0];
        $action = $parts[1];
        $ctrl_file = APP . '/ctrl/' . $ctrl . '.php';
        $ctrl_class = '\\app\\ctrl\\' . $ctrl;

        if (is_file($ctrl_file)) {
            $ctrl_obj = new $ctrl_class;
            if (method_exists($ctrl_obj, $action)) {
                if ($analysis['type'] == 'get' || $analysis['type'] == '*') {
                    $_GET = array_merge($analysis['param'], $_GET);
                }
                $argList = [];
                foreach ($analysis['param'] as $value) {
                    $argList[] = $value;
                }
                $ctrl_obj->$action(...$argList);
            } else {
                throw new \Exception('找不到' . $action . '函数');
            }
        } else {
            throw new \Exception('找不到控制器' . $ctrl_file);
        }
    }
}
