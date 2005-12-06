<?php
/**
 * This module would work fine, except that PHP freaks out with files larger
 * than 2G, so it's disabled and left half-finished.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Which show are we streaming?
    if ($Path[1]) {
        $_GET['chanid']    = $Path[1];
        $_GET['starttime'] = $Path[2];
    }

// We need to scan through the available recordings to get at the additional information
    foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $row) {
    // This row isn't the one we're looking for
        if ($row[4] != $_GET['chanid'] || $row[11] != $_GET['starttime'])
            continue;
    // No need to scan the rest of the items, so leave early
        break;
    }

// No filename?
    if (empty($row[8])) {
        trigger_error('An unknown recording was requested', FATAL);
    }

// No recording file?
    if (!file_exists($row[8])) {
        trigger_error('Cannot find matching file for specified recording', FATAL);
    }

// Trap for errors
    $size = @filesize($row[8]);
    if (!$size)
        trigger_error('Files larger than 2G do not work properly with this version of php', FATAL);

// What kind of file?
    switch (strtolower(substr($row[8], -3, 3))) {
        case 'mpg':
            header('Content-Type: video/mpeg');
            break;
        case 'nuv':
            header('Content-Type: video/nuppelvideo');
            break;
        default:
            trigger_error('Unknown video type requested', FATAL);
    }

// Let the browser know the filename
    header('Content-Disposition: attachment; filename='.basename($row[8]));

// How big is the file
    header('Content-Length: '.$size);

// Someday we want to pull this straight from mythbackend, but for now,
// just read out the file itself in 128k increments.
    $fp = fopen($row[8], 'r');
    while ($bytes = fread($fp, 131072)) {
        echo $bytes;
    // Refresh the time limit
        set_time_limit(30);
    }
    fclose($fp);

// The file has finished loading, but the transfer still needs to catch up.
    set_time_limit(0);

// Time to leave
    exit;
