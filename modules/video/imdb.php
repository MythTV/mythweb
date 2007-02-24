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

    $DEBUG = FALSE;

// We need to search for the imdb.pl script.
    $imdb = NULL;
    if (file_exists('/usr/share/mythtv/mythvideo/scripts/imdb.pl'))
        $imdb = '/usr/share/mythtv/mythvideo/scripts/imdb.pl';
    elseif (file_exists('/usr/local/share/mythtv/mythvideo/scripts/imdb.pl'))
        $imdb = '/usr/local/share/mythtv/mythvideo/scripts/imdb.pl';
// this *should* work well enough...
    else
        $imdb = `locate imdb.pl | head -n 1`;
    if (is_null($imdb)) {
        echo 'Error~:~ '.t('Video: Error: IMDB: Not Found')."\n";
        return;
    }

// We need the id always set, so enforce that here
    if (!isset($_REQUEST['id'])) {
        echo 'Error~:~ '.t('Video: Error: Missing ID')."\n";
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
        case 'extendedmetadata':
            extendedmetadata($_REQUEST['id']);
            break;
    }

    function lookup($id, $title)
    {
        global $imdb;
        global $DEBUG;
    // Escape any extra " in the title string
        $title = str_replace('"', '\"', $title);
    // Setup the option list
        $options = array( 'tv=both',
                          'tv=both\;type=fuzzy'
                        );
        foreach ($options as $option) {
            $cmd = "$imdb -M $option \"$title\"";
            exec($cmd, $output, $retval);
            if ($retval == 255 | $DEBUG)
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
        global $imdb;
        global $db;
        global $DEBUG;
    // save the poster
        $cmd = "$imdb -P $imdbnum";
        exec($cmd, $output, $retval);
        if ($retval == 255 | $DEBUG)
            echo "Warning~:~ IMDB Command $cmd exited with return value $retval\n";
        $posterurl = trim($output[0]);
        $artworkdir = 'data/video_covers/';
        if (!is_writable($artworkdir)) {
            echo 'Warning~:~ '.t('Video: Warning: Artwork')."\n";
        }
        else {
            $posterfile = $artworkdir.'/'.$imdbnum.'.jpg';
            if (!ini_get('allow_url_fopen'))
                echo 'Warning~:~ '.t('Video: Warning: fopen')."\n";
            elseif (!function_exists('file_get_contents'))
                echo 'Warning~:~ '.t('Video: Warning: file_get_contents')."\n";
            elseif (!function_exists('file_put_contents'))
                echo 'Warning~:~ '.t('Video: Warning: file_put_contents')."\n";
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