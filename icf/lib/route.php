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


class route
{
    static $model = '';//模块
    static $ctrl = '';//控制器
    static $action = '';//操作

    static $rule = ['*' =>
        [
            '{s}.php' => '${1}->index->index',
            '{s}/{s}/{s}' => '${1}->${2}->${3}',
            'debug/{test}' => 'index->debug',
            '{s}/{c}' => '${1}->${2}',
            '{s}' => '${1}->index'
        ],
        'get' => []];

    static $get_param = [];

    static $replace_param = '';

    static $classNamePace = '';

    static $get = [];

    static function matchRule($match, $pathInfo)
    {

        //处理各个参数
        $var = preg_replace_callback('#{(.*?)}#', function ($v) {
            static $count = 0;
            $count++;
            self::$get[$v[1]] = $count;
            return '([\S][^\{^\}]*)';
        }, $match[0]);
        preg_replace_callback('#\/' . $var . '#', function ($v) {
            foreach (self::$get as $key => $value) {
                if (isset($v[$value])) {
                    self::$get[$key] = $v[$value];
                } else {
                    unset(self::$get[$key]);
                }
            }
            return '';
        }, $pathInfo);
        $tmp = preg_replace('#\/' . $var . '#', $match[1], $pathInfo);
        $mca = explode('->', $tmp);
        if (sizeof($mca) == 1) {
            self::$model = _get(_config('model_key'), __DEFAULT_MODEL_);
            self::$ctrl = _get(_config('ctrl_key'), 'index');
            self::$action = _get(_config('action_key'), $mca[0]);
        } else if (sizeof($mca) == 2) {
            self::$model = _get(_config('model_key'), __DEFAULT_MODEL_);
            self::$ctrl = _get(_config('ctrl_key'), $mca[0]);
            self::$action = _get(_config('action_key'), $mca[1]);
        } else if (sizeof($mca) == 3) {
            self::$model = _get(_config('model_key'), $mca[0]);
            self::$ctrl = _get(_config('ctrl_key'), $mca[1]);
            self::$action = _get(_config('action_key'), $mca[2]);
        }
        self::$classNamePace = 'app\\' . self::$model . '\\ctrl\\' . self::$ctrl;
        if (!is_file(self::$classNamePace . '.php')) {
            return false;
        }
        return true;
    }

    /**
     * 解析URL,加载控制类
     * @access public
     * @author Farmer
     */
    static function analyze()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            $pathInfo = $_SERVER['PATH_INFO'];
            $tmpRule = self::$rule[strtolower($_SERVER['REQUEST_METHOD'])];
            foreach ($tmpRule as $key => $value) {
                //匹配规则
                if (self::matchRule($value, $pathInfo)) {
                    if (self::runAction()) {
                        return;
                    }

                }
            }
            $tmpRule = self::$rule['*'];
            foreach ($tmpRule as $key => $value) {
                //匹配规则
                if (self::matchRule([$key, $value], $pathInfo)) {
                    if (self::runAction()) {
                        return;
                    }
                }
            }
            _404();
            return;
        } else {
            self::$model = _get(_config('model_key'), __DEFAULT_MODEL_);
            self::$ctrl = _get(_config('ctrl_key'), 'index');
            self::$action = _get(_config('action_key'), 'index');
            self::$classNamePace = 'app\\' . self::$model . '\\ctrl\\' . self::$ctrl;
            if (!is_file(self::$classNamePace . '.php')) {
                _404();
                return false;
            }
            self::runAction();
            return;
        }
    }


    static function runAction()
    {
        try {
            $tmp = self::$classNamePace;
            $object = new $tmp();
            // 获取方法参数
            $method = new \ReflectionMethod ($object, self::$action);
            // 参数绑定
            $param = [];
            $_GET = array_merge($_GET, self::$get);
            foreach ($method->getParameters() as $value) {
                if ($val = _get($value->getName())) {
                    $param [] = $val;
                } else {
                    $param [] = $value->getDefaultValue();
                }
            }
            //加载全局函数
            $comPath = __ROOT_ . '/app/common.php';
            if (file_exists($comPath)) {
                require_once $comPath;
            }
            //加载模块函数
            $comPath = __ROOT_ . '/app/' . self::$model . '/';
            if (file_exists($comPath . 'common.php')) {
                require_once $comPath . 'common.php';
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
            return false;
        }
        return true;
    }

    /**
     * 添加规则
     * @access public
     * @author Farmer
     * @param $req_type
     * @param $rule
     * @param string $to
     */
    static function add($req_type, $rule, $to = '')
    {
        if (is_array($rule)) {
            foreach ($rule as $pattern => $value) {
                self::$rule [$req_type][$pattern] = $value;
            }
        } else {
            self::$rule [$req_type][$rule] = $to;
        }
    }
}