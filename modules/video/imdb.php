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

        foreach ($options[$imdbwebtype] as $option) {
            $cmd = $imdb.str_replace('%%TITLE%%', $title, $option);
            exec($cmd, $output, $retval);
            if ($retval == 255)
                $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
            if (!count($output)) {
                $title_parts = explode(' ', $title);
                $cmd = $imdb.str_replace('%%TITLE%%', $title_parts[0], $option);
                exec($cmd, $output, $retval);
                if ($retval == 255)
                    $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
            }
            if (!count($output))
                continue;
            $single_output='';
            foreach ($output as $line) {
                $single_output=$single_output.$line;
            }
            $xml = simplexml_load_string($single_output);

            foreach ($xml as $item) {
                if (strlen($item->imdb) > 1) {
                    $imdbid = (string)$item->imdb;
                    $title = (string)$item->title;
                    $return['matches'][] = array('imdbid' => $imdbid, 'title' => $title);
                }
            }
        }
    }

    function grab($id, $imdbnum)
    {
        global $db;
        global $return;

 //  Get the video genres on the system
     $Genre_String = array();
     $Genre_Index = array();
     $sh = $db->query('SELECT * FROM videogenre ORDER BY genre');
     while ($row = $sh->fetch_assoc()) {
         $Genre_String[$row['intid']] = $row['genre'];
         $Genre_Index[$row['genre']] = $row['intid'];
     }
     $sh->finish();
     $Genre_String[0] = t('No Genre');


     $Category_String = array();
     $Category_Index = array();
     $sh = $db->query('SELECT * FROM videocategory ORDER BY category');
     while ($row = $sh->fetch_assoc()) {
         $Category_String[$row['intid']] = $row['category'];
         $Category_Index[$row['category']] = $row['intid'];
     }
     $sh->finish();
     $Category_String[0] = t('Uncategorized');

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

    # Figure out the fanart directory
        $fanartwork_dirs = $db->query_list('
            SELECT  dirname
            FROM    storagegroup
            WHERE   groupname="Fanart"
            ');
        if (empty($fanartwork_dirs)) {
            $return['warning'][] = 'MythWeb now requires use of the Fanart Storage Group.';
            return;
        }
        foreach ($fanartwork_dirs as $dir) {
            if (is_dir($dir) || is_link($dir)) {
                $fanartwork_dir = $dir;
                break;
            }
        }
        if (empty($fanartwork_dir)) {
            $return['warning'][] = 'Could not find a valid Fanart Storage Group directory';
            return;
        }
        $fanartfile = "$fanartwork_dir/$imdbnum.jpg";


    // Get the imdb data
        $data = array();
        $cmd = "$imdb -D $imdbnum";
        exec($cmd, $output, $retval);
        if ($retval == 255 || $DEBUG) {
            $return['warning'][] = "IMDB Command $cmd exited with return value $retval";
        }
        $single_output='';
        foreach ($output as $line) {
            $single_output=$single_output.$line;
        }
        $xml = simplexml_load_string($single_output);

        foreach ($xml as $item) {
          $data['title'] = (string)$item->title;
          $data['plot'] = (string)$item->description;
          $date = date_parse($item->releasedate);
          $data['year'] = (string)$date['year'];
          $data['userrating'] = (string)$item->userrating;
          $data['runtime'] = (string)$item->runtime;
          if ($item->certifications) {
            foreach ($item->certifications->certification as $cert) {
              if (strtoupper($cert->attributes()->locale) == "US" && !$data['movierating']) {
                $data['movierating'] = (string)$cert->attributes()->name;
              }
            }
          }
          if ($item->people) {
            foreach ($item->people->person as $person) {
              if (strtoupper($person->attributes()->job) == "DIRECTOR" && !$data['director']) {
                $data['director'] = (string)$person->attributes()->name;
              }
            }
          }
          $data['coverart']='';
          $data['fanart']='';
          foreach ($item->images->image as $image_data) {
            if ($image_data->attributes()->type == 'coverart' && !$data['coverart']) {
              $data['coverart'] = (string)$image_data->attributes()->url;
            }
            if ($image_data->attributes()->type == 'fanart' && !$data['fanart']) {
              $data['fanart'] = (string)$image_data->attributes()->url;
            }
          }
        }
        $data['genre'] = array();
        foreach ($item->categories->category as $cat) {
          array_push($data['genre'], (string)$cat->attributes()->name);
        }
    // If the file already exists, use it, don't bother regrabbing
        if (!file_exists($posterfile)) {
            $posterurl = $data['coverart'];
            if (!is_writable($artwork_dir)) {
                $return['warning'][] = t('Video: Warning: Artwork');
            } else {
                if (!ini_get('allow_url_fopen')) {
                    $return['warning'][] = t('Video: Warning: fopen');
                } elseif(strlen($posterurl) > 0) {
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
    // rinse and repeat for fanart
    // If the file already exists, use it, don't bother regrabbing
        if (!file_exists($fanartfile)) {
            $posterurl = $data['fanart'];
            if (!is_writable($fanartwork_dir))
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
                        @file_put_contents( $fanartfile, $posterjpg);
                        if (!file_exists($fanartfile))
                            $return['warning'][] = t('Video: Warning: Artwork');
                    }
                }
            }
        }

        if (!$Category_Index[$data['genre'][0]]) {
            $db->query('INSERT INTO videocategory SET category = ?', $data['genre'][0]);
        }

    // Update the database
        $sh = $db->query('UPDATE videometadata
                             SET title        = ?,
                                 director     = ?,
                                 plot         = ?,
                                 rating       = ?,
                                 category     = ?,
                                 inetref      = ?,
                                 year         = ?,
                                 userrating   = ?,
                                 length       = ?,
                                 coverfile    = ?,
                                 fanart       = ?
                           WHERE intid        = ?',
                         $data['title'],
                         $data['director'],
                         $data['plot'],
                         $data['movierating'],
                         $Category_Index[$data['genre'][0]],
                         $imdbnum,
                         $data['year'],
                         $data['userrating'],
                         $data['runtime'],
                         ( @filesize($posterfile) > 0 ? "$imdbnum.jpg" : 'No Cover' ),
                         ( @filesize($fanartfile) > 0 ? "$imdbnum.jpg" : 'No Cover' ),
                         $id
                         );

        $db->query('DELETE FROM videometadatagenre
                     WHERE videometadatagenre.idvideo = ?',
                     $id
                     );

        if (count($data['genre']) > 0)
            foreach ($data['genre'] as $genre)
                $db->query('INSERT INTO videometadatagenre ( idvideo, idgenre )
                                                    VALUES (       ?,       ? )',
                            $id,
                            $Genre_Index[$genre]
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
