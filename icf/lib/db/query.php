<?php
/**
 *============================
 * author:Farmer
 * time:2017/11/20
 * blog:blog.icodef.com
 * function:数据库查询
 *============================
 */

namespace icf\lib\db;

use PDO;

class query {
    private static $db = null;
    private static $db_type = '';

    public function __construct($table) {
        if (self::$db == null) {
            $db_type = input('config.db.type');
            $dns = call_user_func('icf\\lib\\db\\' . $db_type . '::dns');
            self::$db = new PDO($dns, input('config.db.user'), input('config.db.pwd'));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        $this->table = $table;
    }

    private $table;

    public function where($field, $value = '', $operator = '') {
        if (is_array($field)) {
            $this->where = '';
        } else if (is_string($field)) {

        }
    }

    public function select() {

    }
}