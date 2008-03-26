<?php
/**
 * This intigrates mythvideo's imdb grabber into mythvideo
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

    header('Content-Type: application/json');
    $return = array();

// We need the id always set, so enforce that here
    if (!isset($_REQUEST['id']))
        $return['error'][] = t('Video: Error: Missing ID');

    if (is_null(setting('web_video_imdb_path', hostname)))
        $return['error'][] = t('Video: Error: IMDB: Not Found');

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

    echo JSON::encode($return);

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
        $options          = array('IMDB'     => array( ' -M tv=both "%%TITLE%%"',
                                                       ' -M tv=both\;type=fuzzy "%%TITLE%%"',
                                                       ' -M s=tt\;ttype=ep "%%TITLE%%"'
                                                     ),
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
    // Setup the option list
        $options          = array('IMDB'     => array( 'artwork' => ' -P %%NUMBER%%'),
                                  'ALLOCINE' => array( 'artwork' => ' -P %%NUMBER%%')
                                 );
        $artworkdir       = setting('VideoArtworkDir', hostname);
        $posterfile       = $artworkdir.'/'.$imdbnum.'.jpg';
    // If the file already exists, use it, don't bother regrabbing
        if (!file_exists($posterfile)) {
    // save the poster
            $cmd = $imdb.str_replace('%%NUMBER%%', $imdbnum, $options[$imdbwebtype]['artwork']);
            exec($cmd, $output, $retval);
            if ($retval == 255)
                $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
            $posterurl = trim($output[0]);
            if (!is_writable($artworkdir))
                $return['warning'][] = t('Video: Warning: Artwork');
            else {
                if (!ini_get('allow_url_fopen'))
                    $return['warning'][] = t('Video: Warning: fopen');
                elseif(strlen($posterurl) > 0) {
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
    // Get the imdb data
        $data = array();
        $cmd = "$imdb -D $imdbnum";
        exec($cmd, $lines, $retval);
        if ($retval == 255 | $DEBUG)
            $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
        $valid = FALSE;
        foreach ($lines as $line) {
            list ($key, $value) = explode(':', $line, 2);
            $data[strtolower($key)] = trim($value);
            if (strlen($data[strtolower($key)]) > 0)
                $valid = TRUE;
        }
        if (!$valid) {
            $return['error'][] = t('Video: Error: IMDB');
            return;
        }
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
                         ( @filesize($posterfile) > 0 ? $posterfile : 'No Cover' ),
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
