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
    $mythvideo_dir = $db->query_col('SELECT data
                                       FROM settings
                                      WHERE value="VideoStartupDir" AND hostname=?',
                                    hostname
                                    );

// Make sure the video directory exists
    if (file_exists('data/video')) {
    // File is not a directory or a symlink
        if (!is_dir('data/video') && !is_link('data/video')) {
            custom_error('An invalid file exists at data/video.  Please remove it in'
                        .' order to use the video portions of MythWeb.');
        }
    }
// Create the symlink, if possible.
//
// NOTE:  Errors have been disabled because if I turn them on, people hosting
//        MythWeb on Windows machines will have issues.  I will turn the errors
//        back on when I find a clean way to do so.
//
    else {
        if ($mythvideo_dir) {
            $ret = @symlink($mythvideo_dir, 'data/video');
            if (!$ret) {
                #custom_error("Could not create a symlink to $mythvideo_dir, the local MythVideo"
                #            .' directory for this hostname ('.hostname.').  Please create a
                #            .' symlink to your MythVideo directory at data/video in order to
                #            .' use the video portions of MythWeb.');
            }
        }
        else {
            #custom_error('Could not find a value in the database for the MythVideo directory'
            #            .' for this hostname ('.hostname.').  Please create a symlink to your'
            #            .' MythVideo directory at data/video in order to use the video'
            #            .' portions of MythWeb.');
        }
    }

// Editing?
    if ($Path[1] == 'edit') {
        require_once 'modules/video/edit.php';
        exit;
    }

// Load the sorting routines
    require_once "includes/sorting.php";

// Queries for a specific program title
    isset($_GET['title']) or $_GET['title'] = $_POST['title'];

// Get the video categories on the system
    $Category_String = array();
    $Total_Categories = 0;
    $sh = $db->query('SELECT * FROM videocategory');
    while ($row = $sh->fetch_assoc()) {
        $Category_String[$row['intid']] = $row['category'];
        $Total_Categories++;
    }
    $sh->finish();
    $Category_String[0] = 'Uncategorized';

// Parse the list
// Filter_Category of -1 means All, 0 mean uncategorized
    $Total_Programs = 0;
    $All_Shows      = array();
    if( isset($_GET['category']) ) {
        $Filter_Category = $_GET['category'];
        if( $Filter_Category != -1)
            $where = ' WHERE category='.$db->escape($Filter_Category);
    }
    else {
        $Filter_Category = -1;
    }

    $sh = $db->query('SELECT * FROM videometadata ' . $where . ' ORDER BY title');
    while ($row = $sh->fetch_assoc()) {
    // Create a new show object
        $All_Shows[] = new Video($row);
    }
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

// Exit
    exit;



class Video {

    var $intid;
    var $plot;
    var $category;
    var $rating;    // this should be a reference to the $Channel array value

    var $title;
    var $director;
    var $inetref;
    var $year;
    var $userrating;
    var $length;            // css class, based on category and/or category_type
    var $showlevel;
    var $filename;
    var $coverfile;
    var $childid;
    var $url;

    function Video($program_data) {
        global $mythvideo_dir;
        $this->intid      = $program_data['intid'];
        $this->plot       = $program_data['plot'];
        $this->category   = $program_data['category'];
        $this->rating     = $program_data['rating'];
        $this->title      = $program_data['title'];
        $this->director   = $program_data['director'];
        $this->inetref    = $program_data['inetref'];
        $this->year       = $program_data['year']       ? $program_data['year']       : 'Unknown';
        $this->userrating = $program_data['userrating'] ? $program_data['userrating'] : 'Unknown';
        $this->length     = $program_data['length'];
        $this->showlevel  = $program_data['showlevel'];
        $this->filename   = $program_data['filename'];
        $this->coverfile  = $program_data['coverfile'];
        $this->childid    = $program_data['childid'];
    // Figure out the URL
        $this->url = '#';
        if (file_exists('data/video/')) {
            $this->url = root . implode('/', array_map('rawurlencode',
                                             array_map('utf8tolocal',
                                             explode('/',
                                             'data/video/' . preg_replace('#^'.$mythvideo_dir.'/?#', '', $this->filename)
                                       ))));
        }
    }
}

