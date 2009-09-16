<?php

class Cache_SHM implements Cache_Engine {
    private static $SHMhandle = null;

    public function __construct() {
        self::$SHMhandle = shm_attach(ftok(__FILE__, 'mythweb'), 67108864);
    }

    public function __destruct() {
        shm_detach(self::$SHMhandle);
    }

    public function &get($key = null) {
        $key = ftok(__FILE__, $key);
        return shm_get_var(self::$SHMhandle,$key);
    }

    public function set($key, $data, $lifeLength) {
        $key = ftok(__FILE__, $key);
        return shm_put_var(self::$SHMhandle, $key, $data);
    }

    public static function isEnabled() {
        return function_exists('shm_attach');
    }
}
