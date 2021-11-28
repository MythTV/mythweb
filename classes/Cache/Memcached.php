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
        if (is_array($key)) {
            $tmp = $this->Memcache->getMulti($key);
            return $tmp;
        }
        $tmp = $this->Memcache->get($key);
        return $tmp;
    }

    public function set($key, $data, $lifeLength) {
        return $this->Memcache->set($key, $data, $lifeLength);
    }

    public function delete($key) {
        return $this->Memcache->delete($key);
    }

    public static function isEnabled() {
        if (!class_exists('Memcached'))
            return false;
        return true;
    }

    public function clear() {
        return $this->Memcache->flush();
    }
}
