<?php

interface Cache_Engine {
    public function &get($key = null);
    public function set($key, $data, $lifeLength);
    public function enable();
    public function disable();
    public static function isEnabled();
}
