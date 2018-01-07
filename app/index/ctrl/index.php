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
use icf\lib\info\AliSms;
use icf\lib\other\ImageVerifyCode;
use icf\lib\view;

class index {
    public function index() {

    }

    public function vcode() {
        $v = new ImageVerifyCode();
        $v->display();
    }

    public function sms($phone = '') {
        $sms = new AliSms('LTAINi8D1CVqk6Wv', 'MniMfZHFMI4axWOvU3VzrKsii9c3F7');
        return $sms->sendSms('爱编码的Farmer', 'SMS_119087721', ['code' => 'test' . rand(10, 99)], $phone);
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

    //rest test
    public function getUsers() {
        echo 'get method';
    }

    public function deleteUsers($uid=0) {
        echo 'delete method uid:' . $uid;
    }

    public function users() {
        echo 'does not exist';
    }
}