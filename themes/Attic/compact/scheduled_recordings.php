<?
/***                                                                        ***\
	scheduled_recordings.php                    Last Updated: 2003.06.29 (xris)

	This file defines a theme class for the scheduled recordings section.
	It must define one method.   documentation will be added someday.

\***                                                                        ***/

require_once theme_dir . 'utils.php';

#class theme_program_detail extends Theme {
class Theme_scheduled_recordings extends Theme {

	function print_page() {
	// Print the main page header
		parent::print_header('MythWeb - Scheduled Recordings');
	// Print the page contents
		global $All_Shows;
?>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
	<td><a href="scheduled_recordings.php?sortby=title">show</a></td>
	<td><a href="scheduled_recordings.php?sortby=channum">station</a></td>
	<td><a href="scheduled_recordings.php?sortby=airdate">air&nbsp;date</a></td>
	<td><a href="scheduled_recordings.php?sortby=length">length</a></td>
</tr><?
	$row = 0;
	foreach ($All_Shows as $show) {
	// Reset the command variable
		$command = '';
	// Which class does this show fall into?
		if ($show->duplicate == 1) {
			$class = 'duplicate';
			$command = '<a href="scheduled_recordings.php?rerecord=yes&title='.urlencode($show->title).'&subtitle='.urlencode($show->subtitle).'&description='.urlencode($show->description).'">Rerecord</a>';
		}
		elseif ($show->conflicting == 1) {
			$class   = 'conflict';
			$command = '<a href="scheduled_recordings.php?record=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'&endtime='.$show->endtime.'">Record</a>';
		}
		elseif ($show->recording == 0) {
			$class   = 'deactivated';
			$command = '<a href="scheduled_recordings.php?activate=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'&endtime='.$show->endtime.'">Activate</a>';
		}
		else {
			$class   = 'scheduled';
			#$command = 'Don\'t&nbsp;Record';
			$command = '';
		}

		$mouseover = ' onmouseover="window.status=\'' . str_replace(array("'", '"'), array("\\'", '&quot;'), $show->title) . ' (' . date('g:ia', $show->starttime) . ' - ' . date('g:ia', $show->endtime) . ')';
		if ($show->description)
			$mouseover .= ': ' . str_replace(array("'", '"'), array("\\'", '&quot;'), sprintf('%.75s', $show->description));
		$mouseover .= '\'; return true;" onmouseout="window.status=\'\'; return true;" ';

	// Print the content
	?><tr class="<?=$class?>">
	<td class="<?=$show->class?>"<?=$mouseover?>><?php
		// Print a link to record this show
		echo '<a id="program_'.$program_id_counter.'_anchor" href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
			 .$show->title
			 .(trim($show->subtitle) != '' ? ":  $show->subtitle" : '')
			 .'</a>';
		?></td>
	<td><?=$show->channel->name?></td>
	<td nowrap><?=nice_date($show->starttime)?><br><?=date("g:i a", $show->starttime)?></td>
	<td align="right" nowrap><?=nice_duration($show->length)?></td>
<?	if ($command) { ?>
	<td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center"><?=$command?></td>
<?	} ?>
</tr><?
		$row++;
	}
?>

</table>
<?

	// Print the main page footer
		parent::print_footer();
	}

}

?>
