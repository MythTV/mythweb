<?php
/***                                                                        ***\
    channel_detail.php                       Last Updated: 2005.02.28 (xris)


\***                                                                        ***/

// Which section are we in?
    define('section', 'tv');

// Initialize the script, database, etc.
    require_once "includes/init.php";

// Load all channels
    load_all_channels();

// Chanid?
    $_GET['chanid'] or $_GET['chanid'] = $_POST['chanid'];
    $this_channel =& load_one_channel($_GET['chanid']);

// No channel found
    if (!$_GET['chanid'] || !$this_channel->chanid) {
        header('Location: program_listing.php?time='.$_SESSION['list_time']);
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
    require_once theme_dir.'channel_detail.php';

// Create an instance of this page from its theme object
    $Page = new Theme_channel_detail();

// Display the page
    $Page->print_page($this_channel);

// Exit
    exit;


/*
    channel_select:
    Prints a <select> of the available channels
*/
    function channel_select() {
        global $Channels;
        echo '<select name="chanid" onchange="submit_form()">';
        foreach ($Channels as $channel) {
            echo '<option value="'.htmlentities($channel->chanid).'"';
            if ($channel->chanid == $_GET['chanid'])
                echo ' SELECTED';
            $name = prefer_channum
                        ? "$channel->channum ($channel->callsign)"
                        : "$channel->callsign ($channel->channum)";
            echo '>'.htmlentities($name).'</option>';
        }
        echo '</select>';
    }

/*
    date_select:
    Prints a <select> of the available date range
*/
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
?>
