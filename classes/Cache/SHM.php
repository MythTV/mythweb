<?php

class Cache_SHM implements Cache_Engine {
    private static $SHMhandle = null;
    private static $id = 'O';
    private static $key = null;
    private static $size = 16777216;
    private static $keyMap = array();

    public function __construct() {
        self::$key = ftok(__FILE__, self::$id);
        self::$SHMhandle = shm_attach(self::$key, self::$size);
        self::$keyMap = self::get('keyMap');
    }

    public function __destruct() {
        self::set('keyMap', self::$keyMap, 9999999);
        shm_detach(self::$SHMhandle);
    }

    public function &get($key = null) {
        if (is_array($key)) {
            $ret = array();
            foreach ($key as $k => $v)
                $ret[$k] = &self::get($v);
            return $ret;
        }
        $start = microtime(true);
        $data = shm_get_var(self::$SHMhandle, self::getVarKey($key));
        if (!is_null($data)) {
            if (time() <= $data['expire'])
                return $data['data'];
            else
                @shm_remove_var(self::$SHMhandle, self::getVarKey($key));
        }
        FB::warn("Cache Miss $key: ".(microtime(true) - $start));
        return null;
    }

    public function set($key, $data, $lifeLength) {
        return shm_put_var(self::$SHMhandle, self::getVarKey($key),
                           array('expire' => time()+$lifeLength,
                                 'data'   => $data));
    }

    public function delete($key) {
        return shm_remove_var(self::$SHMhandle, $key);
    }

    private static function getVarKey($key) {
        if (is_int($key))
            return $key;
        if (is_null(self::$keyMap))
            self::$keyMap = array('keyMap' => 1);
        if (!isset(self::$keyMap[$key]))
            self::$keyMap[$key] = count(self::$keyMap)+1;
        return self::$keyMap[$key];
    }

    public static function isEnabled() {
        return function_exists('shm_attach');
    }

    public function clear() {
        return shm_remove(self::$SHMhandle);
    }
}
