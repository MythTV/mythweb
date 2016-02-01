<?php
/**
 * view and manipulate recorded programs.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

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
        foreach (MythBackend::find()->queryProgramRows('QUERY_RECORDINGS Unsorted') as $row) {
        // increment if row has the same title as the show we're deleting or if viewing 'all recordings'
            if (($_SESSION['recorded_title'] == $row[0]) || ($_SESSION['recorded_title'] == ''))
                $prev_row++;
        // This row isn't the one we're looking for
            if ($row[7] != $_REQUEST['chanid'] || $row[26] != $_REQUEST['starttime'])
                continue;
        // Delete the recording
            MythBackend::find()->sendCommand(array($backendstr, implode(MythBackend::$backend_separator, $row), '0'));
        // Forget all knowledge of old recordings?
            if ($_REQUEST['forget_old']) {
                MythBackend::find()->sendCommand(array('FORGET_RECORDING', implode(MythBackend::$backend_separator, $row), '0'));
                MythBackend::find()->listenForEvent('SCHEDULE_CHANGE');
            }
        // Exit early if we're in AJAX mode.
            if (isset($_REQUEST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode(array('id'   => $_REQUEST['id'],
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
        redirect_browser(root_url.'tv/recorded?refresh'.($prev_row > 0 ? "#$prev_row" : ''));
    // redirect_browser calls exit() on its own
    }

// Queries for a specific program title
    isset($_REQUEST['title'])    or $_REQUEST['title']    = isset($_REQUEST['refresh']) ? '' : $_SESSION['recorded_title'];
    isset($_REQUEST['recgroup']) or $_REQUEST['recgroup'] = isset($_REQUEST['refresh']) ? '' : $_SESSION['recorded_recgroup'];

// Parse the program list
    $warning    = NULL;
    $recordings = MythBackend::find()->queryProgramRows('QUERY_RECORDINGS Unsorted');
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
        // Keep track of the total time and disk space used (9 == filesize)
            $Total_Time += $length;
            if (function_exists('gmp_add')) {
            // GMP functions should work better with 64 bit numbers.
                $Total_Used = gmp_strval(gmp_add($Total_Used, $record[12]));
            }
            else {
            // This is inaccurate, but it's the best we can get without GMP.
                $Total_Used += $record[12];
            }
        // keep track of their names and how many episodes we have recorded
            $Total_Programs++;
            $Groups[$record[29]]++;
        // Hide LiveTV  and Deleted recordings from the title list
            if (($_REQUEST['recgroup'] && $_REQUEST['recgroup'] == $record[29]) || (!$_REQUEST['recgroup'] && $record[29] != 'LiveTV' && $record[29] != 'Deleted'))
                $Program_Titles[$record[0]]++;
        // Skip files with no chanid
            if (!$record[7])
                continue;
        // Skip programs the user doesn't want to look at
            if ($_REQUEST['title'] && $_REQUEST['title'] != $record[0])
                continue;
            if ($_REQUEST['recgroup'] && $_REQUEST['recgroup'] != $record[29])
                continue;
        // Hide LiveTV recordings from the default view
            if (empty($_REQUEST['recgroup']) && ($record[29] == 'LiveTV' || $record[29] == 'Deleted'))
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
                unset($_SESSION['recorded_title']);
                continue;
            }
        // Catch anything else
            $_REQUEST['refresh'] = true;
            $warning         = t('Showing all programs.');
            unset($_REQUEST['title'], $_REQUEST['recgroup']);
            unset($_SESSION['recorded_title'], $_SESSION['recorded_recgroup']);
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
            $show = new Program($record);
        // Assign a reference to this show to the various arrays
            $All_Shows[]                                =& $show;
            $Programs[$title][$key]                     =& $show;
            $channel = &Channel::find($show->chanid);
            $channel->programs[]                        =& $show;
            unset($show);
        }
    }

// Sort the program titles
    uksort($Program_Titles, 'by_no_articles');
    ksort($Groups);

// Keep track of the program/title the user wants to view
    if (isset($_REQUEST['title']))
        $_SESSION['recorded_title']    = $_REQUEST['title'];
    if (isset($_REQUEST['recgroup']))
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
    list($size, $used) = MythBackend::find()->sendCommand('QUERY_FREE_SPACE_SUMMARY');
    if (function_exists('gmp_mul')) {
    // GMP functions should work better with 64 bit numbers.
        $size = gmp_mul('1024', $size);
        define(disk_size, gmp_strval($size));
        $size = gmp_mul('1024', $used);
        define(disk_used, gmp_strval($size));
    }
    else {
    // This is inaccurate, but it's the best we can get without GMP.
        define(disk_size, ($size * 1024));
        define(disk_used, ($used * 1024));
    }

// Load the class for this page
    require_once tmpl_dir.'recorded.php';

// Exit
    exit;
