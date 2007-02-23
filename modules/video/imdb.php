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
        echo 'Error: '.t('Video: Error: IMDB: Not Found')."\n";
        return;
    }

// We need the id always set, so enforce that here
    if (!isset($_REQUEST['id'])) {
        echo 'Error: '.t('Video: Error: Missing ID')."\n";
        return;
    }

    switch($_REQUEST['action'])
    {
        case 'lookup':
            lookup($_REQUEST['title']);
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

    function lookup($title)
    {
        global $imdb;
    // First try non-fuzzy
        $output = shell_exec($imdb.' -M tv=both "'.$title.'"');
    // else try fuzzy
        if (strlen($output) == 0) {
            $output = shell_exec($imdb.' -M tv=both\;type=fuzzy "'.$title.'"');
            if (strlen($output) == 0) {
                echo 'No Matches'."\n";
                return;
            }
        }
        if (substr_count($output, "\n") == 1) {
            grab($_REQUEST['id'], substr($output, 0, 7));
            echo 'Update: '.$_REQUEST['id']."\n";
            return;
        }
        echo 'Matches: '.str_replace("\n", '|', trim($output))."\n";
    }

    function grab($id, $imdbnum)
    {
        global $imdb;
        global $db;
        $return = '';
        $output = shell_exec($imdb.' -D '.$imdbnum);
    // save the poster
        $posterurl = trim(shell_exec($imdb.' -P '.$imdbnum));
        $artworkdir = 'data/video_covers/';
        if (!is_writable($artworkdir)) {
            echo 'Warning: '.t('Video: Warning: Artwork')."\n";
        }
        else {
            $posterfile = $artworkdir.'/'.$imdbnum.'.jpg';
            if (!ini_get('allow_url_fopen'))
                echo 'Warning: '.t('Video: Warning: fopen')."\n";
            else {
                $posterjpg = @file_get_contents($posterurl);
                if ($posterjpg === FALSE)
                    echo 'Warning: '.t('Video: Warning: Artwork')."\n";
                else {
                    @file_put_contents( $posterfile, $posterjpg);
                    if (!file_exists($posterfile))
                        echo 'Warning: '.t('Video: Warning: Artwork')."\n";
                }
            }
        }
    // Get the imdb data
        $data = array();
        $lines = explode("\n", $output);
        $valid = FALSE;
        foreach ($lines as $line) {
            list ($key, $value) = explode(':', $line, 2);
            $data[strtolower($key)] = trim($value);
            if (strlen($data[strtolower($key)]) > 0)
                $valid = TRUE;
        }
        if (!$valid) {
            echo 'Error: '.t('Video: Error: IMDB')."\n";
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
                         ( filesize($posterfile) > 0 ? $posterfile : 'No Cover' ),
                         $id
                         );
        echo 'Update: '.$id."\n";
    }

    function metadata($id)
    {
        $video = new Video($id);
        echo $video->metadata();
    }

    function extendedmetadata($id)
    {
        $video = new Video($id);
        echo $video->metadata(TRUE);
    }