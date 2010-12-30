<?php
/**
 * Get a pixmap
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

    $hostname   = $Path[2];
    $chanid     = $Path[3];
    $starttime  = $Path[4];
    $width      = $Path[5];
    $height     = $Path[6];
    $seconds_in = $Path[7];

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        if (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $starttime) {
            header("HTTP/1.1 304 Not Modified");
            exit;
        }
    }

    $data = Program::get_preview_pixmap($hostname, $chanid, $starttime, $width, $height, $seconds_in);
    if (strlen($data)) {
        header('Pragma: public', true);
        header('Content-Type: image/png');
        header("Content-Length: ".strlen($data));
        header("Cache-Control: max-age=".(7*24*60*60*60).", public");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s", $starttime)." GMT");
        header("Expires: ".gmdate("D, d M Y H:i:s", $starttime + (7*24*60*60*60))." GMT");

        echo $data;
    }
    else
        header("Status: 404 Not Found");

    exit;
