<?php

class Cache_Null implements Cache_Engine {
    public function &get($key = null) {
        if (is_array($key)) {
            $ret = array();
            foreach ($key as $k => $v)
                $ret[$k] = &self::get($v);
            return $ret;
        }
        return null;
    }

    public function set($object, $data, $lifeLength) {
        return null;
    }

    public function delete($key) {
        return true;
    }

    public static function isEnabled() {
        return true;
    }

    public function clear() {
        return true;
    }
}
