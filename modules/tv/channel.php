<?php
/**
 * Show the current lineup for a specific channel
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

// Load all channels
    load_all_channels();

// Path-based
    if ($Path[2]) {
        $_GET['chanid'] = $Path[2];
        if (!$_GET['date'])
            $_GET['date'] = $Path[3];
    }

// Chanid?
    $_GET['chanid'] or $_GET['chanid'] = $_POST['chanid'];
    $this_channel =& load_one_channel($_GET['chanid']);

// No channel found
    if (!$_GET['chanid'] || !$this_channel->chanid) {
        header('Location: '.root.'tv/list?time='.$_SESSION['list_time']);
        exit;
    }

// New list date?
    $_GET['date'] or $_GET['date'] = $_POST['date'];
    if ($_GET['date'])
        $_SESSION['list_time'] = unixtime(sprintf('%08d000000', $_GET['date']));

// Load the programs for today
    $this_channel->programs = load_all_program_data(mktime(0, 0, 0, date('n', $_SESSION['list_time']), date('j', $_SESSION['list_time']), date('Y', $_SESSION['list_time'])),
                                                    mktime(0, 0, 0, date('n', $_SESSION['list_time']), date('j', $_SESSION['list_time']) + 1, date('Y', $_SESSION['list_time'])),
                                                    $this_channel->chanid);

// Load the class for this page
    require_once tmpl_dir.'channel.php';

// Exit
    exit;


/**
 * Prints a <select> of the available channels
/**/
    function channel_select() {
        global $Channels;
        echo '<select name="chanid" onchange="submit_form()">';
        foreach ($Channels as $channel) {
        // Not visible?
            if (empty($channel->visible))
                continue;
        // Print the option
            echo '<option value="'.html_entities($channel->chanid).'"';
            if ($channel->chanid == $_GET['chanid'])
                echo ' SELECTED';
            $name = prefer_channum
                        ? "$channel->channum ($channel->callsign)"
                        : "$channel->callsign ($channel->channum)";
            echo '>'.html_entities($name).'</option>';
        }
        echo '</select>';
    }

/**
 * Prints a <select> of the available date range.
 * reused almost verbatim from modules/tv/list.php
/**/
    function date_select() {
        global $db;
    // Get the available date range
        $min_days = $db->query_col('SELECT TO_DAYS(min(starttime)) - TO_DAYS(NOW()) FROM program');
        $max_days = $db->query_col('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program');
    // Print out the list
        echo '<select name="date" onchange="get_element(\'program_listing\').submit()">';
        for ($i=$min_days; $i<=$max_days; $i++) {
            $time = mktime(0,0,0, date('m'), date('d') + $i, date('Y'));
            $date = date('Ymd', $time);
            echo "<option value=\"$date\"";
            if ($date == date('Ymd', $_SESSION['list_time']))
                echo ' SELECTED';
            echo '>'.strftime($_SESSION['date_channel_jump'] , $time).'</option>';
        }
        echo '</select>';
    }

