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
        if (is_array($key)) {
            $ret = array();
            foreach ($key as $k => $v)
                $ret[$k] = &self::get($v);
            return $ret;
        }
        return $this->Memcache->get($key);
    }

    public function set($key, $data, $lifeLength) {
        return $this->Memcache->set($key, $data, null, $lifeLength);
    }

    public function delete($key) {
        return $this->Memcache->delete($key);
    }

    public static function isEnabled() {
        if (!class_exists('Memcache'))
            return false;
        return true;
    }

    public function clear() {
        return $this->Memcache->flush();
    }
}
