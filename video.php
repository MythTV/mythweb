<?php
/***                                                                        ***\
    video.php                               Last Updated: 2005.02.06 (xris)

    view video files.
\***                                                                        ***/

// Which section are we in?
    define('section', 'video');

// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Queries for a specific program title
    isset($_GET['title'])  or $_GET['title']  = $_POST['title'];

// Get the video store directory
   $result = mysql_query('SELECT data from settings where value="VideoStartupDir"')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
   list($videodir) = mysql_fetch_row($result);
   mysql_free_result($result);

// Get the video categories on the system
   $Total_Categories = 0;
   $result = mysql_query('SELECT * FROM videocategory')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
   while( $cat_data = mysql_fetch_assoc($result) )  {
        $Category_String[$cat_data["intid"]] = $cat_data["category"];
        $Total_Categories++;
   }
   $Category_String[0] = "Uncategorized";
   mysql_free_result($result);

// Parse the list
// Filter_Category of -1 means All, 0 mean uncategorized
    $Total_Programs = 0;
    $All_Shows      = array();
    if( isset($_GET['category']) ) {
        $Filter_Category = $_GET['category'];
        if($Filter_Category != -1)
            $where = "WHERE category=$Filter_Category";
    }
    else {
        $Filter_Category = -1;
    }
    while (true) {
        $query = "SELECT * FROM videometadata " . $where . " ORDER BY title";
        $result = mysql_query($query)
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
        while ($video_data = mysql_fetch_assoc($result))    {
        // Create a new object
            $show = new Video($video_data);
        // Assign a reference to this show to the array
            $All_Shows[] = &$show;
            unset($show);
        }
        break;
    }

// Set sorting
    if (!is_array($_SESSION['video_sortby']))
        $_SESSION['video_sortby'] = array(array('field'   => 'title',
                                                'reverse' => false));

// Sort the programs
    if (count($All_Shows))
        sort_programs($All_Shows, 'video_sortby');

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
        $this->intid           = $program_data['intid'];
        $this->plot            = $program_data['plot'];
        $this->category        = $program_data['category'];
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
    // Figure out the URL
        global $videodir;
        $this->url = video_url;
        foreach (preg_split('/\//', substr($this->filename, strlen($videodir))) as $dir) {
            if (!$dir) continue;
            htmlentities($this->subtitle, ENT_COMPAT, 'UTF-8')
            if (function_exists('mb_convert_encoding'))
                $this->url .= '/'.rawurlencode(mb_convert_encoding($dir, fs_encoding, 'UTF-8'));
            else
                $this->url .= '/'.rawurlencode($dir);
        }
    }
}

?>
