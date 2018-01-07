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
function url($action = '', $param = '') {
    preg_match_all('/([\w]+)/', $action, $arrMatch);
    $url = '';
    foreach ($arrMatch[0] as $value) {
        $url .= ('/' . $value);
    }
    return __HOME_ . $url . ($param ? ('?' . $param) : '');
}


function _404() {
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
    }else{
        $towArr=$tmpArr;
    }
    return $towArr;
}
