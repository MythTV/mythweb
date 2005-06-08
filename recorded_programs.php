<?php
/***                                                                        ***\
    recorded_programs.php                    Last Updated: 2005.04.02 (xris)

    view and manipulate recorded programs.
\***                                                                        ***/


// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Delete a program?
    isset($_GET['forget_old']) or $_GET['forget_old'] = $_POST['forget_old'];
    isset($_GET['delete'])     or $_GET['delete']     = $_POST['delete'];
    isset($_GET['file'])       or $_GET['file']       = $_POST['file'];
    if ($_GET['delete'] && preg_match('/\\d+_\\d+/', $_GET['file'])) {
    // Keep a previous-row counter to return to after deleting
        $prev_row = -2;
    // We need to scan through the available recordings to get at the additional information required by the DELETE_RECORDING query
        foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $row) {
        // increment if row has the same title as the show we're deleting or if viewing 'all recordings'
            if (($_SESSION['recorded_title'] == $row[0]) || ($_SESSION['recorded_title'] == ''))
                $prev_row++;
        // This row isn't the one we're looking for
            if ($row[8] != $_GET['file'])
                continue;
        // Forget all knowledge of old recordings
            if (isset($_GET['forget_old'])) {
                preg_match('/\/(\d+)_(\d+)_\d+\.nuv$/', $_GET['file'], $matches);
                $show = new Program($row);
                $show->rec_forget_old();
            }
        // Delete the recording
            backend_command(array('DELETE_RECORDING', implode(backend_sep, $row), '0'));
        // Delay a second so the backend can catch up
        # Disabled because I don't really think it's needed
        #    sleep(1);
        // No need to scan the rest of the items, so leave early
            break;
        }
    // Redirect back to the page again, but without the query string, so reloads are cleaner
    // WML browser often require a fully qualified URL for redirects to work. Also, set content type
        if ($_SESSION['Theme'] == 'wml') {
            header('Content-type: text/vnd.wap.wml');
            header('Location: http://'.$_SERVER["HTTP_HOST"].$_SERVER["SCRIPT_NAME"]);
        }
    // Return to the row just prior to the one deleted
    //  (with some fuzz to account for normal screen height
    //   -- remember that rows are numbered starting at zero)
        else {
            header('Location: recorded_programs.php'.($prev_row > 0 ? "#$prev_row" : ''));
        }
    // need at least 1 byte in body
        echo "\n";
        exit;
    }

// Queries for a specific program title
    isset($_GET['title']) or $_GET['title']  = $_POST['title'];
    isset($_GET['title']) or $_GET['title']  = $_SESSION['recorded_title'];

// Parse the program list
    $recordings     = get_backend_rows('QUERY_RECORDINGS Delete');
    $Total_Time     = 0;
    $Total_Programs = 0;
    $All_Shows      = array();
    $Programs       = array();
    $Groups         = array();
    while (true) {
        $Program_Titles = array();
        foreach ($recordings as $key => $record) {
        // Skip the offset
            if ($key === 'offset')  // WHY IN THE WORLD DOES 0 == 'offset'?!?!?  so we use ===
                continue;
        // Create a new program object
            $show = new Program($record);
        // Make sure this is a valid show
            if (!$show->chanid || $show->length < 1)
                continue;
        // Keep track of the total time
            $Total_Time += $show->length;
        // Skip programs the user doesn't want to look at, but keep track of their names and how many episodes we have recorded
            $Total_Programs++;
            $Program_Titles[$record[0]]++;
            $Groups[$record[30]]++;
            if ($_GET['title'] && $_GET['title'] != $record[0])
                continue;
            if ($_GET['recgroup'] && $_GET['recgroup'] != $record[30])
                continue;
        // Make sure that everything we're dealing with is an array
            if (!is_array($Programs[$show->title]))
                $Programs[$show->title] = array();
        // Generate any thumbnail images we might need
            if (show_recorded_pixmaps) {
                generate_preview_pixmap($show);
            }
        // Assign a reference to this show to the various arrays
            $All_Shows[]                         =& $show;
            $Programs[$show->title][]            =& $show;
            $Channels[$show->chanid]->programs[] =& $show;
            unset($show);
        }
    // Did we try to view a program that we don't have recorded?  Revert to showing all programs
        if ($_GET['title'] && !count($Programs)) {
            $Warnings[] = 'No matching programs found.  Showing all programs.';
            unset($_GET['title']);
        }
    // Found some programs, let's move on
        else
            break;
    }

// Sort the program titles
    ksort($Program_Titles);

// Keep track of the program/title the user wants to view
    $_SESSION['recorded_title'] = $_GET['title'];

// The default sorting choice isn't so good for recorded programs, so we'll set our own default
    if (!is_array($_SESSION['recorded_sortby']) || !count($_SESSION['recorded_sortby']))
        $_SESSION['recorded_sortby'] = array(array('field' => 'airdate',
                                                   'reverse' => true),
                                             array('field' => 'title',
                                                   'reverse' => false));

// Sort the programs
    if (count($All_Shows))
        sort_programs($All_Shows, 'recorded_sortby');

// How much free disk space on the backend machine?
    list($size_high, $size_low, $used_high, $used_low) = explode(backend_sep, backend_command('QUERY_FREE_SPACE'));
    define(disk_size, (($size_high + ($size_low < 0)) * 4294967296 + $size_low) * 1024);
    define(disk_used, (($used_high + ($used_low < 0)) * 4294967296 + $used_low) * 1024);

// Try to create a symlink to video_dir if it doesn't exist
    if (!file_exists(preg_replace('#/+$#', '', video_dir)) && $All_Shows[0] && $All_Shows[0]->filename)
        @symlink(dirname($All_Shows[0]->filename), video_dir);

// Load the class for this page
    require_once theme_dir.'recorded_programs.php';

// Create an instance of this page from its theme object
    $Page = new Theme_recorded_programs();

// Display the page
    $Page->print_page();

// Exit
    exit;

?>

