<?php
/**
 *============================
 * author:Farmer
 * time:2018/1/22
 * blog:blog.icodef.com
 * function:数据验证器
 *============================
 */

namespace icf\lib\other;


class check {
    private $checkData = [];//验证的数据
    private $checkRule = [];//验证的规则
    private $bindVar = [];//绑定变量

    //默认规则

    public function rule($key, $rule = null) {
        if (is_null($rule)) {
            $this->checkRule = array_merge($this->checkRule, $key);
        } else {
            $this->checkRule[$key] = $rule;
        }
        return $this;
    }

    public function addData($key, $value = null) {
        if (is_null($value)) {
            $this->checkData = array_merge($this->checkData, $key);
        } else {
            $this->checkData[$key] = $value;
        }
        return $this;
    }

    public function check() {
        foreach ($this->checkRule as $key => $value) {
            if (($ret = $this->dealRule($key, $value)) !== true) {
                return $ret;
            }
        }
        return true;
    }

    public function isNull($key) {
        return (!isset($this->checkData[$key]) || empty($this->checkData[$key]));
    }

    private function dealRule($key, $rule) {
        $pos = strpos($key, ':');
        if ($pos !== false) {
            $name = substr($key, $pos ? $pos + 1 : 0);
            $key = substr($key, 0, $pos);
        } else {
            $name = $key;
        }
        if ($this->isNull($key)) {
            if (isset($rule['null']) && $rule['null']) {
                return true;
            } else {
                return $name . '不能为空';
            }
        }
        if (isset($rule['func'])) {
            $parameter = array();
            $parameter[] = $this->checkData[$key];
            if (is_array($rule['func'])) {
                $paramName = $rule['func'];
                $funName = $rule['func'][0];
                unset($paramName[0]);
                foreach ($paramName as $v) {
                    $parameter[] = $this->checkData[$v];
                }
            } else {
                $funName = $rule['func'];
            }
            $tmpValue = call_user_func_array($funName, $parameter);
            if ($tmpValue !== true) {
                return $tmpValue;
            }
        }
        if (isset($rule['regex'])) {
            if (is_array($rule['regex'])) {
                $reg = $rule['regex'][0];
                $msg = $rule['regex'][1];
            } else {
                $reg = $rule['regex'];
                $msg = ($name . '不符合规则');
            }
            if (!preg_match($reg, $this->checkData[$key])) {
                return $msg;
            }
        }
        if (isset($rule['range'])) {
            $min = 0;
            if (is_array($rule['range'])) {
                $min = $rule['range'][0];
                $max = $rule['range'][1];
            } else {
                $max = $rule['range'];
            }
            if (is_numeric($this->checkData[$key])) {
                $len = $this->checkData[$key];
            } else if (is_string($this->checkData[$key])) {
                $len = mb_strlen($this->checkData[$key]);
            }
            if ($len < $min) {
                return "{$name}长度过小,要求在($min-$max)之内";
            } else if ($len > $max) {
                return "{$name}长度过长,要求在($min-$max)之内";
            }
        }
        if (isset($rule['bind'])) {
            $this->bindVar[empty($rule['bind']) ? $key : $rule['bind']] = htmlspecialchars($this->checkData[$key], ENT_QUOTES, 'UTF-8');
        }
        return true;
    }

    public function getBindVar() {

        return $this->bindVar;
    }
}