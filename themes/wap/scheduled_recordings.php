<?php
/***                                                                        ***\
    scheduled_recordings.php                    Last Updated: 2003.08.05 (xris)

    This file defines a theme class for the scheduled recordings section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_scheduled_recordings extends Theme {

    function print_page(&$shows) {
    // Print the main page header
        parent::print_header('MythWeb - Scheduled Recordings');
    // Print the page contents
        global $All_Shows;


/*  <a href="scheduled_recordings.php?sortby=title">show</a><br>
    <a href="scheduled_recordings.php?sortby=channum">station</a><br>
    <a href="scheduled_recordings.php?sortby=airdate">air&nbsp;date</a><br>
    <a href="scheduled_recordings.php?sortby=length">length</a><br>
*/

    $row = 0;
    foreach ($shows as $show) {
    // Reset the command variable
        $command = '';
    // Which class does this show fall into?
        if ($show->recstatus == 'PreviousRecording' || $show->recstatus == 'CurrentRecording') {
            $class = 'duplicate';
            $command = '<a href="scheduled_recordings.php?rerecord=yes&title='.urlencode($show->title).'&subtitle='.urlencode($show->subtitle).'&description='.urlencode($show->description).'">Rerecord</a>';
        }
        elseif ($show->recstatus == 'Conflict' || $show->recstatus == 'Overlap') {
            $class   = 'conflict';
            $command = '<a href="scheduled_recordings.php?record=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'">Record</a>';
        }
        elseif ($show->recstatus == 'WillRecord') {
            $class   = 'scheduled';
            $command = '<a href="scheduled_recordings.php?suppress=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'">Don\'t Record</a>';
        }
        elseif ($show->recstatus == 'ForceRecord') {
            $class   = 'scheduled';
            $command = '<a href="scheduled_recordings.php?default=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'">Remove Record</a>';
        }
        elseif ($show->recstatus == 'ManualOverride' || $show->recstatus == 'Cancelled') {
            $class   = 'deactivated';
            $command = '<a href="scheduled_recordings.php?activate=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'">Remove Block</a>';
        }
        elseif ($show->recstatus == 'LaterShowing' || $show->recstatus == 'EarlierShowing' ) {
            $class   = 'deactivated';
            $command = '<a href="scheduled_recordings.php?record=yes&chanid='.$show->chanid.'&starttime='.$show->starttime.'">Activate</a>';
        }
        else {
            $class   = 'scheduled';
            #$command = 'Don\'t&nbsp;Record';
            $command = 'Unknown '.$show->recstatus;
        }

    // Print the content
//  <tr class="<?=$class>">
//  <td class="<?=$show->class>">

        // Print a link to record this show
        echo '<a id="program_'.$program_id_counter.'_anchor" href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'"'
             .'>'.$show->title
             .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
             .'</a><br>';
        ?>
    <?=$show->channel->name?><br>
    <?=date('D, M j', $show->starttime)?><br>
    <?=date('(g:i A)', $show->starttime)?> <?=nice_length($show->length)?><br>
<?  if ($command) { ?>
    <b><?=$command?></b><br>
<?  } ?>
    <br>
    <?
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
