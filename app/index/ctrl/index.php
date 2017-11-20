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
        echo $test . "<br/>";
        $rec = db::table('tmp')->where('data', 'haha')->order('data', 'desc')->select();
        print_r($rec->fetchAll());
        echo "\r\n";
        $count = db::table('tmp')->where('data', 'haha')->update(['data' => 'haha', 'value' => rand(1000, 10000)]);
        echo "count:$count";
        $count = db::table('tmp')->where('data=:data')->bind(':data', '5723')->delete();
        echo "count:$count";
    }

    public function template() {
        $v = new view();
        $v->assign('test', ['ce' => 'emm', 'c3' => 'ha']);
        $v->display();
    }
}