<?php
/**
 * Schedule a custom recording by manually specifying various search options
 *
 *
 * @package     MythWeb
 * @subpackage  TV
 *
 * http://www.gossamer-threads.com/lists/mythtv/dev/102890?search_string=keyword%20search;#102890
 *
/**/

// Path-based
    if ($Path[3])
        $_GET['recordid'] = $Path[3];

// Load an existing schedule?
    if ($_GET['recordid']) {
        $schedule =& Schedule::find($_GET['recordid']);
    // Not a custom search schedule
        if (empty($schedule->search) || $schedule->search == searchtype_manual)
            redirect_browser(root_url.'tv/schedules');
    }
// Create a new, empty schedule
    else
        $schedule = new Schedule(NULL);

// The user tried to update the recording settings - update the database and the variable in memory
    if (isset($_POST['save'])) {
    // Which type of recording is this?  Make sure an illegal one isn't specified
        $schedule->search_type = '';
        switch ($_POST['searchtype']) {
            case searchtype_power:   $schedule->search_type = 'Power';   break;
            case searchtype_title:   $schedule->search_type = 'Title';   break;
            case searchtype_keyword: $schedule->search_type = 'Keyword'; break;
            case searchtype_people:  $schedule->search_type = 'People';  break;
                break;
        // Everything else generates an error message
            default:
                trigger_error('Unknown search type specified:  '.$_POST['searchtype']);
        }
    // Which type of recording is this?  Make sure an illegal one isn't specified
        switch ($_POST['record']) {
        // Only certain rectypes are allowed
            case rectype_findone:
            case rectype_always:
            case rectype_daily:
            case rectype_weekly:
                break;
        // Everything else gets ignored
            default:
                $_POST['record'] = 0;
        }
    // Cancelling a schedule?
        if ($_POST['record'] == 0) {
        // Cancel this schedule
            if ($schedule && $schedule->recordid) {
            // Delete the schedule
                $schedule->delete();
            // Redirect back to the schedule list
                add_warning(t('The requested recording schedule has been deleted.'));
                save_session_errors();
                header('Location: '.root_url.'tv/schedules');
                exit;
            }
        }
    // Adding a new schedule
        else {
        // Set things as the user requested
            $schedule->profile       = $_POST['profile'];
            $schedule->recgroup      = $_POST['recgroup'];
            $schedule->storagegroup  = $_POST['storagegroup'];
            $schedule->playgroup     = $_POST['playgroup'];
            $schedule->autoexpire    = $_POST['autoexpire']   ? 1 : 0;
            $schedule->autocommflag  = $_POST['autocommflag'] ? 1 : 0;
            $schedule->autouserjob1  = $_POST['autouserjob1'] ? 1 : 0;
            $schedule->autouserjob2  = $_POST['autouserjob2'] ? 1 : 0;
            $schedule->autouserjob3  = $_POST['autouserjob3'] ? 1 : 0;
            $schedule->autouserjob4  = $_POST['autouserjob4'] ? 1 : 0;
            $schedule->autometadata  = $_POST['autometadata'] ? 1 : 0;
            $schedule->inactive      = $_POST['inactive']     ? 1 : 0;
            $schedule->maxnewest     = $_POST['maxnewest']    ? 1 : 0;
            $schedule->dupin         = _or($_POST['dupin'] + $_POST['dupin2'], dupsin_all);
            $schedule->dupmethod     = _or($_POST['dupmethod'], 6);
            $schedule->recpriority   = intval($_POST['recpriority']);
            $schedule->maxepisodes   = intval($_POST['maxepisodes']);
            $schedule->startoffset   = intval($_POST['startoffset']);
            $schedule->endoffset     = intval($_POST['endoffset']);
            $schedule->prefinput     = $_POST['prefinput'];
        // Some settings specific to manual recordings (since we have no program to match against)
            $schedule->chanid        = $_POST['channel'];
            $schedule->station       = Channel::find($schedule->chanid)->callsign;
            $schedule->starttime     = time();
            $schedule->endtime       = time() + 1;
            $schedule->category      = 'Custom recording';
            $schedule->search        = $_POST['searchtype'];
            $schedule->findday       = $_POST['findday'];
            $schedule->autotranscode = $_POST['autotranscode'] ? 1 : 0;
            $schedule->transcoder    = $_POST['transcoder'];
        // Parse the findtime
            $schedule->findtime      = trim($_POST['findtime']);
            if ($schedule->findtime) {
                if (!preg_match('/^\d{1,2}:\d{2}:\d{2}$/', $schedule->findtime))
                    add_error(t('Find Time must be of the format:  HH:MM:SS'));
            }
            else
                $schedule->findtime = date('H:m:s', $schedule->starttime);
        // Build the special description
            if ($schedule->search == searchtype_power) {
            // Remove any trailing semi colons, and any secondary hackish queries
                $schedule->description = preg_replace('/\s*;\s*(EXPLAIN|DESCRIBE|SHOW|SELECT|DELETE|UPDATE|INSERT|REPLACE).*$/i', '',
                                         preg_replace('/;$/', '',
                                                      $_POST['search_sql']
                                                     ));
            // The subtitle is actually used to store additional SQL tables
                if (preg_match('/\w/', $_POST['additional_tables']))
                    $schedule->subtitle = preg_replace('/^\W*/', ', ',
                                          preg_replace('/\W+$/', '',
                                                       $_POST['additional_tables']
                                                      ));
            // Quick fix for LEFT JOINs to be syntaxly correct
                $schedule->subtitle = str_replace(', LEFT JOIN', ' LEFT JOIN', $schedule->subtitle);
            // Run a test query
                $db->disable_fatal_errors();
                $sh = $db->query('SELECT NULL FROM program, channel'.str_replace('?', '\\?', $schedule->subtitle)
                                .' WHERE '.str_replace('?', '\\?', $schedule->description));
                $db->enable_fatal_errors();
                if ($db->error) {
                    add_error("There is an error in your custom SQL query:\n\n"
                              .preg_replace('/^.+?SQL\s+syntax;\s*/', '', $db->error)
                             );
                }
            }
            else {
                $schedule->description = _or($_POST['search_phrase'], $_POST['title']);
                $schedule->subtitle    = '';
            }
        // Figure out the title
            $schedule->title = _or($_POST['title'], $schedule->description).' ('.t('$1 Search', $schedule->search_type).')';
        // Only save if there are no errors
            if (!errors()) {
            // Save the schedule
                $schedule->save($_POST['record']);
            // Redirect to the new schedule
                header('Location: '.root_url.'tv/schedules/custom/'.$schedule->recordid);
                exit;
            }
        }
    }
// Set some defaults
    else {
    // Make sure we have a default rectype
        if (!$schedule->type)
            $schedule->type = rectype_always;
    // Get the searchtype string
        switch ($schedule->search) {
            case searchtype_power:   $schedule->search_type = t('Power');   break;
            case searchtype_keyword: $schedule->search_type = t('Keyword'); break;
            case searchtype_people:  $schedule->search_type = t('People');  break;
            case searchtype_title:
            default:                 $schedule->search_type = t('Title');   break;
        }
    // Load default values from Default recording rule template
        $schedule->merge(Schedule::recording_template('Default'));
    }

// Create an edit-friendly title
    $schedule->edit_title = preg_replace('/\s*\(\w+\s*'.t('Search').'\)\s*$/i', '', $schedule->title);

// Calculate the length
    $schedule->length = intval(($schedule->endtime - $schedule->starttime) / 60);
    if ($schedule->length < 1)
        $schedule->length = 120;

// Load the utility/display functions for scheduling
    require_once 'includes/schedule_utils.php';

// Load the class for this page
    require_once tmpl_dir.'schedules_custom.php';

// Exit
    exit;

/**
 * Prints a <select> of the available program categories
/**/
    function category_select() {
        echo '<select name="channel"><option value=""';
        if (empty($chanid))
            echo ' SELECTED';
        echo '>('.t('Any Category').')</option>';
        echo '</select>';
    }

/**
 * Prints a <select> of the available program category_types
/**/
    function category_type_select() {
        echo '<select name="channel"><option value=""';
        if (empty($chanid))
            echo ' SELECTED';
        echo '>('.t('Any Program Type').')</option>';
        echo '</select>';
    }

/**
 * prints a <select> of the available channels
/**/
    function channel_select($chanid) {
        $Channel_list = Channel::getChannelList();
        echo '<select name="channel"><option value=""';
        if (empty($chanid))
            echo ' SELECTED';
        echo '>('.t('Any Channel').')</option>';
        foreach ($Channel_list as $chanid) {
            $channel =& Channel::find($chanid);

        // Print the option
            echo '<option value="', $channel->chanid, '"',
                 ' title="', html_entities($channel->name), '"';
        // Selected?
            if ($channel->chanid == $chanid)
                echo ' SELECTED';
        // Print the rest of the content
            echo '>';
            if ($_SESSION["prefer_channum"])
                echo $channel->channum.'&nbsp;&nbsp;('.html_entities($channel->callsign).')';
            else
                echo html_entities($channel->callsign).'&nbsp;&nbsp;('.$channel->channum.')';
            echo '</option>';
        }
        echo '</select>';
    }

/**
 * Prints a <select> of the various weekdays
/**/
    function day_select($day, $name='findday') {
        $days = array(t('Sunday'),    t('Monday'),   t('Tuesday'),
                             t('Wednesday'), t('Thursday'), t('Friday'),
                             t('Saturday'));
    // Print the list
        echo "<select name=\"$name\">";
        foreach ($days as $key => $day) {
            $key++;
            echo "<option value=\"$key\"";
            if ($key == $day)
                echo ' SELECTED';
            echo '>'.html_entities($day).'</option>';
        }
        echo '</select>';
    }
