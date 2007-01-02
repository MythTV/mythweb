<?php
/**
 * This displays details about a program, as well as provides recording
 * commands.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Program Detail').":  $program->title";

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_detail.css" />';
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedule.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

/*
 * Print the page contents:
 * I really hate tables, but this layout just doesn't work right with pure-css,
 * considering that different languages and setups will all have varied widths
 * that make it too hard to lay out. In its defense, it *is* somewhat tabular.
/*/
?>

<script language="JavaScript" type="text/javascript">
<!--

// Keep track of the autoexpire flag
    var autoexpire = <?php echo $program->auto_expire ? 1 : 0 ?>;

// Set the autoexpire flag
    function set_autoexpire() {
        var r = new Ajax.Request('<?php echo root ?>tv/detail/<?php echo $_GET['chanid'], '/', $_GET['starttime'] ?>',
                                 {
                                    parameters: 'autoexpire='+(1 - autoexpire),
                                  asynchronous: false
                                 });
        if (r.transport.responseText == 'success') {
        // Update to the new value
            autoexpire = 1 - autoexpire;
        // Fix the images
            $('autoexpire').src = '<?php echo skin_url, '/img/flags/' ?>'
                                  + (autoexpire
                                     ? ''
                                     : 'no_')
                                  + 'autoexpire.png';
            if (autoexpire)
                $('autoexpire').title = '<?php echo addslashes(t('Click to disable Auto Expire')) ?>';
            else
                $('autoexpire').title = '<?php echo addslashes(t('Click to enable Auto Expire')) ?>';
        }
        else if (r.transport.responseText) {
            alert('Error: '+r.transport.responseText);
        }
    }

    function confirm_delete(forget_old) {
        if (confirm("<?php echo str_replace('"', '\\"',
                                            t('Are you sure you want to delete the following show?')
                                            .'\n\n     '
                                            .$program->title
                                            .($program->subtitle
                                              ? ': '.$program->subtitle
                                              : '')) ?>")) {
            location.href = '<?php echo root ?>tv/recorded?delete=yes&chanid=<?php
                            echo $program->chanid
                            ?>&starttime=<?php echo $program->recstartts ?>'
                            +(forget_old
                                ? '&forget_old=yes'
                                : '');
        }
    }

// Toggle showing of the advanced schedule options
    function toggle_advanced(show) {
        if (show) {
            $('_schedule_advanced').style.display     = 'block';
            $('_schedule_advanced_off').style.display = 'none';
            $('_show_advanced').style.display = 'none';
            $('_hide_advanced').style.display = 'inline';
        }
        else {
            $('_schedule_advanced').style.display     = 'none';
            $('_schedule_advanced_off').style.display = 'block';
            $('_show_advanced').style.display = 'inline';
            $('_hide_advanced').style.display = 'none';
        }
    // Toggle the session setting, too.
        new Ajax.Request('<?php echo root ?>tv/detail?=',
                         {
                            parameters: 'show_advanced_schedule='+(show ? 1 : '0'),
                          asynchronous: true
                         }
                        );
    }

// -->
</script>


        <table id="_info" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
<?php   if ($channel) { ?>
            <td class="_channel">
                <a href="<?php echo root ?>tv/channel/<?php echo $channel->chanid, '/', $program->starttime ?>"
                        title="<?php
                            echo t('Details for: $1',
                                   html_entities($channel->name))
                        ?>">
<?php       if (show_channel_icons === true && !empty($channel->icon)) { ?>
                    <img src="<?php echo $channel->icon ?>" height="30" width="30">
<?php       } ?>
                <span class="_preferred"><?php echo (prefer_channum ? $channel->channum : $channel->callsign) ?></span><br />
                    <?php echo (prefer_channum ? $channel->callsign : $channel->channum), "\n" ?>
                </a>
            </td>
<?php   } ?>
            <td id="_title"<?php
                    if (!$channel)
                        echo ' colspan="2"';
                    if ($program && $program->css_class)
                        echo ' class="', $program->css_class, '"';
                    ?>>
                <a href="<?php echo root ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode($schedule->title)) ?>?search_title=1"><?php
                    echo $schedule->title;
                    if ($schedule->subtitle)
                        echo ':<br />', $schedule->subtitle;
                    ?></a>
                <div id="_time"><?php
                echo strftime('%a, %b %e', $schedule->starttime);
                echo ', '
                    .t('$1 to $2', strftime($_SESSION['time_format'], $schedule->starttime),
                                   strftime($_SESSION['time_format'], $schedule->endtime));
                if ($program)
                    echo ' ('.tn('$1 min', '$1 mins', intval($program->length/60)).')';
                echo "<br />\n";
                ?></div>
                </td>
        </tr><?php
        if (!empty($schedule->fancy_description)) {
        ?><tr>
            <td id="_description" colspan="2">
                <?php echo nl2br($schedule->fancy_description) ?>
            </td>
        </tr><?php
        }
        if ($program) {
        ?><tr id="_progflags">
            <td colspan="2"><?php
        // Auto expire is interactive for recordings
            if ($program->filename) {
                echo '<a onclick="set_autoexpire()">',
                     '<img id="autoexpire" src="', skin_url, '/img/flags/';
                if ($program->auto_expire)
                    echo 'autoexpire.png" title="', t('Click to disable Auto Expire'), '"';
                else
                    echo 'no_autoexpire.png" title="', t('Click to enable Auto Expire'), '"';
                echo '></a>';
            }
            elseif ($program->auto_expire) {
                echo '<img src="', skin_url, '/img/flags/autoexpire.png" title="', t('Auto Expire'), '">';
            }
        // The rest of the flags are just for display
            if ($program->closecaptioned)
                echo '<img src="'.skin_url.'/img/flags/cc.png" title="'.t('Closed Captioning').'">';
            if ($program->stereo)
                echo '<img src="'.skin_url.'/img/flags/stereo.png" title="'.t('Stereo').'">';
            if ($program->hdtv)
                echo '<img src="'.skin_url.'/img/flags/hd.png" title="'.t('HD').'">';
            if ($program->has_commflag)
                echo '<img src="'.skin_url.'/img/flags/commflagged.png" title="'.t('Commercials Flagged').'">';
            if ($program->has_cutlist)
                echo '<img src="'.skin_url.'/img/flags/cutlist.png" title="'.t('Has Cutlist').'">';
            if ($program->bookmark)
                echo '<img src="'.skin_url.'/img/flags/bookmark.png" title="'.t('has Bookmark').'">';
            if ($program->is_watched)
                echo '<img src="'.skin_url.'/img/flags/watched.png" title="'.t('Watched').'">';
            ?></td>
        </tr><?php
            if (strlen($program->category)) {
        ?><tr class="_extras">
            <th><?php echo t('Category') ?>:</th>
            <td><?php echo $program->category ?></td>
        </tr><?php
            }
            if (strlen($program->category_type)) {
        ?><tr class="_extras">
            <th><?php echo t('Type') ?>:</th>
            <td><?php echo $program->category_type;
                          if ($program->seriesid)
                              echo ' (', $program->seriesid, ')' ?></dd>
        </tr><?php
            }
            if (strlen($program->syndicatedepisodenumber) > 0) {
        ?><tr class="_extras">
            <th><?php echo t('Episode Number') ?>:</th>
            <td><?php echo $program->syndicatedepisodenumber ?></dd>
        </tr><?php
            }
            if (strlen($program->airdate)) {
        ?><tr class="_extras">
            <th><?php echo t('Original Airdate') ?>:</th>
            <td><?php echo $program->airdate ?></dd>
        </tr><?php
            }
            if (strlen($program->programid) > 0) {
        ?><tr class="_extras">
            <th><?php echo t('Program ID') ?>:</th>
            <td><?php echo $program->programid ?></dd>
        </tr><?php
            }
            if ($program->get_credits('host')) {
        ?><tr class="_extras">
            <th><?php echo t('Hosted by') ?>:</th>
            <td><?php echo $program->get_credits('host') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('presenter')) {
        ?><tr class="_extras">
            <th><?php echo t('Presented by') ?>:</th>
            <td><?php echo $program->get_credits('presenter') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('actor')) {
        ?><tr class="_extras">
            <th><?php echo t('Cast') ?>:</th>
            <td><?php echo $program->get_credits('actor') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('guest_star')) {
        ?><tr class="_extras">
            <th><?php echo t('Guest Starring') ?>:</th>
            <td><?php echo $program->get_credits('guest_star') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('director')) {
        ?><tr class="_extras">
            <th><?php echo t('Directed by') ?>:</th>
            <td><?php echo $program->get_credits('director') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('producer')) {
        ?><tr class="_extras">
            <th><?php echo t('Produced by') ?>:</th>
            <td><?php echo $program->get_credits('producer') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('executive_producer')) {
        ?><tr class="_extras">
            <th><?php echo t('Exec. Producer') ?>:</th>
            <td><?php echo $program->get_credits('executive_producer') ?></dd>
        </tr><?php
            }
            if ($program->get_credits('writer')) {
        ?><tr class="_extras">
            <th><?php echo t('Written by') ?>:</th>
            <td><?php echo $program->get_credits('writer') ?></dd>
        </tr><?php
            }
            if (strlen($program->starstring) > 0) {
        ?><tr class="_extras">
            <th><?php echo t('Guide rating') ?>:</th>
            <td><?php echo $program->starstring ?></dd>
        </tr><?php
            }
        ?><tr class="_extras">
            <th><?php echo t('Length') ?>:</th>
            <td><?php echo nice_length($program->length) ?></dd>
        </tr><?php
            if (strlen($program->filesize) > 0) {
        ?><tr class="_extras">
            <th><?php echo t('File Size') ?>:</th>
            <td><?php echo nice_filesize($program->filesize) ?></dd>
        </tr><?php
            }
        }
    // Can we perform an accurate duplicate check?
        $can_dupcheck = preg_match('/\S/', $program->title)
                        && preg_match('/\S/', $program->programid.$program->subtitle.$program->description);
        if (!empty($program->recstatus) || $can_dupcheck) {
        ?><tr id="_status">
            <th><?php echo t('MythTV Status') ?>:</th>
            <td><?php
                if (!empty($program->recstatus)) {
                    echo $GLOBALS['RecStatus_Reasons'][$program->recstatus];
                    if ($can_dupcheck && in_array($program->recstatus, array('Recorded', 'NeverRecord', 'PreviousRecording'))) {
                        echo '<a href="'.root.'tv/detail/'.$program->chanid
                            .'/'.$program->starttime.'?forget_old=yes"'
                            .'title="'.html_entities(t('info:forget old')).'">'
                            .t('Forget Old').'</a>';
                    }
                }
                if ($can_dupcheck && !in_array($program->recstatus, array('Recorded', 'NeverRecord'))) {
                    echo '<a href="'.root.'tv/detail/'.$program->chanid
                        .'/'.$program->starttime.'?never_record=yes"'
                        .'title="'.html_entities(t('info:never record')).'">'
                        .t('Never Record').'</a>';
                }
                if ($program->filename) {
                    echo '<a onclick="javascript:confirm_delete(false)"',
                         ' title="',html_entities(t('Delete $1',
                                                    $program->title
                                                    .($show->subtitle
                                                        ? ': '.$show->subtitle
                                                        : '')
                                                 )).'">',
                         t('Delete'), '</a>',
                         '<a onclick="javascript:confirm_delete(true)"',
                         ' title="',html_entities(t('Delete and rerecord $1',
                                                    $program->title
                                                    .($show->subtitle
                                                        ? ': '.$show->subtitle
                                                        : '')
                                                 )).'">',
                         t('Delete + Rerecord'), '</a>';
                }
                ?></td>
        </tr><?php
        }
        if (count($conflicting_shows)) {
        ?><tr id="_conflicts">
            <th><?php echo t('Possible conflicts') ?>:</th>
            <td><?php
        // A program id counter for popup info
            $program_id_counter = 0;
            foreach ($conflicting_shows as $show) {
                $program_id_counter++;
            // Print the link to edit this scheduled recording
                echo '<a class="', $show->css_class,
                     '" title="', html_entities(t('$1 to $2',
                                                  strftime($_SESSION['time_format'], $show->starttime),
                                                  strftime($_SESSION['time_format'], $show->endtime))
                                                .', '.(prefer_channum ? $show->channel->channum : $show->channel->callsign)
                                                .' - '.$show->channel->name).'"';
                if (show_popup_info)
                    echo show_popup("program_$program_id_counter", $show->details_list(), NULL, 'popup');
                echo ' href="'.root.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'
                    .$show->title
                    .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
                    .'</a>';
            }
            ?></td>
        </tr><?php
        }
        ?><tr class="_links">
            <th><?php echo t('More') ?>:</th>
            <td>
<?php           if ($schedule->title) { ?>
                <a href="http://www.imdb.com/Find?select=Titles&for=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'IMDB') ?></a>
                <a href="http://www.tv.com/search.php?type=11&stype=all&qs=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'TV.com') ?></a>
                <a href="http://www.google.com/search?q=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'Google') ?></a>
                <a href="<?php echo root ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode($schedule->title)) ?>?search_title=1"><?php
                    if ($_GET['recordid'])
                        echo t('Find showings of this program');
                    else
                        echo t('Find other showings of this program');
                ?></a>
<?php           }
                if ($_GET['recordid']) {
                    echo '<a href="',  root, 'tv/schedules">',
                         t('Back to the recording schedules'),
                         '</a>';
                }
                else {
                    if ($program->endtime > time()) {
                        echo '<a href="', root, 'tv/list?time=', $program->starttime, '">',
                             t('What else is on at this time?'),
                             '</a>';
                    }
                    if ($program->filename) {
                        echo '<a href="', root, 'tv/recorded">',
                             t('Back to the recorded programs'),
                             '</a>';
                    }
                    else {
                        echo '<a href="', root, 'tv/list?time=', $_SESSION['list_time'], '">',
                             t('Back to the program listing'),
                             '</a>';
                    }
                } ?>
                </td>
        </tr>
        </table>

<?php if (!$program || !$program->filename || ($program->filename && $program->recendts > time())) { ?>
    <div id="schedule">
        <form name="program_detail" method="post" action="<?php echo root ?>tv/detail<?php
            if ($_GET['recordid'])
                echo '?recordid='.urlencode($_GET['recordid']);
            else
                echo '/'.urlencode($_GET['chanid']).'/'.urlencode($_GET['starttime'])
            ?>">

<?php   if (!$schedule || $schedule->type != rectype_override && $schedule->type != rectype_dontrec) { ?>
        <div class="_options">
            <h3><?php echo t('Schedule Options') ?>:</h3>
            <ul>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never"<?php
                        if (!$schedule->recordid || $schedule->search) echo ' CHECKED' ?> />
                    <label for="record_never"><?php
                        if ($schedule->search)
                            echo t('Schedule via $1.',
                                   '<a href='.root.'tv/schedules/custom/'.$schedule->recordid.'>'
                                   .$schedule->search_title.'</a>');
                        elseif ($schedule->recordid)
                            echo t('Cancel this schedule.');
                        else
                            echo t('Don\'t record this program.');
                        ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php
                        echo $schedule->type == rectype_once ? ' CHECKED' : '' ?> />
                    <label for="record_once"><?php echo t('rectype-long: once') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_daily ?>" id="record_daily"<?php
                        echo $schedule->type == rectype_daily ? ' CHECKED' : '' ?> />
                    <label for="record_daily"><?php echo t('rectype-long: daily') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_weekly ?>" id="record_weekly"<?php
                        echo $schedule->type == rectype_weekly ? ' CHECKED' : '' ?> />
                    <label for="record_weekly"><?php echo t('rectype-long: weekly') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="record_findone"<?php
                        echo $schedule->type == rectype_findone ? ' CHECKED' : '' ?> />
                    <label for="record_findone"><?php echo t('rectype-long: findone') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_finddaily ?>" id="record_finddaily"<?php
                        echo $schedule->type == rectype_finddaily ? ' CHECKED' : '' ?> />
                    <label for="record_finddaily"><?php echo t('rectype-long: finddaily') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findweekly ?>" id="record_findweekly"<?php
                        echo $schedule->type == rectype_findweekly ? ' CHECKED' : '' ?> />
                    <label for="record_findweekly"><?php echo t('rectype-long: findweekly') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_channel ?>" id="record_channel"<?php
                        echo $schedule->type == rectype_channel ? ' CHECKED' : '' ?> />
                    <label for="record_channel"><?php echo t('rectype-long: channel', $channel->callsign) ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        echo $schedule->type == rectype_always ? ' CHECKED' : '' ?> />
                    <label for="record_always"><?php echo t('rectype-long: always') ?></label></li>
            </ul>
        </div>
<?php
        }
        if ($schedule && $schedule->type != rectype_once && ($schedule->search || $schedule->type)) {
?>
        <div class="_options">
            <h3><?php echo t('Schedule Override') ?>:</h3>
            <ul>
<?php       if ($schedule->type == rectype_override || $schedule->type == rectype_dontrec) { ?>
                <li><input type="radio" class="radio" name="record" value="0" id="schedule_default"<?php
                        if ($schedule->type != rectype_override && $schedule->type != rectype_dontrec) echo ' CHECKED' ?> />
                    <label for="schedule_default"><?php
                        echo t('Schedule normally.') ?></label></li>
<?php       } ?>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_override ?>" id="record_override"<?php
                        if ($schedule->type == rectype_override) echo ' CHECKED' ?> />
                    <label for="record_override"><?php
                        echo t('rectype-long: override') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_dontrec ?>" id="record_dontrec"<?php
                        if ($schedule->type == rectype_dontrec) echo ' CHECKED' ?> />
                    <label for="record_dontrec"><?php
                        echo t('rectype-long: dontrec') ?></label></li>

            </ul>
        </div>
<?php      } ?>

        <div class="_options">
            <h3><?php echo t('Advanced Options') ?>:</h3>
            (<?php
                echo '<a onclick="toggle_advanced(false)" id="_hide_advanced"';
                if (!$_SESSION['tv']['show_advanced_schedule'])
                    echo ' style="display: none"';
                echo '>', t('Hide'), '</a>',
                     '<a onclick="toggle_advanced(true)"  id="_show_advanced"';
                if ($_SESSION['tv']['show_advanced_schedule'])
                    echo ' style="display: none"';
                echo '>', t('Show'), '</a>';
            ?>)

            <div id="_schedule_advanced_off"<?php
                if ($_SESSION['tv']['show_advanced_schedule']) echo ' style="display: none"'
                ?>>
                <?php echo t('info: hidden advanced schedule') ?>
            </div>

            <dl class="clearfix" id="_schedule_advanced"<?php
                if (!$_SESSION['tv']['show_advanced_schedule']) echo ' style="display: none"'
                ?>>
                <dt><?php echo t('Recording Profile') ?>:</dt>
                <dd><?php profile_select($schedule->profile) ?></dd>
                <dt><?php echo t('Transcoder') ?>:</dt>
                <dd><?php transcoder_select($schedule->transcoder) ?></dd>
                <dt><?php echo t('Recording Group') ?>:</dt>
                <dd><?php recgroup_select($schedule->recgroup) ?></dd>
                <dt><?php echo t('Storage Group') ?>:</dt>
                <dd><?php storagegroup_select($schedule->storagegroup) ?></dd>
                <dt><?php echo t('Recording Priority') ?>:</dt>
                <dd><select name="recpriority"><?php
                    for ($i=99; $i>=-99; --$i) {
                        echo "<option value=\"$i\"";
                        if ($schedule->recpriority == $i)
                            echo ' SELECTED';
                        echo ">$i</option>";
                    }
                    ?></select></dd>
                <dt><?php echo t('Time Stretch Default') ?>:</dt>
                <dd>
                    <select name="timestretch">
                <?php
                    $tsstep = 0.05;
                    for ($tscount = 0.5; $tscount < 2.01; $tscount += $tsstep) {
                        $matches = fequals($schedule->tsdefault, $tscount);

                        if (!$matches &&
                                $schedule->tsdefault < $tscount &&
                                $schedule->tsdefault > $tscount - $tsstep) {
                            printf('<option value="%01.2f" selected>%01.2f' .
                                    "</option>\n", $schedule->tsdefault,
                                    $schedule->tsdefault);
                        }

                        printf('<option value="%01.2f"', $tscount);
                        if ($matches) {
                            echo ' selected';
                        }
                        printf(">%01.2f</option>\n", $tscount);
                    }
                ?>
                    </select>
                </dd>
                <dt><?php echo t('Check for duplicates in') ?>:</dt>
                <dd><select name="dupin"><?php
                        echo '<option value="1"';
                        if ($schedule->dupin == 1)
                            echo ' SELECTED';
                        echo '>' . t('Current recordings') . '</option>';
                        echo '<option value="2"';
                        if ($schedule->dupin == 2)
                            echo ' SELECTED';
                        echo '>' . t('Previous recordings') . '</option>';
                        echo '<option value="4"';
                        if ($schedule->dupin == 4)
                            echo ' SELECTED';
                        echo '>' . t('Only New Episodes') . '</option>';
                        echo '<option value="15"';
                        if ($schedule->dupin == 15 || $schedule->dupin == 0)
                            echo ' SELECTED';
                        echo '>' . t('All recordings') . '</option>';
                   ?></select></dd>
                <dt><?php echo t('Duplicate Check method') ?>:</dt>
                <dd><select name="dupmethod"><?php
                        echo '<option value="1"';
                        if ($schedule->dupmethod == 1)
                            echo ' SELECTED';
                        echo '>' . t('None') . '</option>';
                        echo '<option value="2"';
                        if ($schedule->dupmethod == 2)
                            echo ' SELECTED';
                        echo '>' . t('Subtitle') . '</option>';
                        echo '<option value="4"';
                        if ($schedule->dupmethod == 4)
                            echo ' SELECTED';
                        echo '>' . t('Description') . '</option>';
                        echo '<option value="6"';
                        if ($schedule->dupmethod == 6 || $schedule->dupmethod == 0)
                            echo ' SELECTED';
                        echo '>'.t('Subtitle and Description').'</option>';
                   ?></select></dd>
                <dt><?php echo t('Preferred Input') ?>:</dt>
                <dd><?php input_select($schedule->prefinput, 'prefinput') ?></dd>
                <dt><label for="autocommflag"><?php echo t('Auto-flag commercials') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autocommflag" name="autocommflag"<?php if ($schedule->autocommflag) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autotranscode"><?php echo t('Auto-transcode') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autotranscode" name="autotranscode"<?php if ($schedule->autotranscode) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob1"><?php echo get_backend_setting('UserJobDesc1') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob1" name="autouserjob1"<?php if ($schedule->autouserjob1) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob2"><?php echo get_backend_setting('UserJobDesc2') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob2" name="autouserjob2"<?php if ($schedule->autouserjob2) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob3"><?php echo get_backend_setting('UserJobDesc3') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob3" name="autouserjob3"<?php if ($schedule->autouserjob3) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autouserjob4"><?php echo get_backend_setting('UserJobDesc4') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob4" name="autouserjob4"<?php if ($schedule->autouserjob4) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="inactive"><?php echo t('Inactive') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="inactive" name="inactive"<?php if ($schedule->inactive) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="autoexpire"><?php echo t('Auto-expire recordings') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autoexpire" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1" /></dd>
                <dt><label for="maxnewest"><?php echo t('Record new and expire old') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="maxnewest" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1" /></dd>
                <dt><?php echo t('No. of recordings to keep') ?>:</dt>
                <dd><input type="input" class="quantity" name="maxepisodes" value="<?php echo html_entities($schedule->maxepisodes) ?>" /></dd>
                <dt><?php echo t('Start Early') ?>:</dt>
                <dd><input type="input" class="quantity" name="startoffset" value="<?php echo html_entities($schedule->startoffset) ?>" />
                    <?php echo t('minutes') ?></dd>
                <dt><?php echo t('End Late') ?>:</dt>
                <dd><input type="input" class="quantity" name="endoffset" value="<?php echo html_entities($schedule->endoffset) ?>" />
                    <?php echo t('minutes') ?></dd>
            </dl>

        </div>

        <div id="_schedule_submit">
            <input type="submit" class="submit" name="save" value="<?php echo t('Update Recording Settings') ?>">
        </div>

        </form>

    </div>

<?php
    }
    if ($program && $program->filename) { ?>

        <div id="_downloads">
            <div class="_pixmap">
                <a href="<?php echo $program->url ?>" title="<?php echo t('Direct Download') ?>"
                    ><img src="<?php echo $program->thumb_url ?>.png" height="240" width="320"></a></td>
            </div>
            <div class="_links">
                <a href="<?php echo video_url($program, true) ?>" title="<?php echo t('ASX Stream') ?>"
                    ><img src="<?php echo skin_url ?>/img/play_sm.png">
                    <?php echo t('ASX Stream') ?></a>
                <a href="<?php echo $program->url ?>" title="<?php echo t('Direct Download') ?>"
                    ><img src="<?php echo skin_url ?>/img/video_sm.png">
                    <?php echo t('Direct Download') ?></a>
            </div>
        </div>

<?php
    }

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

