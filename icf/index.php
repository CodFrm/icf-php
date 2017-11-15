<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/7
 * blog:blog.icodef.com
 * function:框架入口
 *============================
 */

namespace icf;

use lib\route;

require_once 'functions.php';

class index
{
    /**
     * 运行框架
     */
    public static function run()
    {
        //加载配置
        $config = include 'config.php';
        _global('config', $config);
        //调试模式
        if (_config('debug')) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        } else {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            ini_set('display_errors', '0');
        }
        //路由加载
        route::analyze();
    }
}