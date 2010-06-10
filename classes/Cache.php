<?php

class Cache {
    private static $Instance = null;

    public static $Engines = array('Cache_Null',
                                   'Cache_APC',
                                   'Cache_SHM',
                                   'Cache_Memcache',
                                   'Cache_Memcached'
                                  );

    public static function &get($key = null) {
        $data = &Cache::$Instance->get($key);
        if (!$data)
            return null;
        return $data;

    }

    public static function &getObject($key = null) {
        $obj = &Cache::$Instance->get($key);
        if (is_string($obj))
            return unserialize($obj);
        return $obj;
    }

    public static function set($key, $data, $lifeLength = 600) {
        return Cache::$Instance->set($key, $data, $lifeLength);
    }

    public static function setObject($key, &$object, $lifeLength = 600) {
        return Cache::$Instance->set($key, serialize($object), $lifeLength);
    }

    public static function initalize($engine) {
        if (!in_array($engine, self::$Engines))
            $engine = 'Cache_Null';
        if (is_null(Cache::$Instance))
            Cache::$Instance = new $engine();
    }

    public static function delete($key) {
        return Cache::$Instance->delete($key);
    }

    public static function clear() {
        return Cache::$Instance->clear();
    }
}

Cache::initalize($_SESSION['cache_engine']);
