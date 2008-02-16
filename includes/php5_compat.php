<?php

// Add in PHP 5
if (!function_exists('file_put_contents')) {
    function file_put_contents($file, $data) {
        $file = @fopen($file, 'w');
        if ($file === FALSE)
            return FALSE;
        $return = fwrite($file, $data);
        fclose($file);
        return $return;
    }
}


