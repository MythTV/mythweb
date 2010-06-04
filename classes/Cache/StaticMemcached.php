<?php

class Cache_StaticMemcached implements Cache_Engine {

    private $Static   = null;
    private $Memcache = null;

    public function __construct() {
        $this->Static   = new Cache_Static();
        $this->Memcache = new Cache_Memcached();
    }

    public function &get($key = null) {
        $data = $this->Static->get($key);
        if (is_null($data))
            $data = $this->Memcache->get($key);
        return $data;
    }

    public function set($key, $data, $lifeLength) {
        return $this->Static->set($key, $data, $lifeLength) && $this->Memcache->set($key, $data, $lifeLength);
    }

    public static function isEnabled() {
        return Cache_Static::isEnabled() && Cache_Memcached::isEnabled();
    }
}
