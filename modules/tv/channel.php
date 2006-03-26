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
        if (!$_GET['time'])
            $_GET['time'] = $Path[3];
    }

// Chanid?
    $_GET['chanid'] or $_GET['chanid'] = $_POST['chanid'];
    $this_channel =& load_one_channel($_GET['chanid']);

// No channel found
    if (!$_GET['chanid'] || !$this_channel->chanid) {
        header('Location: '.root.'tv/list?time='.$_SESSION['list_time']);
        exit;
    }

// New list time?
    $_GET['time'] or $_GET['time'] = $_POST['time'];
    if ($_GET['time'])
        $_SESSION['list_time'] = $_GET['time'];

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
 * Prints a <select> of the available date range
/**/
    function date_select() {
    // Get the available date range
        $result = mysql_query('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program')
            or trigger_error('SQL Error: '.mysql_error(), FATAL);
        list($max_days) = mysql_fetch_row($result);
        mysql_free_result($result);
    // Print out the list
        echo '<select name="time" onchange="submit_form()">';
        for ($i=-1; $i<=$max_days; $i++) {
            $time = mktime(0,0,0, date('m'), date('d') + $i, date('Y'));
            $date = date('Ymd', $time);
            echo "<option value=\"$time\"";
            if ($date == date("Ymd", $_SESSION['list_time']))
                echo " selected";
            echo '>'.strftime($_SESSION['date_channel_jump'] , $time).'</option>';
        }
    }

