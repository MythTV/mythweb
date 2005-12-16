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
    require_once theme_dir.'video/video.php';

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
        if (mythvideo_url != 'mythvideo_url' && file_exists(mythvideo_url)) {
            $this->url = root . implode('/', array_map('rawurlencode',
                                             array_map('utf8tolocal',
                                             explode('/',
                                             mythvideo_url . '/' . preg_replace('#^'.mythvideo_dir.'/?#', '', $this->filename)
                                       ))));
        }
    }
}

