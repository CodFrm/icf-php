<?php
/**
 *============================
 * author:Farmer
 * time:2018/2/24
 * function:
 *============================
 */

namespace icf\lib;


class model {
    protected $data;
    private $table;

    public function __construct($table, $where) {
        $this->data = db::table($table)->where($where)->find();
        $this->table = $table;
    }
    
    public function __get($name) {
        // TODO: Implement __get() method.
        if (substr($name, 0, 1) == '_') {
            $tmpKey = substr($name, 1);
            if (isset($this->data[$this->table . $name])) {
                return $this->data[$this->table . $name];
            } else if (isset($this->data[$tmpKey])) {
                return $this->data[$tmpKey];
            } else {
                throw new \Exception('not find ' . $name);
            }
        }
    }

    public function getData() {
        return $this->data;
    }
}