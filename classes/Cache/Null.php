<?php

class Cache_Null implements Cache_Engine {
    public function &get($key = null) {
        return null;
    }

    public function set($object, $data, $lifeLength) {
        return null;
    }

    public static function isEnabled() {
        return true;
    }
}
