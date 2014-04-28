<?php
/**
 * Stream a video file
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Video
/**/

// Yes, a db connection
    global $db;

// Pull video ID
    $vid_id = $_GET['Id'];

// Get filename
    list($fname) = $db->query_row('SELECT filename
                                     FROM videometadata
                                    WHERE intid = ?', $vid_id);

// Mime type
    switch (substr($fname, strrpos($fname, '.')+1)) {
        case 'mpg':
        case 'mpeg':
            $mime = 'video/mpeg';
            break;
        case 'mp4':
            $mime = 'video/mp4';
            break;
        case 'ogg':
        case 'ogm':
        case 'ogv':
            $mime = 'video/ogg';
            break;
        case 'qt':
            $mime = 'video/quicktime';
            break;
        case 'webm':
            $mime = 'video/webm';
            break;
        case 'mkv':
            $mime = 'video/x-matroska';
            break;
        case 'wmv':
            $mime = 'video/x-ms-wmv';
            break;
        case 'flv':
            $mime = 'video/x-flv';
            break;
        default:
            $mime = 'application/octet-stream';
    }
    header('Content-Type: '.$mime);

// Send the filename
    header('Content-Disposition: filename="'.$fname.'"');

// Send data via the backend
    $Master_Host = setting('MasterServerIP');
    $port = _or(get_backend_setting('BackendStatusPort', $Master_Host),
                get_backend_setting('BackendStatusPort'));
    if (stripos($Master_Host,':') !== false) {
        $Master_Host = '['.$Master_Host.']';
    }
    if (ob_get_level()) {
        ob_end_clean();
    }
    readfile("http://$Master_Host:$port/Content/GetVideo?Id=".$vid_id);

// Nothing else to do
    exit;
