<?php
/**
 * view and manipulate recorded programs.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Populate the $Channels array
    load_all_channels();

// Load the sorting routines
    require_once 'includes/sorting.php';

// Delete or undelete a program?
    isset($_GET['forget_old']) or $_GET['forget_old'] = $_POST['forget_old'];
    isset($_GET['delete'])     or $_GET['delete']     = $_POST['delete'];
    isset($_GET['file'])       or $_GET['file']       = $_POST['file'];
    if ($_GET['delete'] || $_GET['undelete']) {
        if ($_GET['delete'])
          $backendstr = 'DELETE_RECORDING';
        else 
          $backendstr = 'UNDELETE_RECORDING';
    // Keep a previous-row counter to return to after deleting
        $prev_row = -2;
    // We need to scan through the available recordings to get at the additional information required by the DELETE_RECORDING query
        foreach (get_backend_rows('QUERY_RECORDINGS Delete') as $row) {
        // increment if row has the same title as the show we're deleting or if viewing 'all recordings'
            if (($_SESSION['recorded_title'] == $row[0]) || ($_SESSION['recorded_title'] == ''))
                $prev_row++;
        // This row isn't the one we're looking for
            if ($row[4] != $_GET['chanid'] || $row[26] != $_GET['starttime'])
                continue;
        // Delete the recording
            backend_command(array($backendstr, implode(backend_sep, $row), '0'));
        // Forget all knowledge of old recordings?
            if (isset($_GET['forget_old'])) {
                backend_command(array('FORGET_RECORDING', implode(backend_sep, $row), '0'));
            // Delay a second so the scheduler can catch up
                sleep(1);
            }
        // Exit early if we're in AJAX mode.
            if (isset($_GET['ajax'])) {
                echo 'success';
                exit;
            }
        // No need to scan the rest of the items, so leave early
            break;
        }
    // Redirect back to the page again, but without the query string, so reloads are cleaner
    // WML browser often require a fully qualified URL for redirects to work. Also, set content type
        if ($_SESSION['Theme'] == 'wml') {
            header('Content-type: text/vnd.wap.wml');
            redirect_browser('http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?refresh');
        }
    // Return to the row just prior to the one deleted
    //  (with some fuzz to account for normal screen height
    //   -- remember that rows are numbered starting at zero)
        else {
            redirect_browser(root.'tv/recorded?refresh'.($prev_row > 0 ? "#$prev_row" : ''));
        }
    // redirect_browser calls exit() on its own
    }

// Queries for a specific program title
    isset($_GET['title'])    or $_GET['title']    = $_POST['title'];
    isset($_GET['recgroup']) or $_GET['recgroup'] = $_POST['recgroup'];
    isset($_GET['title'])    or $_GET['title']    = isset($_GET['refresh']) ? '' : $_SESSION['recorded_title'];
    isset($_GET['recgroup']) or $_GET['recgroup'] = isset($_GET['refresh']) ? '' : $_SESSION['recorded_recgroup'];

// Parse the program list
    $warning    = NULL;
    $recordings = get_backend_rows('QUERY_RECORDINGS Delete');
    while (true) {
        $Total_Used     = 0;
        $Total_Time     = 0;
        $Total_Programs = 0;
        $Programs       = array();
        $Groups         = array();
        $Program_Titles = array();
        foreach ($recordings as $key => $record) {
        // Skip the offset
            if ($key === 'offset')  // WHY IN THE WORLD DOES 0 == 'offset'?!?!?  so we use ===
                continue;
        // Get the length (27 == recendts; 26 == recstartts)
            $length = $record[27] - $record[26];
        // Keep track of the total time and disk space used (9 == fs_high; 10 == fs_low)
            $Total_Time += $length;
            if (function_exists('gmp_add')) {
            // GMP functions should work better with 64 bit numbers.
                $size = gmp_add($record[10],
                                gmp_mul('4294967296',
                                        gmp_add($record[9], $record[10] < 0 ? '1' : '0')
                                       )
                               );
                $Total_Used = gmp_strval(gmp_add($Total_Used, $size));
            }
            else {
            // This is inaccurate, but it's the best we can get without GMP.
                $Total_Used += ($record[9] + ($record[10] < 0)) * 4294967296 + $record[10];
            }
        // keep track of their names and how many episodes we have recorded
            $Total_Programs++;
            $Groups[$record[30]]++;
        // Hide LiveTV  and Deleted recordings from the title list
            if (($_GET['recgroup'] && $_GET['recgroup'] == $record[30]) || (!$_GET['recgroup'] && $record[30] != 'LiveTV' && $record[30] != 'Deleted'))
                $Program_Titles[$record[0]]++;
        // Skip files with no chanid
            if (!$record[4])
                continue;
        // Skip programs the user doesn't want to look at
            if ($_GET['title'] && $_GET['title'] != $record[0])
                continue;
            if ($_GET['recgroup'] && $_GET['recgroup'] != $record[30])
                continue;
        // Hide LiveTV recordings from the default view
            if (empty($_GET['recgroup']) && ($record[30] == 'LiveTV' || $record[30] == 'Deleted'))
                continue;
        // Make sure that everything we're dealing with is an array
            if (!is_array($Programs[$record[0]]))
                $Programs[$record[0]] = array();
        // Assign a reference to this show to the various arrays
            $Programs[$record[0]][] = $record;
        }
    // Did we try to view a program that we don't have recorded?  Revert to showing all programs
        if ($Total_Programs > 0 && !count($Programs) && !isset($_GET['refresh'])) {
        // Requested the "All" mode, but there are no recordings
            if (empty($_GET['title']) && empty($_GET['recgroup'])) {
                if ($Groups['LiveTV'] > 0) {
                    $warning = t('Showing all programs from the $1 group.', 'LiveTV');
                    $_GET['recgroup'] = 'LiveTV';
                    continue;
                }
            }
        // Requested a title that's not in the requested group
            if ($_GET['recgroup'] && $_GET['title'] && $Groups[$_GET['recgroup']] > 0) {
                $warning = t('Showing all programs from the $1 group.', $_GET['recgroup']);
                unset($_GET['title']);
                continue;
            }
        // Catch anything else
            $_GET['refresh'] = true;
            $warning         = t('Showing all programs.');
            unset($_GET['title'], $_GET['recgroup']);
            continue;
        }
    // Did the best we could to find some programs; let's move on.
        break;
    }

// Warning?
    if (!empty($warning))
        add_warning(t('No matching programs found.')."\n".$warning);

// Now that we've selected only certain shows, load them into objects
    $All_Shows = array();
    foreach ($Programs as $title => $shows) {
        foreach ($shows as $key => $record) {
        // Create a new program object
            $show =& new Program($record);
        // Assign a reference to this show to the various arrays
            $All_Shows[]                         =& $show;
            $Programs[$title][$key]              =& $show;
            $Channels[$show->chanid]->programs[] =& $show;
            unset($show);
        }
    }

// Sort the program titles
    uksort($Program_Titles, 'by_no_articles');
    ksort($Groups);

// Keep track of the program/title the user wants to view
    $_SESSION['recorded_title']    = $_GET['title'];
    $_SESSION['recorded_recgroup'] = $_GET['recgroup'];

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
    list($size_high, $size_low, $used_high, $used_low) = explode(backend_sep, backend_command('QUERY_FREE_SPACE_SUMMARY'));
    if (function_exists('gmp_add')) {
    // GMP functions should work better with 64 bit numbers.
        $size = gmp_mul('1024',
                        gmp_add($size_low,
                                gmp_mul('4294967296',
                                        gmp_add($size_high, $size_low < 0 ? '1' : '0'))
                               )
                       );
        define(disk_size, gmp_strval($size));
        $size = gmp_mul('1024',
                        gmp_add($used_low,
                                gmp_mul('4294967296',
                                        gmp_add($used_high, $used_low < 0 ? '1' : '0'))
                               )
                       );
        define(disk_used, gmp_strval($size));
    }
    else {
    // This is inaccurate, but it's the best we can get without GMP.
        define(disk_size, (($size_high + ($size_low < 0)) * 4294967296 + $size_low) * 1024);
        define(disk_used, (($used_high + ($used_low < 0)) * 4294967296 + $used_low) * 1024);
    }

// Load the class for this page
    require_once tmpl_dir.'recorded.php';

// Exit
    exit;

