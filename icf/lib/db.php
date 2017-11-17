<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/17
 * blog:blog.icodef.com
 * function:
 *============================
 */

namespace icf\lib;

use PDO;
class db {
    private static $db=null;
    public function __construct() {
        if (self::$db==null){
            $dns = input('config.db.type') . ':dbname=' . input('config.db.db') . ';host=';
            $dns .= input('config.db.server') . ';charset=utf8';
            self::$db=new PDO($dns, input('config.db.user'), input('config.db.pwd'));
            db::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            db::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
    }

    private $where='';

    public function where($field,$value='',$operator=''){
        if (is_array($field)){
            $this->where='';
        }else if (is_string($field)){

        }
    }
}