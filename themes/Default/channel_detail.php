<?php
/***                                                                        ***\
	channel_detail.php                        Last Updated: 2004.05.04 (xris)

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
<table align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
<?php	if (show_channel_icons && is_file($this_channel->icon)) { ?>
	<td align="right"><img src="<?=$this_channel->icon?>" height="30" width="30"></td>
<?		} ?>
	<td width="66%" valign="center" class="huge">
		Channel <?=$this_channel->channum?>:  <?=$this_channel->callsign?> on <?php echo strftime('%B %e, %Y', $_SESSION['list_time'])?></td>
	<td class="command command_border_l command_border_t command_border_b command_border_r" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="2">
		<tr>
			<form id="form" action="channel_detail.php?chanid=<?php echo $_GET['chanid']?>" method="post">

			<td align="center">Jump&nbsp;to:&nbsp;&nbsp;</td>
			<td align="right">Date:&nbsp;</td>
			<td><select name="time" onchange="get_element('form').submit()"><?
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
					echo ">".strftime($_SESSION['date_channel_jump'] , $time)."</option>";
				}
				?></select></td>
			<td align="center"><input type="submit" class="submit" value="Jump"></td>

			</form>

			</tr>
			</table></td>
</tr>
</table>
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
?><table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
	<td><a href="scheduled_recordings.php?sortby=airdate">time</a></td>
	<td><a href="scheduled_recordings.php?sortby=title">show</a></td>
	<td>episode</td>
	<td>description</td>
	<td><a href="scheduled_recordings.php?sortby=length">length</a></td>
</tr><?php

		$row = 0;
		foreach ($this_channel->programs as $show) {

        // Print some additional information for movies
        $additional = '';
        if ($show->category_type == 'movie'
                || $show->category_type == 'Film') {
            if ($show->airdate > 0)
                    $additional = sprintf('%4d', $show->airdate);
            if (strlen($show->rating) > 0) {
                if ($additional)
                    $additional .= ", ";
                $additional .= "<i>$show->rating</i>";
            }
            if (strlen($show->starstring) > 0) {
                if ($additional)
                    $additional .= ", ";
                $additional .= $show->starstring;
            }
            if ($additional)
                $additional = ', (' . $additional . ')';
        }

	// Print the content
	?><tr class="<?php echo $show->class ?>">
	<td nowrap align="center"><a href="program_listing.php?time=<?php echo $show->starttime ?>"><?php echo strftime($_SESSION['time_format'], $show->starttime)?> - <?php echo strftime($_SESSION['time_format'], $show->endtime)?></a></td>
	<td class="<?php echo $show->class ?>"><?php
		echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
			 .$show->title.$additional.'</a>';
		?></td>
	<td><?php echo $show->subtitle?></td>
	<td><?php echo $show->description?></td>
	<td nowrap><?php echo nice_length($show->length)?></td>
</tr><?php
			$row++;
		}
?>

</table>
<?php
	}

}

?>
