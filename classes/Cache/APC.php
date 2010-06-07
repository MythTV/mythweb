<?php

class Cache_APC implements Cache_Engine {

    public function __construct() {
    }

    public function __destruct() {
    }

    public function &get($key = null) {
        if (is_array($key)) {
            $ret = array();
            foreach ($key as $k => $v)
                $ret[$k] = &self::get($v);
            return $ret;
        }

        return apc_fetch($key);
    }

    public function set($key, $data, $lifeLength) {
        return apc_store($key, $data, $lifeLength);
    }

    public static function isEnabled() {
        if (!function_exists('apc_fetch'))
            return false;
        return true;
    }

    public function clear() {
        apc_clear_cache('user');
        apc_clear_cache();
        return;
    }
}
