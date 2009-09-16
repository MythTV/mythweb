<?php

class Cache {
    private static $Instance = null;

    public static $Engines = array('Null',
                                   'SHM',
                                   'Static',
                                   'Memcache',
                                   'StaticMemcache'
                                  );

    public static function &get($key = null) {
        return Cache::$Instance->get($key);
    }

    public static function &getObject($key = null) {
        return unserialize(Cache::$Instance->get($key));
    }

    public static function set($key, $data, $lifeLength = 84000) {
        return Cache::$Instance->set($key, $data, $lifeLength);
    }

    public static function setObject($object, $lifeLength = 84000) {
        return Cache::$Instance->set($object->getKey(), serialize($object), $lifeLength);
    }

    public static function initalize($engine = 'Cache_Static') {
        if (is_null(Cache::$Instance))
            Cache::$Instance = new $engine();
    }
}

Cache::initalize($_SESSION['cache_engine']);
