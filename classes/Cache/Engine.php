<?php

interface Cache_Engine {
    public function &get($key = null);
    public function set($key, $data, $lifeLength);
    public static function isEnabled();
    public function clear();
}
