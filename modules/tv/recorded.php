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
    if ($_REQUEST['delete'] || $_REQUEST['undelete']) {
        if ($_REQUEST['delete'])
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
            if ($row[4] != $_REQUEST['chanid'] || $row[26] != $_REQUEST['starttime'])
                continue;
        // Delete the recording
            backend_command(array($backendstr, implode(backend_sep, $row), '0'));
        // Forget all knowledge of old recordings?
            if ($_REQUEST['forget_old']) {
                backend_command(array('FORGET_RECORDING', implode(backend_sep, $row), '0'));
            // Delay a second so the scheduler can catch up
                sleep(1);
            }
        // Exit early if we're in AJAX mode.
            if (isset($_REQUEST['ajax'])) {
                header('Content-Type: application/json');
                echo JSON::encode(array('id'   => $_REQUEST['id'],
                                        'file' => $_REQUEST['file']));
                exit;
            }
        // No need to scan the rest of the items, so leave early
            break;
        }
    // Redirect back to the page again, but without the query string, so reloads are cleaner
    // Return to the row just prior to the one deleted
    //  (with some fuzz to account for normal screen height
    //   -- remember that rows are numbered starting at zero)
        redirect_browser(root.'tv/recorded?refresh'.($prev_row > 0 ? "#$prev_row" : ''));
    // redirect_browser calls exit() on its own
    }

// Queries for a specific program title
    isset($_REQUEST['title'])    or $_REQUEST['title']    = isset($_REQUEST['refresh']) ? '' : $_SESSION['recorded_title'];
    isset($_REQUEST['recgroup']) or $_REQUEST['recgroup'] = isset($_REQUEST['refresh']) ? '' : $_SESSION['recorded_recgroup'];

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
            if (($_REQUEST['recgroup'] && $_REQUEST['recgroup'] == $record[30]) || (!$_REQUEST['recgroup'] && $record[30] != 'LiveTV' && $record[30] != 'Deleted'))
                $Program_Titles[$record[0]]++;
        // Skip files with no chanid
            if (!$record[4])
                continue;
        // Skip programs the user doesn't want to look at
            if ($_REQUEST['title'] && $_REQUEST['title'] != $record[0])
                continue;
            if ($_REQUEST['recgroup'] && $_REQUEST['recgroup'] != $record[30])
                continue;
        // Hide LiveTV recordings from the default view
            if (empty($_REQUEST['recgroup']) && ($record[30] == 'LiveTV' || $record[30] == 'Deleted'))
                continue;
        // Make sure that everything we're dealing with is an array
            if (!is_array($Programs[$record[0]]))
                $Programs[$record[0]] = array();
        // Assign a reference to this show to the various arrays
            $Programs[$record[0]][] = $record;
        }
    // Did we try to view a program that we don't have recorded?  Revert to showing all programs
        if ($Total_Programs > 0 && !count($Programs) && !isset($_REQUEST['refresh'])) {
        // Requested the "All" mode, but there are no recordings
            if (empty($_REQUEST['title']) && empty($_REQUEST['recgroup'])) {
                if ($Groups['LiveTV'] > 0) {
                    $warning = t('Showing all programs from the $1 group.', 'LiveTV');
                    $_REQUEST['recgroup'] = 'LiveTV';
                    continue;
                }
            }
        // Requested a title that's not in the requested group
            if ($_REQUEST['recgroup'] && $_REQUEST['title'] && $Groups[$_REQUEST['recgroup']] > 0) {
                $warning = t('Showing all programs from the $1 group.', $_REQUEST['recgroup']);
                unset($_REQUEST['title']);
                continue;
            }
        // Catch anything else
            $_REQUEST['refresh'] = true;
            $warning         = t('Showing all programs.');
            unset($_REQUEST['title'], $_REQUEST['recgroup']);
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
    $_SESSION['recorded_title']    = $_REQUEST['title'];
    $_SESSION['recorded_recgroup'] = $_REQUEST['recgroup'];

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
