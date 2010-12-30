<?php
/**
 * This intigrates mythvideo's imdb grabber into mythvideo
 *
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

    header('Content-Type: application/json');
    $return = array();

// We need the id always set, so enforce that here
    if (!isset($_REQUEST['id']))
        die(json_encode(array('error' => array(t('Video: Error: Missing ID')))));

    if (is_null(setting('web_video_imdb_path', hostname)))
        die(json_encode(array('error' => array(t('Video: Error: IMDB: Not Found')))));

    switch($_REQUEST['action'])
    {
        case 'lookup':
            lookup($_REQUEST['id'], $_REQUEST['title']);
            break;
        case 'grab':
            grab($_REQUEST['id'], $_REQUEST['number']);
            break;
        case 'metadata':
            metadata($_REQUEST['id']);
            break;
    }

    echo json_encode($return);

    function lookup($id, $title)
    {
        global $return;
        $return['id']     = $id;
        $return['action'] = 'lookup';
        $imdb             = setting('web_video_imdb_path', hostname);
        $imdbwebtype      = setting('web_video_imdb_type', hostname);
    // Escape any extra " in the title string
        $title            = str_replace('"', '\"', $title);
    // Setup the option list
        $options          = array('IMDB'     => array( ' -M "%%TITLE%%"' ),
                                  'ALLOCINE' => array( ' -M "%%TITLE%%"')
                                 );

        $dupe = array();
        foreach ($options[$imdbwebtype] as $option) {
            $cmd = $imdb.str_replace('%%TITLE%%', $title, $option);
            exec($cmd, $output, $retval);
            if ($retval == 255)
                $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
            if (!count($output))
                continue;
            foreach ($output as $line) {
                list($imdbid, $title) = explode(':', $line, 2);
                if ($dupe[$imdbid])
                    continue;
                $dupe[$imdbid] = true;
                $return['matches'][] = array('imdbid' => $imdbid,
                                             'title'  => $title);
            }
        }
    }

    function grab($id, $imdbnum)
    {
        global $db;
        global $return;
        $return['action'] = 'grab';
        $imdb             = setting('web_video_imdb_path', hostname);
        $imdbwebtype      = setting('web_video_imdb_type', hostname);
    # Figure out the artwork directory
        $artwork_dirs = $db->query_list('
            SELECT  dirname
            FROM    storagegroup
            WHERE   groupname="Coverart"
            ');
        if (empty($artwork_dirs)) {
            $return['warning'][] = 'MythWeb now requires use of the Coverart Storage Group.';
            return;
        }
        foreach ($artwork_dirs as $dir) {
            if (is_dir($dir) || is_link($dir)) {
                $artwork_dir = $dir;
                break;
            }
        }
        if (empty($artwork_dir)) {
            $return['warning'][] = 'Could not find a valid Coverart Storage Group directory';
            return;
        }
        $posterfile = "$artwork_dir/$imdbnum.jpg";
    // Get the imdb data
        $data = array();
        $cmd = "$imdb -D $imdbnum";
        exec($cmd, $lines, $retval);
        if ($retval == 255 || $DEBUG) {
            $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
        }
        $valid = FALSE;
        foreach ($lines as $line) {
            list ($key, $value) = explode(':', $line, 2);
            $data[strtolower($key)] = trim($value);
            if (strlen($data[strtolower($key)]) > 0) {
                $valid = TRUE;
            }
        }
        if (!$valid) {
            $return['error'][] = t('Video: Error: IMDB');
            return;
        }
    // If the file already exists, use it, don't bother regrabbing
        if (!file_exists($posterfile)) {
            $posterurl = $data['coverart'];
            if (!is_writable($artwork_dir))
                $return['warning'][] = t('Video: Warning: Artwork');
            else {
                if (!ini_get('allow_url_fopen'))
                    $return['warning'][] = t('Video: Warning: fopen');
                elseif(strlen($posterurl) > 0) {
                    $posterurl = preg_replace('/,.+$/', '', $posterurl);    // For now, only bother to grab the first poster URL
                    $posterjpg = @file_get_contents($posterurl);
                    if ($posterjpg === FALSE)
                        $return['warning'][] = t('Video: Warning: Artwork: Download');
                    else {
                        @file_put_contents( $posterfile, $posterjpg);
                        if (!file_exists($posterfile))
                            $return['warning'][] = t('Video: Warning: Artwork');
                    }
                }
            }
        }
    // Update the database
        $sh = $db->query('UPDATE videometadata
                             SET title        = ?,
                                 director     = ?,
                                 plot         = ?,
                                 rating       = ?,
                                 inetref      = ?,
                                 year         = ?,
                                 userrating   = ?,
                                 length       = ?,
                                 coverfile    = ?
                           WHERE intid        = ?',
                         $data['title'],
                         $data['director'],
                         $data['plot'],
                         $data['movierating'],
                         $imdbnum,
                         $data['year'],
                         $data['userrating'],
                         $data['runtime'],
                         ( @filesize($posterfile) > 0 ? "$imdbnum.jpg" : 'No Cover' ),
                         $id
                         );
        $return['update'][] = $id;
    }

    function metadata($id)
    {
        global $return;
        $return['action']   = 'metadata';
        $video              = new Video($id);
        $return['metadata'] = $video->metadata();
    }
