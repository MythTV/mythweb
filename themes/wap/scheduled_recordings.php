<?php
/**
 * This file defines a theme class for the scheduled recordings section.
 * It must define one method.   documentation will be added someday.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

class Theme_scheduled_recordings extends Theme {

    function print_page(&$shows) {
    // Print the main page header
        parent::print_header('MythWeb - Upcoming Recordings');
    // Print the page contents
        global $All_Shows;

    // Row headers
        echo "\n    <hr />\n",
             "    Sort by:<br />\n",
             get_sort_link('title',   t('title')),   "\n",
             get_sort_link('channum', t('channum')), "\n",
             get_sort_link('airdate', t('airdate')), "\n",
             get_sort_link('length',  t('length')),  "\n",
             "    <table>\n";

        $row = 0;
        foreach ($shows as $show) {
            $row++;
            // Set the class to be used to display the recording status character
            $rec_class = implode(' ', array(recstatus_class($show), $show->recstatus));
            // Reset the command variable to a default URL
            $commands = array();
            $urlstr = 'chanid='.$show->chanid.'&starttime='.$show->starttime;
            // Set the recording status character, class and any applicable commands for each show
            switch ($show->recstatus) {
                case 'Recording':
                case 'WillRecord':
                    $rec_char   = $show->cardid;
                    $class      = 'scheduled';
                    $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'
                                  .$urlstr.'">'.t('Don\'t Record').'</a>';
                    // Offer to suppress any recordings that have enough info to do so.
                    if (preg_match('/\\S/', $show->title)
                            && (preg_match('/\\S/', $show->programid.$show->subtitle.$show->description))) {
                        $commands[] = '<a href="scheduled_recordings.php?'
                                      .'never_record=yes&'.$urlstr.'">'
                                      .t('Never Record').'</a>';
                    }
                    break;
                case 'PreviousRecording':
                    $rec_char   = 'P';
                    $class      = 'duplicate';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Record This').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?'
                                  .'forget_old=yes&'.$urlstr.'">'
                                  .t('Forget Old').'</a>';
                    break;
                case 'CurrentRecording':
                    $rec_char   = 'R';
                    $class      = 'duplicate';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Record This').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?'
                                  .'forget_old=yes&'.$urlstr.'">'
                                  .t('Forget Old').'</a>';
                    break;
                case 'Repeat':
                    $rec_char = 'r';
                    $class    = 'duplicate';
                    break;
                case 'EarlierShowing':
                    $rec_char = 'E';
                    $class    = 'deactivated';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Activate').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?default=yes&'
                                  .$urlstr.'">'.t('Default').'</a>';
                    break;
                case 'TooManyRecordings':
                    $rec_char = 'T';
                    $class    = 'deactivated';
                    break;
                case 'Cancelled':
                    $rec_char   = 'N';
                    $class      = 'deactivated';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Activate').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?default=yes&'
                                  .$urlstr.'">'.t('Default').'</a>';
                    break;
                case 'Conflict':
                    $rec_char = 'C';
                    // We normally use the recstatus value as the name of the class
                    //  used when displaying the recording status character.
                    // However, there is already a class named 'conflict' so we
                    //  need to modify this specific recstatus to avoid a conflict.
                    $rec_class = implode(' ', array(recstatus_class($show),
                                         'conflicting'));
                    $class      = 'conflict';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Record This').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'
                                  .$urlstr.'">'.t('Don\'t Record').'</a>';
                    break;
                case 'LaterShowing':
                    $rec_char = 'L';
                    $class    = 'deactivated';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Activate').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?default=yes&'
                                  .$urlstr.'">'.t('Default').'</a>';
                    break;
                case 'LowDiskSpace':
                    $rec_char   = 'K';
                    $class      = 'deactivated';
                    $commands[] = 'Not Enough Disk Space';
                    break;
                case 'TunerBusy':
                    $rec_char   = 'B';
                    $class      = 'deactivated';
                    $commands[] = 'Tuner is busy';
                    break;
                case 'Overlap':
                    $rec_char   = 'X';
                    $class      = 'conflict';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Record This').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'
                                  .$urlstr.'">'.t('Don\'t Record').'</a>';
                    break;
                case 'ManualOverride':
                    $rec_char   = 'X';
                    $class      = 'deactivated';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Activate').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?default=yes&'
                                  .$urlstr.'">'.t('Default').'</a>';
                    break;
                case 'ForceRecord':
                    $rec_char   = 'F';
                    $class      = 'scheduled';
                    $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'
                                  .$urlstr.'">'.t('Don\'t Record').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?default=yes&'
                                  .$urlstr.'">'.t('Default').'</a>';
                    break;
                default:
                    $rec_char   = '&nbsp;';
                    $rec_class  = '';
                    $class      = 'deactivated';
                    $commands[] = '<a href="scheduled_recordings.php?record=yes&'
                                  .$urlstr.'">'.t('Activate').'</a>';
                    $commands[] = '<a href="scheduled_recordings.php?dontrec=yes&'
                                  .$urlstr.'">'.t('Don\'t Record').'</a>';
                    break;
            }
?>
    <tr class='<?php echo $class ?>'><td><?php echo $rec_char ?></td><td>
    <?php
        // Print a link to record this show
            echo '<a id="program_'.$program_id_counter.'_anchor" href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'"'
                 .'>'.$show->title
                 .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
                 .'</a></td></tr>';
        ?>
    <tr><td></td><td>
      <?php echo $show->channel->name ?><br />
      <?php echo date('D, M j', $show->starttime) ?>
      <?php echo date('(g:i A)', $show->starttime) ?> <?php echo nice_length($show->length) ?></td></tr>
      <tr><td></td><td>
<?php
            echo implode(' | ', $commands);
            $prev_group = $cur_group;
            $row++;
      }
      echo "    </table>\n";

// Print the main page footer
        parent::print_footer();
    }

}

