<?php

class Cache_Static implements Cache_Engine {

    private static $Cache = array();

    public function &get($key = null) {
        if (isset(self::$Cache[$key]) && self::$Cache[$key]['expires'] < time())
            return self::$Cache[$key];
        return null;
    }

    public function set($key, $data, $lifeLength) {
        self::$Cache[$key] = array('data'    => $data,
                                   'expires' => time() + $lifeLength);
        return true;
    }

    public static function isEnabled() {
        return true;
    }
}
