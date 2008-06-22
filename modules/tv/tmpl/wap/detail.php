<?php
/**
 * Program detail
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


// Print the main page header
    $page_title = "Prog Detail";
    require_once 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the page contents
?>
<a href="<?php echo root ?>tv/channel/<?php echo $this_channel->chanid ?>" >
<?php echo $_SESSION["prefer_channum"] ? $this_channel->channum : $this_channel->callsign ?> &nbsp;
<?php echo $_SESSION["prefer_channum"] ? $this_channel->callsign : $this_channel->channum ?></a><br />


<?php 
  if (strlen($program->subtitle)) 
    echo $program->title;
  else
    echo "<b>".$program->title."</b>";  
?><BR>
<?php echo date('D m/d/y', $program->starttime) ?><br />
<?php echo strftime($_SESSION['time_format'], $program->starttime) ?> to <?php echo strftime($_SESSION['time_format'], $program->endtime) ?> (<?php echo (int)($program->length/60) ?> minutes)<BR>
                <?php
                if ($program->previouslyshown)
                    echo '(Rerun) ';
//              if ($program->category_type == 'movie')
//                  echo " (<a href=\"http://www.imdb.com/Find?select=Titles&for=" . urlencode($program->title) . "\">Search IMDB</a>)";
//              else
//                  echo " (<a href=\"http://www.google.com/search?q=" . urlencode($program->title) . "\">Search Google</a>)";
                ?>
        <?php if (strlen($program->subtitle)) { ?>
            Episode: <b><?php echo $program->subtitle ?></b><br />
        <?php }
           if (strlen($program->description)) { ?>
                <?php echo t('Description').": ".$program->description ?><br />
        <?php } ?>
        <?php if (strlen($program->category)) { ?>
                <?php echo t('Category').": ".$program->category ?><br />
        <?php }
           if (strlen($program->airdate)) { ?>
                Orig. Airdate: <?php echo $program->airdate ?><br />
        <?php }
           if (strlen($program->rating)) { ?>
                <?php echo strlen($program->rater) > 0 ? "$program->rater " : '' ?>Rating: <?php echo $program->rating ?><br />
        <?php
           if (strlen($program->starstring) > 0)
                    echo ", $program->starstring";
                ?><br />
        <?php } ?>

        <form name="program_detail" method="post" action="<?php echo root ?>tv/detail<?php
            if ($_GET['recordid'])
                echo '?recordid='.urlencode($_GET['recordid']);
            else
                echo '/'.urlencode($_GET['chanid']).'/'.urlencode($_GET['starttime'])
            ?>">
        <center><?php echo t('Schedule Options') ?>:</center>
                    <input type="radio" class="radio" name="record" value="record_never" id="record_never"<?php echo $schedule->recordid ? '' : ' CHECKED' ?>></input>
        <a><?php
        if ($schedule->recordid)
           echo 'Cancel';
        else
           echo 'Don\'t record';
          ?>
        </a><br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php echo $schedule->type == rectype_once ? ' CHECKED' : '' ?>></input>
            <a>Record this showing</a><br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="record_daily"<?php echo $schedule->type == rectype_daily ? ' CHECKED' : '' ?>></input>
            <a>Record every day</a> at this time<br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="record_weekly"<?php echo $schedule->type == rectype_weekly ? ' CHECKED' : '' ?>></input>
            <a>Record every week</a> at this time<br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="record_findone"<?php echo $schedule->type == rectype_findone ? ' CHECKED' : '' ?>></input>
            <a>Find one episode</a><br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_finddaily ?>" id="record_finddaily"<?php echo $schedule->type == rectype_finddaily ? ' CHECKED' : '' ?>></input>
            <a>Find one episode every day</a><br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_findweekly ?>" id="record_findweekly"<?php echo $schedule->type == rectype_findweekly ? ' CHECKED' : '' ?>></input>
            <a>Find one episode every week</a><br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_channel ?>" id="record_channel"<?php echo $schedule->type == rectype_channel ? ' CHECKED' : '' ?>></input>
            <a>Always record on this channel</a><br />
        <input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php echo $schedule->type == rectype_always ? ' CHECKED' : '' ?>></input>
            <a>Always record on any channel</a><br />
            <br />
            <?php echo t('Recording Profile') ?><br />
            <?php profile_select($schedule->profile) ?><br />
        <input type="checkbox" class="radio" name="autocommflag"<?php if ($schedule->autocommflag) echo ' CHECKED' ?> value="1" />
           <a><?php echo t('Auto-flag commercials') ?></a><br />
        <input type="checkbox" class="radio" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1" />
           <a><?php echo t('Auto-expire recordings') ?></a><br />
        <input type="checkbox" class="radio" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1" />
           <a><?php echo t('Record new and expire old') ?></a><br />
        <input type="checkbox" class="radio" name="inactive"<?php if ($schedule->inactive) echo ' CHECKED' ?> value="1" />
           <a><?php echo t('Inactive') ?></a><br />
        <?php echo t('No. of recordings to keep') ?>:
        <input type="input" class="quantity" name="maxepisodes" value="<?php echo html_entities($schedule->maxepisodes) ?>" size="2"/><br />
        <?php echo t('Start Early') ?>:
        <input type="input" class="quantity" name="startoffset" value="<?php echo html_entities($schedule->startoffset) ?>" size="2"/>
        <?php echo t('minutes') ?><br />
        <?php echo t('End Late') ?>:
        <input type="input" class="quantity" name="endoffset" value="<?php echo html_entities($schedule->endoffset) ?>" size="2"/>
        <?php echo t('minutes') ?><br />
        <center><input type="submit" class="submit" name="save" value="<?php echo t('Update Recording Settings') ?>"></center>
        <br />

    </form>

<?php
// Print the main page footer
    require_once 'modules/_shared/tmpl/'.tmpl.'/footer.php';

