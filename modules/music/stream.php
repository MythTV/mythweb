<?php
/**
 * Stream a music file
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Music
/**/

// Yes, a db connection
    global $db;

// No timeouts
    set_time_limit(0);

// Album art?
    if ($_GET['a']) {
        list($path, $fname) = $db->query_row('SELECT md.path, ma.filename
                                                FROM music_albumart AS ma
                                                     LEFT JOIN music_directories AS md
                                                            ON ma.directory_id=md.directory_id
                                               WHERE ma.albumart_id = ?',
                                             $_GET['a']);
    // Set the XML transfer command
        $xml_command = 'Content/GetAlbumArt';
    // Set the XML transfer file id
        $xml_id = $_GET['a'];
    }

// Music?
    elseif ($_GET['i']) {
    // Load some info about the song
        list($path, $fname) = $db->query_row('SELECT md.path, ms.filename
                                                FROM music_songs AS ms
                                                     LEFT JOIN music_directories AS md
                                                            ON ms.directory_id=md.directory_id
                                               WHERE ms.song_id = ?',
                                             $_GET['i']);
    // Update the play count
        $db->query('UPDATE music_songs
                       SET numplays = numplays + 1, lastplay = NOW()
                     WHERE song_id = ?',
                   $_GET['i']);
    // Set the XML transfer command
        $xml_command = 'Content/GetMusic';
    // Set the XML transfer file id
        $xml_id = $_GET['i'];
    }

// Unknown request or empty file?
    if (empty($fname))
        exit;

// HTTP stream?
    if (preg_match('#^\w+://#', $fname)) {
        redirect_browser($fname);
    }

// Mime type
    switch (substr($fname, -3)) {
        case 'jpg':
            $mime = 'image/jpeg';
            break;
        case 'gif':
            $mime = 'image/gif';
            break;
        case 'png':
            $mime = 'image/png';
            break;
        case 'mp3':
            $mime = 'audio/mpeg';
            break;
        case 'ogg':
            $mime = 'application/ogg';
            break;
        case 'm4a':
            $mime = 'audio/mp4a-latm';
            break;
        default:
            $mime = 'application/octet-stream';
    }
    header('Content-Type: '.$mime);

// Send the filename
    header('Content-Disposition: filename="'.$fname.'"');

// Base music path
    $basepath = setting('MusicLocation', hostname);

// Local file?
    if (file_exists("$basepath/$path/$fname")) {
        header('Content-Length: '.filesize("$basepath/$path/$fname"));
        readfile("$basepath/$path/$fname");
    }
// Otherwise, send it via the backend
    else {
        $Master_Host = setting('MasterServerIP');
        $port = _or(get_backend_setting('BackendStatusPort', $Master_Host),
                    get_backend_setting('BackendStatusPort'));
        if (stripos($Master_Host,':') !== false) {
            $Master_Host = '['.$Master_Host.']';
        }
        readfile("http://$Master_Host:$port/$xml_command?Id=".$xml_id);
    }

// Nothing else to do
    exit;
