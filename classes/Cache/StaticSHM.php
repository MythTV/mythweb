<?php

class Cache_StaticSHM implements Cache_Engine {

    private $Static     = null;
    private $SHM        = null;

    public function __construct() {
        $this->Static   = new Cache_Static();
        $this->SHM      = new Cache_SHM();
    }

    public function &get($key = null) {
        $data = $this->Static->get($key);
        if (is_null($data))
            $data = $this->SHM->get($key);
        return $data;
    }

    public function set($key, $data, $lifeLength) {
        return $this->Static->set($key, $data, $lifeLength) && $this->SHM->set($key, $data, $lifeLength);
    }

    public static function isEnabled() {
        return Cache_Static::isEnabled() && Cache_SHM::isEnabled();
    }
}
