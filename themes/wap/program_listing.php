<?php
/***                                                                        ***\
    program_listing.php                      Last Updated: 2003.08.19 (xris)

    This file defines a theme class for the program listing section.
    It must define several methods, some of which have specific
    parameters.   documentation will be added someday.
\***                                                                        ***/


#class theme_program_listing extends Theme {
class Theme_program_listing extends Theme {

    /*
        print_header:
        This function prints the header portion of the page specific to the program listing
    */
    function print_header($start_time, $end_time) {
    // Print the main page header
        parent::print_header('MythWeb - Program Listing:  '.strftime('%B %e, %Y, %I:%M %p', $start_time));
    // Print the header info specific to the program listing
?>
<p>
    <form class="form" action="program_listing.php" method="get">
    <center>
    Currently Browsing<br /><?php echo date('D m/d/y', $start_time) ?><br />
    <?php echo date('g:i A', $start_time) ?><br />
            Jump to<br />
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
                $result = mysql_query('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program')
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);
                list($max_days) = mysql_fetch_row($result);
                mysql_free_result($result);
            // Print out the list
                for ($i=-1;$i<=$max_days;$i++) {
                    $time = mktime(0,0,0, date('m'), date('d') + $i, date('Y'));
                    $date = date("Ymd", $time);
                    echo "<option value=\"$date\"";
                    if ($date == date("Ymd", $start_time)) echo " selected";
                    echo ">".date("D m/d/y" , $time)."</option>";
                }
                ?></select><br />
            <input type="submit" class="submit" value="Jump">
            </center>
        </form>
        <br /><br />
<?php
    }


    function print_page(&$Channels, &$Timeslots, $list_starttime, $list_endtime) {
    // Display the listing page header
        $this->print_header($list_starttime, $list_endtime);

//      $this->print_timeslots($Timeslots, $list_starttime, $list_endtime, 'first');

        // Go through each channel and load/print its info - use references to avoid "copy" overhead
        $channel_count = 0;
        foreach (array_keys($Channels) as $key) {
        // Ignore channels with no number
            if (strlen($Channels[$key]->channum) < 1)
                continue;
        // Count this channel
            $channel_count++;
        // Grab the reference
            $channel = &$Channels[$key];
        // Print the data
            $this->print_channel(&$channel, $list_starttime, $list_endtime);
        // Cleanup is a good thing
            unset($channel);
        // Display the timeslot bar?
//          if ($channel_count % timeslotbar_skip == 0)
//              $this->print_timeslots($Timeslots, $list_starttime, $list_endtime, $channel_count);
        }

    // Display the listing page footer
        $this->print_footer();
    }


    /*
        print_footer:
        This function prints the footer portion of the page specific to the program listing
    */
    function print_footer() {
    // Print the main page's footer
        parent::print_footer();
    }


    /*
        print_channel:

    */
    function print_channel($channel, $start_time, $end_time) {
        ?>
        <a href="channel_detail.php?chanid=<?php echo $channel->chanid ?>&time=<?php echo $start_time ?>">
        <?php echo prefer_channum ? $channel->channum : $chann->callsign ?>&nbsp;
        <?php echo prefer_channum ? $channel->callsign : $channel->channum ?> </a>
    	<a href="program_detail.php?chanid=<?php echo $channel->chanid ?>&starttime=<?php echo $channel->programs[0]->starttime ?>"><?php echo $channel->programs[0]->title ?></a><br />
        <?php
    }


}

