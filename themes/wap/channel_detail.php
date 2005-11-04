<?php
/***                                                                        ***\
    channel_detail.php                        Last Updated: 2003.07.23 (xris)

    This file defines a theme class for the channel detail section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_channel_detail extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header('MythWeb - Channel Detail');
    // Print out some header info about this channel and time
        global $this_channel;
?>
<p>
            <form id="form" action="channel_detail.php?chanid=<?php echo $_GET['chanid'] ?>" method="post">
            <center>
            Channel <?php echo $this_channel->channum ?> <?php echo $this_channel->callsign ?><br />
            <?php echo date('D m/d/y', $_SESSION['list_time']) ?><br />

            Jump to<br />
            <select name="time""><?php
            // Find out how many days into the future we should bother checking
                $result = mysql_query('SELECT TO_DAYS(max(starttime)) - TO_DAYS(NOW()) FROM program')
                    or trigger_error('SQL Error: '.mysql_error(), FATAL);
                list($max_days) = mysql_fetch_row($result);
                mysql_free_result($result);
            // Print out the list
                for ($i=-1;$i<=$max_days;$i++) {
                    $time = mktime(0,0,0, date('m'), date('d') + $i, date('Y'));
                    $date = date("Ymd", $time);
                    echo "<option value=\"$time\"";
                    if ($date == date("Ymd", $_SESSION['list_time'])) echo " selected";
                    echo ">".date("D m/d/y" , $time)."</option>";
                }
                ?></select><br />
                <input type="submit" class="submit" value="Jump"><br /><br />
            </center>
            </form>
</p>
<?php
    // Print the shows for today
        $this->print_shows();
    // Print the main page footer
        parent::print_footer();
    }

    function print_shows() {
        global $this_channel;
    // No search was performed, just return
        if (!is_array($this_channel->programs))
            return;
    // Display the results
        $row = 0;
        foreach ($this_channel->programs as $show) {
    // Print the content
    ?>
    <?php echo date('g:i A', $show->starttime) ?> - <?php echo date('g:i A', $show->endtime) ?><br />
<?php
        echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'.$show->title.'</a><br />';
        if(strlen($show->subtitle))
            echo '<b>'.$show->subtitle.'</b><br />';
//      if(strlen($show->description))
//          echo $show->description.'<br />';
        echo nice_length($show->length).'<br /><br />';
            $row++;
        }

    }

}

