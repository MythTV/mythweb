<?php
/**
 * View MythVideo files
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

/**
 * This points to the local filesystem path where MythVideo has been told to
 * look for videos.
 *
 * @global  string   $GLOBALS['mythvideo_dir']
 * @name    $mythvideo_dir
/**/
    global $mythvideo_dir;
    $mythvideo_dir = setting('VideoStartupDir', hostname);

    require_once 'includes/objects/Video.php';

// Make sure the video directory exists
    if (file_exists('data/video')) {
    // File is not a directory or a symlink
        if (!is_dir('data/video') && !is_link('data/video')) {
            custom_error('An invalid file exists at data/video.  Please remove it in'
                        .' order to use the video portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
    else {
        if ($mythvideo_dir) {
        // You can't symlink on windows
            if (strtoupper(substr(php_uname('s'), 0, 3)) != 'WIN') {
                $ret = @symlink($mythvideo_dir, 'data/video');
                if (!$ret) {
                    custom_error("Could not create a symlink to $mythvideo_dir, the local MythVideo"
                                .' directory for this hostname ('.hostname.').  Please create a'
                                .' symlink to your MythVideo directory at data/video in order to'
                                .' use the video portions of MythWeb.');
                }
            }
        }
        else {
            custom_error('Could not find a value in the database for the'
                        .' MythVideo directory for this hostname ('.hostname.').'
                        .' Please update your <a href="'.root.'settings/mythweb">settings</a>'
                        .' to point to the correct location.');
        }
    }

// Make sure the video covers directory exists
    if (file_exists('data/video_covers')) {
    // File is not a directory or a symlink
        if (!is_dir('data/video_covers') && !is_link('data/video_covers')) {
            custom_error('An invalid file exists at data/video_covers.  Please'
                        .' remove it in order to use the video portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
    else {
        $dir = setting('VideoArtworkDir', hostname);
        if ($dir) {
        // You can't symlink on windows
            if (strtoupper(substr(php_uname('s'), 0, 3)) != 'WIN') {
                $ret = @symlink($dir, 'data/video_covers');
                if (!$ret) {
                    custom_error("Could not create a symlink to $mythvideo_dir, the local MythVideo"
                                .' directory for this hostname ('.hostname.').  Please create a'
                                .' symlink to your MythVideo directory at data/video in order to'
                                .' use the video portions of MythWeb.');
                }
            }
        }
        else {
            custom_error('Could not find a value in the database for the'
                        .' MythVideo artwork directory for this hostname ('.hostname.').'
                        .' Please update your <a href="'.root.'settings/mythweb">settings</a>'
                        .' to point to the correct location.');
        }
    }

// Editing?
    if ($Path[1] == 'edit') {
        require_once 'modules/video/edit.php';
        exit;
    }

// IMDB lookup?
    if ($Path[1] == 'imdb') {
        require_once 'modules/video/imdb.php';
        exit;
    }

// Load the sorting routines
    require_once "includes/sorting.php";

// Queries for a specific program title
    isset($_GET['title']) or $_GET['title'] = $_POST['title'];

// Get the video categories on the system
    $Category_String = array();
    $sh = $db->query('SELECT * FROM videocategory');
    while ($row = $sh->fetch_assoc())
        $Category_String[$row['intid']] = $row['category'];
    $sh->finish();
    $Category_String[0] = 'Uncategorized';


// New:  Get the video genres on the system
    $Genre_String = array();
    $sh = $db->query('SELECT * FROM videogenre');
    while ($row = $sh->fetch_assoc())
        $Genre_String[$row['intid']] = $row['genre'];
    $sh->finish();
    $Genre_String[0] = 'No Genre';

// Parse the list
// Filter_Category of -1 means All, 0 mean uncategorized
    $Total_Programs = 0;
    $All_Shows      = array();
    if( isset($_GET['category']) ) {
        $Filter_Category = $_GET['category'];
        if( $Filter_Category != -1)
            $where = ' AND videometadata.category='.$db->escape($Filter_Category);
    }
    else
        $Filter_Category = -1;

// New:  sort fields
    if( isset($_GET['genre']) ) {
        $Filter_Genre = $_GET['genre'];
	if( $Filter_Genre != -1)
            $where .= ' AND videometadatagenre.idgenre='.$db->escape($Filter_Genre);
    }
    else
        $Filter_Genre = -1;

    if( isset($_GET['browse']) ) {
        $Filter_Browse = $_GET['browse'];
	if( $Filter_Browse != -1)
            $where .= ' AND videometadata.browse='.$db->escape($Filter_Browse);
    }
    else
        $Filter_Browse = -1;

    if( isset($_GET['search']) ) {
        $Filter_Search = $_GET['search'];
	if( strlen($Filter_Search) != 0)
            $where .= ' AND videometadata.title LIKE '.$db->escape("%".$Filter_Search."%");
    }
    else
        $Filter_Search = "";

    if ($where)
        $where = 'WHERE '.substr($where, 4);

    $sh = $db->query('SELECT videometadata.intid
                        FROM videometadata
                             LEFT JOIN videometadatagenre
                                    ON videometadata.intid = videometadatagenre.idvideo
                  ' . $where . '
                    GROUP BY intid
                    ORDER BY title');

    while ($intid = $sh->fetch_col())
        $All_Shows[] = new Video($intid);
    $sh->finish();

// Set sorting
    if (!is_array($_SESSION['video_sortby']))
        $_SESSION['video_sortby'] = array(array('field'   => 'title',
                                                'reverse' => false));

// Sort the programs
    if (count($All_Shows))
        sort_programs($All_Shows, 'video_sortby');

// Load the class for this page
    require_once tmpl_dir.'video.php';
