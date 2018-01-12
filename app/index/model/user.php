<?php
/**
 *============================
 * author:Farmer
 * time:2018/1/11
 * blog:blog.icodef.com
 * function:
 *============================
 */


namespace app\index\model;


use icf\lib\db;

class user {
    private $user = [];

    public function __construct($uid) {
        //从数据库中读取数据
        $this->user = db::table('user')->where('uid', $uid)->find();
    }

    public function getUserMsg() {
        return "uid:{$this->user['uid']} username:{$this->user['username']}";
    }
}