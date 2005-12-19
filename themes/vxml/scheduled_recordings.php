<?php
/***                                                                        ***\
    scheduled_recordings.php                    Last Updated: 2003.08.05 (xris)

    This file defines a theme class for the scheduled recordings section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_scheduled_recordings extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header('MythWeb - Upcoming Recordings');
    // Print the page contents
        global $All_Shows;


/*  <a href="scheduled_recordings.php?sortby=title">show</a><br />
    <a href="scheduled_recordings.php?sortby=channum">station</a><br />
    <a href="scheduled_recordings.php?sortby=airdate">air&nbsp;date</a><br />
    <a href="scheduled_recordings.php?sortby=length">length</a><br />
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
//  <tr class="<?php echo $class>">
//  <td class="<?php echo $show->class>">

        // Print a link to record this show
        echo '<a id="program_'.$program_id_counter.'_anchor" href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'"'
             .'>'.$show->title
             .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
             .'</a><br />';
        ?>
    <?php echo $show->channel->name ?><br />
    <?php echo date('D, M j', $show->starttime) ?><br />
    <?php echo date('(g:i A)', $show->starttime) ?> <?php echo nice_length($show->length) ?><br />
<?php  if ($command) { ?>
    <b><?php echo $command ?></b><br />
<?php  } ?>
    <br />
    <?php
        $row++;
    }
?>

</table>
<?php

    // Print the main page footer
        parent::print_footer();
    }

}
