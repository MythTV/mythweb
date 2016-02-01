<?php
/**
 * Program listing
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/


// Print the page title and load the header
    $page_title = 'MythWeb - '.t('Listings');
    require_once 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the header info specific to the program listing
?>
<p>
    <form class="form" action="<?php echo root_url ?>tv/list" method="get">
    <center>
        <br /><?php echo t('Currently Browsing:  $1', strftime($_SESSION['date_statusbar'], $list_starttime)) ?><br />
            <?php echo t('Jump to') ?><br />
            <select name="daytime"><?php
                $day=getdate($start_time);
                $start=$start_time - $day['hours'] * 60 * 60 - $day['minutes'] * 60;
                for ($t=0;$t<48;$t++) {
                    //echo "<option value=\"".($start + $t * 30 * 60)."\"";
                    echo "<option value=\"".date('Hi',$start + $t * 30 * 60)."\"";
                    if ($start+$t*30*60 <= $start_time && $start+($t+1)*30*60 > $start_time )
                        echo ' SELECTED';
                    echo '>'.date('g:i A',$start+$t*30*60).'</option>';
                }
                ?></select><br />
            <select name="date"><?php
            // Find out how many days into the future we should bother checking
                global $db;
                $sh = $db->query('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program')
                    or trigger_error('SQL Error: '.$db->error, FATAL);
                list($max_days) = $sh->fetch_row();
                $sh->finish();
            // Print out the list
                for ($i=-1;$i<=$max_days;$i++) {
                    $time = mktime(0,0,0, date('m'), date('d') + $i, date('Y'));
                    $date = date("Ymd", $time);
                    echo "<option value=\"$date\"";
                    if ($date == date("Ymd", $start_time)) echo " selected";
                    echo ">".date("D m/d/y" , $time)."</option>";
                }
                ?></select><br />
            <input type="submit" class="submit" value="<?php echo t('Jump') ?>">
            </center>
        </form>
        <br /><br />
<?php

//      $this->print_timeslots($Timeslots, $list_starttime, $list_endtime, 'first');

        // Go through each channel and load/print its info - use references to avoid "copy" overhead
        $channel_count = 0;
        $displayed_channels = array();
        $channels = Channel::getChannelList();
        foreach ($channels as $key) {
        // Ignore channels with no number
            if (strlen(Channel::find($key)->channum) < 1)
                continue;
        // Skip already-displayed channels
            if ($displayed_channels[Channel::find($key)->channum])
                continue;
            $displayed_channels[Channel::find($key)->channum] = 1;
        // Count this channel
            $channel_count++;
        // Grab the reference
            $channel =& Channel::find($key);
        // Print the data
            print_channel(&$channel, $list_starttime, $list_endtime);
        // Cleanup is a good thing
            unset($channel);
        // Display the timeslot bar?
//          if ($channel_count % timeslotbar_skip == 0)
//              $this->print_timeslots($Timeslots, $list_starttime, $list_endtime, $channel_count);
        }

    // Display the listing page footer
        require_once 'modules/_shared/tmpl/'.tmpl.'/footer.php';


    /*
        print_channel:

    */
    function print_channel($channel, $start_time, $end_time) {
        ?>
        <b><a href="<?php echo root_url ?>tv/channel/<?php echo $channel->chanid ?>/<?php echo date('Ymd', $start_time) ?>">
        <?php echo $_SESSION["prefer_channum"] ? $channel->channum : $chann->callsign ?>&nbsp;
        <?php echo $_SESSION["prefer_channum"] ? $channel->callsign : $channel->channum ?> </a></b>
        <a href="<?php echo root_url ?>tv/detail/<?php echo $channel->chanid ?>/<?php echo $channel->programs[0]->starttime ?>"><?php echo $channel->programs[0]->title ?></a><br />
        <?php
    }
