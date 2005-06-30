<?php
/***                                                                        ***\
    program_listing.php                      Last Updated: 2004.05.04 (xris)

    This file defines a theme class for the program listing section.
    It must define several methods, some of which have specific
    parameters.   documentation will be added someday.
\***                                                                        ***/


#class theme_program_listing extends Theme {
class Theme_program_listing extends Theme {

    function print_page(&$Channels, &$Timeslots, $list_starttime, $list_endtime) {
    // Print the main page header
        parent::print_header('MythWeb - Program Listing:  '.strftime('%B %e, %Y, %I:%M %p', $list_starttime));
    // Print the header info specific to the program listing
?>
<p>
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
    <td width="50%" align="center">Currently Browsing:  <?php echo strftime('%B %e, %Y, %I:%M %p', $list_starttime)?></td>
    <td class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <form class="form" action="program_listing.php" method="get">
        <table width="100%" border="0" cellspacing="0" cellpadding="2">
        <tr>

            <td align="center">Jump&nbsp;to:&nbsp;&nbsp;</td>
            <td align="right">Hour:&nbsp;</td>
            <td><select name="hour"><?
                for ($h=0;$h<24;$h++) {
                    echo "<option value=\"$h\"";
                    if ($h == date('H', $list_starttime))
                        echo ' SELECTED';
                    echo ">$h:00</option>";
                }
                ?></select></td>
            <td align="right">Date:&nbsp;</td>
            <td><select name="date"><?
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
                    if ($date == date("Ymd", $list_starttime)) echo " selected";
                    echo ">".strftime('%B %e, %Y', $time)."</option>";
                }
                ?></select></td>
            <td align="center"><input type="submit" class="submit" value="Jump"></td>


        </tr>
        </table>
        </form></td>
</tr>
</table>
</p>

<p>
<table cellpadding="4" cellspacing="2" class="list small progressive">
    <colgroup>
        <col style="width: 12ex">
        <col span="<?=num_time_slots * timeslot_size / 60?>" width="*">
        <col style="width: 20px">
    </colgroup>
<?
        $_GET['start'] or $_GET['start'] = $_POST['start'];
        $_GET['start'] or $_GET['start'] = 0;

        if (strcasecmp(channels_per_page, 'All'))
        {
            $page_start = $_GET['start'];
            $page_end = $page_start + channels_per_page;
            if ($page_end > count($Channels))
                $page_end = count($Channels);
        }
        else
        {
            $page_start = 0;
            $page_end = count($Channels);
        }

        // Go through each channel and load/print its info - use references to avoid "copy" overhead
        $channel_count = 0;
        $good_channel_list = array();
        foreach ($Channels as $channel) {
        // Ignore channels with no number
            if (strlen($channel->channum) < 1 || 0 == count($channel->programs))
                continue;
        // Count this channel
            $channel_count++;
            $good_channel_list[] = prefer_channum ? $channel->channum : $channel->callsign;
            if ($channel_count <= $page_start || $channel_count > $page_end)
                continue;
        // Display the timeslot bar?
            if (($channel_count - $page_start) % timeslotbar_skip == 1)
                $this->print_timeslots($Timeslots, $list_starttime, $list_endtime);
        // Print the data
            $this->print_channel(&$channel, $list_starttime, $list_endtime);
        }
?>
</table>
</p>
<?
        if (channels_per_page < $channel_count && strcasecmp(channels_per_page, 'All'))
        {
            echo '<p align="center">';

            if ($page_start > 0)
            {
                $back = $page_start - channels_per_page;
                if ($back < 0)
                    $back = 0;
                echo "  <a href=\"program_listing.php?start=$back\">&lt;&lt; Back</a> &nbsp; | &nbsp;";
            }

            for($i=0; $i<$channel_count; $i += channels_per_page)
            {
                if (0 != $i)
                    echo " &nbsp; | &nbsp;";

                $end = $i + channels_per_page - 1;
                if ($end >= $channel_count)
                    $end = $channel_count - 1;

                if ($i != $page_start)
                    echo "<a href=\"program_listing.php?start=$i\">".$good_channel_list[$i]." - ".$good_channel_list[$end]."</a>";
                else
                    echo "<b>".$good_channel_list[$i]." - ".$good_channel_list[$end]."</b>";
            }

            if ($page_end < $channel_count)
                print "\n   &nbsp; | &nbsp; <a href=\"program_listing.php?start=$page_end\">Next &gt;&gt;</a>";

            print "\n</p><br>";
        }
    // Print the main page's footer
        parent::print_footer();
    }

    /*
        print_timeslot:

    */
    function print_timeslots($timeslots, $start_time, $end_time) {
        static $timeslot_anchor = 0;

        // Update the timeslot anchor
        $timeslot_anchor++;
?><tr>
    <td class="menu" align="right"><a href="program_listing.php?time=<?=$start_time - (timeslot_size * num_time_slots)?>#anchor<?=$timeslot_anchor?>" name="anchor<?=$timeslot_anchor?>"><img src="images/left.gif" border="0" alt="left"></a></td>
<?      foreach ($timeslots as $time) { ?>
    <td class="menu" align="center" colspan="<?=timeslot_size / 60?>"><a href="program_listing.php?time=<?=$time?>#anchor<?=$timeslot_anchor?>"><?=date('g:i', $time)?></a></td>
<?      } ?>
    <td class="menu"><a href="program_listing.php?time=<?=$start_time + (timeslot_size * num_time_slots)?>#anchor<?=$timeslot_anchor?>"><img src="images/right.gif" border="0" alt="right"></a></td>
</tr><?
    }

    /*
        print_channel:

    */
    function print_channel($channel, $start_time, $end_time) {
?>
<tr>
    <td align="center" class="menu" nowrap>
        <a href="channel_detail.php?chanid=<?=$channel->chanid?>" class="small chop"
            onmouseover="window.status='<?=$channel->name?>';return true"
            onmouseout="window.status='';return true"><?=prefer_channum ? "$channel->channum $channel->callsign" : "$channel->callsign $channel->channum"?></a>
    </td>
<?
    $last_endtime = $start_time;
    foreach($channel->programs as $program)
    {
        if ($last_endtime + 60 < $program->starttime)
            $this->print_nodata($program->starttime - $last_endtime);
        $this->print_program($program, $start_time, $end_time);
        $last_endtime = $program->endtime;
    }
?>
</tr><?
    }

    /*
        print_program:

    */
    function print_program($program, $list_starttime, $list_endtime)
    {
        $href = 'program_detail.php?chanid='.$program->chanid.'&starttime='.$program->starttime;

        $prescript = '<a id="program_'.$program_id_counter.'_anchor" href="'.$href.'">';
        if ($program->starttime < $list_starttime)
        {
            $starttime = $list_starttime;
            $prescript .= '&lt;&lt ';
        }
        else
        {
            $starttime = $program->starttime;
        }

        if ($program->endtime > $list_endtime)
        {
            $endtime = $list_endtime;
            $prescript = '<table cellpadding="0" cellspacing="0" class="list small progressive" style="background: transparent"><tr><td class="chop">'.$prescript;
            $postscript = '</td><td style="width: 2.25ex; align: right"><a href="'.$href.'">&gt;&gt;</a></td></tr></table>';
        }
        else
        {
            $endtime = $program->endtime;
            $postscript = '';
        }

        $cellwidth = (int)(($endtime - $starttime + 59) / 60);
        if ($cellwidth < 1)
            return;

        {
            $mouseover = ' onmouseover="window.status=\'' . str_replace(array("'", '"'), array("\\'", '&quot;'), $program->title) . ' (' . date('g:ia', $program->starttime) . ' - ' . date('g:ia', $program->endtime) . ')';
            if ($program->description)
                $mouseover .= ': ' . str_replace(array("'", '"'), array("\\'", '&quot;'), sprintf('%.75s', $program->description));
            $mouseover .= '\'; return true;" onmouseout="window.status=\'\'; return true;" ';
        }
?>
    <td nowrap class="small <?=$program->class?>" <?=$mouseover?>colspan="<?=$cellwidth?>" valign="center"<?=$padding?>><?
    // Print a link to record this show
        echo $prescript
             .$program->title
             .(strlen($program->subtitle) > 0 ? ": $program->subtitle" : '');
    // Print some additional information for movies
        if ($program->category_type == 'movie' || $program->category_type == 'Film') {
            if ($program->airdate > 0)
                $parens = sprintf('%4d', $program->airdate);
            if (strlen($program->rating) > 0) {
                if ($parens)
                    $parens .= ", ";
                $parens .= "<i>$program->rating</i>";
            }
            if (strlen($program->starstring) > 0) {
                if ($parens)
                    $parens .= ", ";
                $parens .= $program->starstring;
            }
            if ($parens)
                echo " ($parens)";
        }
    // Finally, print some other information
        if ($program->previouslyshown)
            echo ' <i>(Rerun)</i>';
        echo "</a>$postscript";
    ?></td>
<?
    }

    /*
        print_nodata:

    */
    function print_nodata($seconds) {
        $cellwidth = (int)($seconds / 60);
        echo '      <td class="small tv_Unknown" colspan="'.$cellwidth.'" valign="center"></td>';
    }

}

?>
