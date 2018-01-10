<?php
/**
 *============================
 * author:Farmer
 * time:2018/1/6
 * blog:blog.icodef.com
 * function:公共函数库
 *============================
 */

/**
 * Json 编码 对于中文处理 仅支持php5.4以后的版本
 *
 * @author Farmer
 * @param string $str
 * @return string
 */
function json($str) {
    return json_encode($str, JSON_UNESCAPED_UNICODE);
}


/**
 * 获取客户ip
 * @author Farmer
 * @return string
 */
function getip() {
    $arr_ip_header = array(
        'HTTP_CDN_SRC_IP',
        'HTTP_PROXY_CLIENT_IP',
        'HTTP_WL_PROXY_CLIENT_IP',
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR',
    );
    $client_ip = 'unknown';
    foreach ($arr_ip_header as $key) {
        if (!empty($_SERVER[$key]) && strtolower($_SERVER[$key]) != 'unknown') {
            $client_ip = $_SERVER[$key];
            break;
        }
    }
    return $client_ip;
}

/**
 * 获取请求地址
 * @author Farmer
 * @return string
 */
function getReqUrl() {
    return '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
}


/**
 * 生成访问URL
 * @author Farmer
 * @param string $action
 * @param string $param
 * @return string
 */
function url($model = '', $ctrl = '', $action = '', $param = [], $style = null) {
    if (is_null($style)) {
        $style = input('config.url_style');
    }
    //根据参数个数来交换mca和param
    $args = func_num_args();
    switch ($args) {
        case 1:
            {
                $action = $model;
                $model = input('model');
                $ctrl = input('ctrl');
                break;
            }
        case 2:
            {
                if (is_array($ctrl)) {
                    $action = $model;
                    $model = input('model');
                    $param = $ctrl;
                    $ctrl = input('ctrl');
                } else {
                    $action = $ctrl;
                    $ctrl = $model;
                    $model = input('model');
                }
                break;
            }
        case 3:
            {
                if (is_array($action)) {
                    $action = $ctrl;
                    $ctrl = $model;
                    $model = input('model');
                    $param = $action;
                }
                break;
            }
    }
    $url = __HOME_;
    $p_left = '';
    $p_mid = '';
    switch ($style) {
        case 0:
            {
                //model/ctrl/action/key1/value1/key2/value2
                $url .= "$model/$ctrl/$action";
                $p_left = '/';
                $p_mid = '/';
                break;
            }
        case 1:
            {
                //model.php?{$ctrl_key}=ctrl&{$action_key}=action&key1=value1
                $url .= '/' . $model . '.php?' . input('config.ctrl_key') . '=' . $ctrl .
                    '&' . input('config.action_key') . '=' . $action;
                $p_left = '&';
                $p_mid = '=';
                break;
            }
        case 2:
            {
                //{$model_key}=model&{$ctrl_key}=ctrl&{$action_key}=action&key1=value1
                $url .= '?' . input('config.model_key') . '=' . $model . '&' . input('config.ctrl_key') . '=' . $ctrl .
                    '&' . input('config.action_key') . '=' . $action;
                $p_left = '&';
                $p_mid = '=';
                break;
            }
        default:
            {
                $p_left = '&';
                $p_mid = '=';
                break;
            }
    }
    foreach ($param as $key => $value) {
        $url .= "{$p_left}{$key}{$p_mid}{$value}";
    }
    return $url;
}


function _404() {
    \icf\lib\other\HttpHelp::setStatusCode(404);
    echo '404';
}


/**
 * 更深层次的合并两个数组
 * @param array $array1
 * @param array $array2
 * @return array
 */
function array_merge_in($array1, $array2 = null) {
    $towArr = [];
    foreach ($array1 as $key => $value) {
        if (is_array($value) && isset($array2[$key])) {
            $towArr[$key] = array_merge_in($array1[$key], $array2[$key]);
        }
    }
    $tmpArr = array_merge($array1, $array2);
    if ($towArr != []) {
        $towArr = array_merge($tmpArr, $towArr);
    } else {
        $towArr = $tmpArr;
    }
    return $towArr;
}
