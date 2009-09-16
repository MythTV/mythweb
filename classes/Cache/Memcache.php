<?php

class Cache_Memcache implements Cache_Engine {

    private $Memcache = null;

    public function __construct() {
        $this->Memcache = new Memcache;
        $this->Memcache->addServer('localhost', 11211);
    }

    public function __destruct() {
        $this->Memcache->close();
    }

    public function &get($key = null) {
        return $this->Memcache->get($key);
    }

    public function set($key, $data, $lifeLength) {
        return $this->Memcache->set($key, $data, null, $lifeLength);
    }

    public static function isEnabled() {
        return class_exists('Memcache');
    }
}
