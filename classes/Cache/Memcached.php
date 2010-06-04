<?php

class Cache_Memcached implements Cache_Engine {

    private $Memcache = null;

    public function __construct() {
        $this->Memcache = new Memcached;
        $this->Memcache->addServer('localhost', 11211);
    }

    public function __destruct() {
    }

    public function &get($key = null) {
        return $this->Memcache->get($key);
    }

    public function set($key, $data, $lifeLength) {
        return $this->Memcache->set($key, $data, $lifeLength);
    }

    public static function isEnabled() {
        if (!class_exists('Memcached'))
            return false;
        return true;
    }
}
