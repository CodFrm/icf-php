<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/7
 * blog:blog.icodef.com
 * function:框架的内置函数
 *============================
 */

//全局函数
global $g;

/**
 * 全局数据
 * @param $key
 * @param $value
 * @return bool
 */
function _global($key, $value = null) {
    global $g;
    if (isset($g[$key])) {
        if ($value === null) {
            return $g[$key];
        } else {
            $g[$key] = $value;
            return $value;
        }
    } else {
        $g[$key] = $value;
    }
    return true;
}

/**
 * 读取配置
 * @param $key
 * @return mixed
 */
function _config($key) {
    return _global('config')[$key];
}

/**
 * 读取get
 * @author Farmer
 * @param $key
 * @param null $default
 * @return null
 */
function _get($key, $default = false) {
    return _readValue($_GET, $key, $default);
}

function _readValue($data, $key, $default = false) {
    if (isset($data[$key])) {
        return $data[$key];
    }
    return $default;
}

/**
 * Json 编码 对于中文处理 仅支持php5.4以后的版本
 *
 * @author Farmer
 * @param string $str
 * @return string
 */
function json($str) {
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($str, JSON_UNESCAPED_UNICODE);
}


function _404() {
    echo '404';
}

/**
 * 获取变量
 *
 * @author Farmer
 * @param string $var
 * @return mixed
 */
function input($var,$val=null) {
    $arrVar = explode('.', $var);
    if (sizeof($arrVar) <= 1) {
        $ret = _global($var,$val);
    } else {
        $ret = _global($arrVar [0],$val);
        unset ($arrVar [0]);
        foreach ($arrVar as $value) {
            if (!isset ($ret [$value])) {
                return false;
            }
            $ret = $ret [$value];
        }
    }
    return $ret;
}

function view(){
    return new \icf\lib\view();
}

