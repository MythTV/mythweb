<?php
/***                                                                        ***\
    recorded_programs.php                    Last Updated: 2004.03.07 (xris)

    view and manipulate recorded programs.
\***                                                                        ***/


// Initialize the script, database, etc.
    require_once "includes/init.php";
    require_once "includes/sorting.php";

// Delete a program?
    $_GET['delete'] or $_GET['delete'] = $_POST['delete'];
    $_GET['file']   or $_GET['file']   = $_POST['file'];
    if ($_GET['delete'] && preg_match('/\\d+_\\d+/', $_GET['file'])) {
    // We need to scan through the available recordings to get at the additional information required by the DELETE_RECORDING query
        foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $row) {
        // This row isn't the one we're looking for
            if ($row[8] != $_GET['file'])
                continue;
        // Delete the recording
            backend_command('DELETE_RECORDING' . backend_sep . implode(backend_sep, $row) . backend_sep . '0');
        // No need to scan the rest of the items, so leave early
            break;
        }
    // Redirect back to the page again, but without the query string, so reloads are cleaner
        header('Location: recorded_programs.php');
        exit;
    }

// Queries for a specific program title
    isset($_GET['title']) or $_GET['title']  = $_POST['title'];
    isset($_GET['title']) or $_GET['title']  = $_SESSION['recorded_title'];

// Parse the program list
    $recordings = get_backend_rows('QUERY_RECORDINGS Delete');
    $Total_Programs = 0;
    $All_Shows      = array();
    $Programs       = array();
    $Channels       = array();
    while (true) {
        $Program_Titles = array();
        foreach ($recordings as $key => $record) {
        // Skip the offset
            if ($key === 'offset')  // WHY IN THE WORLD DOES 0 == 'offset'?!?!?  so we use ===
                continue;
        // Skip programs the user doesn't want to look at, but keep track of their names and how many episodes we have recorded
            $Total_Programs++;
            $Program_Titles[$record[0]]++;
            if ($_GET['title'] && $_GET['title'] != $record[0])
                continue;
        // Create a new program object
            $show = new Program($record);
        // Make sure this is a valid show
            if (!$show->chanid || $show->length < 1)
                continue;
        // Make sure that everything we're dealing with is an array
            if (!is_array($Programs[$show->title]))
                $Programs[$show->title] = array();
            if (!is_array($Channels[$show->chanid]))
                $Channels[$show->chanid] = array();
        // Assign a reference to this show to the various arrays
            $All_Shows[]                 = &$show;
            $Programs[$show->title][]    = &$show;
            $Channels[$show->chanid][]   = &$show;
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
    list($disk_size, $disk_used) = explode(backend_sep, backend_command('QUERY_FREESPACE'));
    define(disk_size, $disk_size * 1024 * 1024);
    define(disk_used, $disk_used * 1024 * 1024);

// Try to create a symlink to video_dir if it doesn't exist
    if (!file_exists(video_dir) && $All_Shows[0] && $All_Shows[0]->filename)
        symlink(dirname($All_Shows[0]->filename), video_dir);

// Load the class for this page
    require_once theme_dir.'recorded_programs.php';

// Create an instance of this page from its theme object
    $Page = new Theme_recorded_programs();

// Display the page
    $Page->print_page();

// Exit
    exit;

?>

