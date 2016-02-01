<?php
/**
 * Channel detail
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/


    // Print the main page header
        $page_title = 'MythWeb - Channel Detail';
        require_once 'modules/_shared/tmpl/'.tmpl.'/header.php';

    // Print out some header info about this channel and time
        global $this_channel;
?>
<p>
            <form id="program_listing" action="tv/channel/<?php echo $_GET['chanid'] ?>" method="post">
            <center>
            <?php echo t('Channel') ?> <?php $this_channel->channum ?> <b><?php echo $this_channel->callsign ?></b><br />
            <?php echo date('D m/d/y', $_SESSION['list_time']) ?><br />

            <?php echo t('Jump to') ?><br />
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
                    echo "<option value=\"$time\"";
                    if ($date == date("Ymd", $_SESSION['list_time'])) echo " selected";
                    echo ">".date("D m/d/y" , $time)."</option>";
                }
                ?></select><br />
                <input type="submit" class="submit" value="<?php echo t('Jump') ?>"><br /><br />
            </center>
            </form>
</p>
<?php
    // Print the shows for today
        print_shows();
    // Print the main page footer
        require_once 'modules/_shared/tmpl/'.tmpl.'/footer.php';

    function print_shows() {
        global $this_channel;
    // No search was performed, just return
        if (!is_array($this_channel->programs))
            return;
    // Display the results
        $row = 0;
        foreach ($this_channel->programs as $show) {

        if(strlen($show->title) <= 0 && strlen($show->subtitle) <= 0)
            continue;

    // Print the content
    ?>
    <?php echo strftime($_SESSION['time_format'], $show->starttime) ?> -
    <?php echo strftime($_SESSION['time_format'], $show->endtime) ?><br />
<?php
        if(strlen($show->subtitle) <= 0)
            echo '<b><a href="tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.$show->title.'</a></b><br />';
        else
            echo '<a href="tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.$show->title.'</a><br />';

        if(strlen($show->subtitle))
            echo '<b>'.$show->subtitle.'</b><br />';
//      if(strlen($show->description))
//          echo $show->description.'<br />';
        echo nice_length($show->length).'<br /><br />';
            $row++;
        }

    }
