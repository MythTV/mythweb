<?
/***                                                                        ***\
    scheduled_recordings.php                    Last Updated: 2003.08.05 (xris)

    This file defines a theme class for the scheduled recordings section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_scheduled_recordings extends Theme {

    function print_page() {
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