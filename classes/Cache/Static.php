<?php

class Cache_Static implements Cache_Engine {

    private $Cache = array();

    public function &get($key = null) {
        if (isset($this->Cache[$key]) && $this->Cache[$key]['expires'] < time())
            return $this->Cache[$key];
        return null;
    }

    public function set($key, $data, $lifeLength) {
        $this->Cache[$key] = array('data'    => $data,
                                   'expires' => time() + $lifeLength);
        return true;
    }

    public static function isEnabled() {
        return true;
    }
}
