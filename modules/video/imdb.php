<?php
/**
 * This intigrates mythvideo's imdb grabber into mythvideo
 *
 * @url         $URL: http://svn.mythtv.org/svn/trunk/mythplugins/mythweb/modules/video/edit.php $
 * @date        $Date: 2006-06-24 12:03:10 -0700 (Sat, 24 Jun 2006) $
 * @version     $Revision: 10290 $
 * @author      $Author: xris $
 *
 * @package     MythWeb
 * @subpackage  Video
 *
/**/

// We need the id always set, so enforce that here
    if (!isset($_REQUEST['id'])) {
        echo 'Error~:~ '.t('Video: Error: Missing ID')."\n";
        return;
    }

    if (is_null(setting('web_video_imdb_path', hostname))) {
        echo 'Error~:~ '.t('Video: Error: IMDB: Not Found')."\n";
        return;
    }

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

    function lookup($id, $title)
    {
        $imdb = setting('web_video_imdb_path', hostname);
        $imdbwebtype = setting('web_video_imdb_type', hostname);
    // Escape any extra " in the title string
        $title = str_replace('"', '\"', $title);
    // Setup the option list
        $options = array('IMDB'     => array( ' -M tv=both "%%TITLE%%"',
                                              ' -M tv=both\;type=fuzzy "%%TITLE%%"'),
                         'ALLOCINE' => array( ' -M "%%TITLE%%"')
                        );
        foreach ($options[$imdbwebtype] as $option) {
            $cmd = $imdb.str_replace('%%TITLE%%', $title, $option);
            exec($cmd, $output, $retval);
            if ($retval == 255)
                echo "Warning~:~ IMDB Command $cmd exited with return value $retval\n";
            if (count($output)) {
                echo 'Matches~:~ id: '.$id;
                foreach ($output as $line)
                    echo '|'.$line;
                echo "\n";
                return;
            }
        }
        echo 'No Matches~:~ '.$id."\n";
    }

    function grab($id, $imdbnum)
    {
        global $db;
        $imdb = setting('web_video_imdb_path', hostname);
        $imdbwebtype = setting('web_video_imdb_type', hostname);
    // Setup the option list
        $options = array('IMDB'     => array( 'artwork' => ' -P %%NUMBER%%'),
                         'ALLOCINE' => array( 'artwork' => ' -P %%NUMBER%%')
                        );
        $artworkdir = setting('VideoArtworkDir', hostname);
        $posterfile = $artworkdir.'/'.$imdbnum.'.jpg';
    // If the file already exists, use it, don't bother regrabbing
        if (!file_exists($posterfile)) {
    // save the poster
            $cmd = $imdb.str_replace('%%NUMBER%%', $imdbnum, $options[$imdbwebtype]['artwork']);
            exec($cmd, $output, $retval);
            if ($retval == 255)
                echo "Warning~:~ IMDB Command $cmd exited with return value $retval\n";
            $posterurl = trim($output[0]);
            if (!is_writable($artworkdir))
                echo 'Warning~:~ '.t('Video: Warning: Artwork')."\n";
            else {
                if (!ini_get('allow_url_fopen'))
                    echo 'Warning~:~ '.t('Video: Warning: fopen')."\n";
                elseif(strlen($posterurl) > 0) {
                    $posterjpg = @file_get_contents($posterurl);
                    if ($posterjpg === FALSE)
                        echo 'Warning~:~ '.t('Video: Warning: Artwork: Download')."\n";
                    else {
                        @file_put_contents( $posterfile, $posterjpg);
                    if (!file_exists($posterfile))
                        echo 'Warning~:~ '.t('Video: Warning: Artwork')."\n";
                    }
                }
            }
        }
    // Get the imdb data
        $data = array();
        $cmd = "$imdb -D $imdbnum";
        exec($cmd, $lines, $retval);
        if ($retval == 255 | $DEBUG)
            echo "Warning~:~ IMDB Command $cmd exited with return value $retval\n";
        $valid = FALSE;
        foreach ($lines as $line) {
            list ($key, $value) = explode(':', $line, 2);
            $data[strtolower($key)] = trim($value);
            if (strlen($data[strtolower($key)]) > 0)
                $valid = TRUE;
        }
        if (!$valid) {
            echo 'Error~:~ '.t('Video: Error: IMDB')."\n";
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
        echo 'Update~:~ '.$id."\n";
    }

    function metadata($id)
    {
        $video = new Video($id);
        echo $video->metadata();
    }
