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
    if ($_GET['date']) {
        if (strlen($_GET['date']) == 8)
            $_GET['date'] = unixtime(sprintf('%08d000000', $_GET['date']));
        $_SESSION['list_time'] = $_GET['date'];
    }

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
    function channel_select($params = '') {
        global $Channels;
        echo "<select name=\"chanid\" $params>";
        foreach ($Channels as $channel) {
        // Not visible?
            if (empty($channel->visible))
                continue;
        // Print the option
            echo '<option value="', $channel->chanid, '"',
                 ' title="', html_entities($channel->name), '"';
        // Selected?
            if ($channel->chanid == $_GET['chanid'])
                echo ' SELECTED';
        // Print ther est of the content
            echo '>';
            if (prefer_channum)
                echo $channel->channum.'&nbsp;&nbsp;('.html_entities($channel->callsign).')';
            else
                echo html_entities($channel->callsign).'&nbsp;&nbsp;('.$channel->channum.')';
            echo '</option>';
        }
        echo '</select>';
    }

/**
 * Prints a <select> of the available date range
 * Reused *almost* verbatim from modules/tv/list.php
/**/
    function date_select($params = '') {
        global $db;
    // Get the available date range
        $min_days = max(-7, $db->query_col('SELECT TO_DAYS(min(starttime)) - TO_DAYS(NOW()) FROM program'));
        $max_days = min(30, $db->query_col('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program'));
    // Print out the list
        echo "<select name=\"date\" $params>";
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

