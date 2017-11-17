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


use icf\lib\db;
use icf\lib\view;

class index {
    public function index() {
        echo 'test';
    }

    public function debug($test = 'hello') {
        echo $test;
        $db=new db();

    }

    public function template(){
        $v=new view();
        $v->assign('test',['ce'=>'emm','c3'=>'ha']);
        $v->display();
    }
}