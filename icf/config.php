<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/7
 * blog:blog.icodef.com
 * function:配置文件
 *============================
 */

return [
    'debug' => true,
    'db' => [
        'type' => 'mysql',
        'server' => 'localhost',
        'port' => 3306,
        'db' => 'tmp',
        'user' => 'root',
        'pwd' => '',
        'prefix' => 'test_'
    ],
    //开启restful
    'rest' => true,
    //模块,控制器,操作 默认关键字
    'module_key' => 'm',
    'ctrl_key' => 'c',
    'action_key' => 'a',
    'route' => ['*' => ['debug/{test}' => 'index->debug']],
    'tpl_suffix' => 'html',
    'log' => true,
    'url_style' => 1
];