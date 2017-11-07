<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/7
 * blog:blog.icodef.com
 * function:路由类
 *============================
 */

namespace lib;


class route {
    static $model = '';//模块
    static $ctrl = '';//控制器
    static $action = '';//操作

    static $rule = [
        '{s}.php' => '${1}->index->index',
        '{s}/{s}' => '${1}->${2}',
        '{s}' => '${1}->index'
    ];

    /**
     * 解析URL,加载控制类
     */
    static function analyze() {
        if (isset($_SERVER['PATH_INFO'])) {

        } else {
            self::$model = _get(_config('model_key'), 'index');
            self::$ctrl = _get(_config('ctrl_key'), 'index');
            self::$action = _get(_config('action_key'), 'index');
        }
        self::runAction();
    }


    static function runAction() {
        $classNamePace = 'app\\' . self::$model . '\\ctrl\\' . self::$ctrl;
        try {
            if (!is_file($classNamePace . '.php')) {
                throw new \Exception('not found class:' . $classNamePace);
            }
            $object = new $classNamePace();
            // 获取方法参数
            $method = new \ReflectionMethod ($object, self::$action);
            // 参数绑定
            $param = [];
            foreach ($method->getParameters() as $value) {
                if (_get($value->getName()) !== false) {
                    $param [] = _get($value->getName());
                } else {
                    $param [] = $value->getDefaultValue();
                }
            }
            $data = call_user_func_array([
                $object,
                self::$action
            ], $param);
            if (is_array($data)) {
                echo json($data);
            } else {
                echo $data;
            }
        } catch (\Exception $e) {
            _404();
            exit();
        }

    }

    /**
     * 添加一条或多条路由规则
     * @access public
     * @author Farmer
     * @param mixed $rule
     * @param string $to
     * @return null
     */
    static function add($rule, $to = 0) {
        if (is_array($rule)) {
            foreach ($rule as $pattern => $value) {
                self::$rule [$pattern] = $value;
            }
        } else {
            self::$rule [$rule] = $to;
        }
    }

}