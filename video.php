<?php
/***                                                                        ***\
    video.php                               Last Updated: 2004.05.24 (bobc)

    view video files.
\***                                                                        ***/


// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Queries for a specific program title
    isset($_GET['title'])  or $_GET['title']  = $_POST['title'];

// Parse the list

    $Total_Programs = 0;
    $All_Shows      = array();
    while (true) {
        $result = mysql_query('SELECT * FROM videometadata ORDER BY title')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
        while ($video_data = mysql_fetch_assoc($result))    {
        // Create a new object
            $show = new Video($video_data);
        // Assign a reference to this show to the array
            $All_Shows[]                 = &$show;
            unset($show);
        }
        break;
    }


// Set sorting
    if (!is_array($_SESSION['video_sortby']))
        $_SESSION['video_sortby'] = array(array('field' => 'title',
                                                   'reverse' => false));

// Sort the programs
    if (count($All_Shows))
        sort_programs($All_Shows, 'video_sortby');

// Get the video store directory
   $result = mysql_query('SELECT data from settings where value="VideoStartupDir"')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
   $videostore=mysql_fetch_assoc($result);
   $videodir=$videostore['data'];


// Load the class for this page
    require_once theme_dir.'video.php';

// Create an instance of this page from its theme object
    $Page = new Theme_video();

// Display the page
    $Page->print_page();

// Exit
    exit;



class Video {

    var $intid;
    var $plot;
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

    function Video($program_data) {
        $this->intid            = $program_data['intid'];
        $this->plot            = $program_data['plot'];
        $this->rating          = $program_data['rating'];
        $this->title           = $program_data['title'];
        $this->director        = $program_data['director'];
        $this->inetref         = $program_data['inetref'];
        $this->year            = $program_data['year']       ? $program_data['year']       : 'Unknown';
        $this->userrating      = $program_data['userrating'] ? $program_data['userrating'] : 'Unknown';
        $this->length          = $program_data['length'];
        $this->showlevel       = $program_data['showlevel'];
        $this->filename        = $program_data['filename'];
        $this->coverfile       = $program_data['coverfile'];
        $this->childid         = $program_data['childid'];
    }
}

?>
