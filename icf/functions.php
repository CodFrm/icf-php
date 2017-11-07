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
function _global($key, $value = 0)
{
    global $g;
    if (isset($g[$key])) {
        if ($value === 0) {
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
function _config($key)
{
    return _global('config')[$key];
}

