<?php
/**
 *============================
 * author:Farmer
 * time:2018/3/18
 * function:字符串操作函数库
 *============================
 */


/**
 * 取随机字符串
 * @author Farmer
 * @param $length
 * @param $type
 * @return string
 */
function getRandString($length, $type = 2) {
    $randString = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $retStr = '';
    $type = 9 + $type * 26;
    for ($n = 0; $n < $length; $n++) {
        $retStr .= substr($randString, mt_rand(0, $type), 1);
    }
    return $retStr;
}

/**
 * 取中间文本
 * @author Farmer
 * @param $str
 * @param $left
 * @param $right
 * @return bool|string
 */
function getStrMid($str, $left, $right) {
    $lpos = strpos($str, $left);
    if ($lpos === false) {
        return false;
    }
    $rpos = strpos($str, $right, $lpos + strlen($left));
    return substr($str, $lpos + strlen($left), $rpos - $lpos - strlen($left));
}
