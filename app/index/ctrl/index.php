<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/7 19:22
 * blog:blog.icodef.com
 * function:首页
 *============================
 */

namespace app\index\ctrl;


class index {
    public function index() {
        echo 'test';
    }

    public function debug($test = 'hello') {
        echo $test;
    }
}