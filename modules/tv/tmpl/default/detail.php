<?php
/**
 * This displays details about a program, as well as provides recording
 * commands.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Program Detail').":  $schedule->title";

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_schedule.css">';
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_detail.css">';
    $headers[] = '<script type="text/javascript" src="'.root_url.'js/libs/flowplayer/flowplayer.js"></script>';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

    if ($program && $program->filename) {
        $flv_w = setting('WebFLV_w');
        $flv_h = intVal($flv_w / $program->getAspect()) + 25;  // +25px for the playback controls
    }

/*
 * Print the page contents:
 * I really hate tables, but this layout just doesn't work right with pure-css,
 * considering that different languages and setups will all have varied widths
 * that make it too hard to lay out. In its defense, it *is* somewhat tabular.
/*/
?>

<script type="text/javascript">
<!--

// Keep track of the autoexpire flag
    var autoexpire = <?php echo $program->auto_expire ? 1 : 0 ?>;

// Set the autoexpire flag
    function set_autoexpire() {
        var r = new Ajax.Request('<?php echo root_url ?>tv/detail/<?php echo $program->chanid, '/', $program->recstartts ?>',
                                 {
                                    parameters: 'toggle_autoexpire='+(1 - autoexpire),
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
            location.href = '<?php echo root_url ?>tv/recorded?delete=yes&chanid=<?php
                            echo $program->chanid
                            ?>&starttime=<?php echo $program->recstartts ?>'
                            +(forget_old
                                ? '&forget_old=yes'
                                : '');
        }
    }

    function openFlashPlayerInNewWindow() {
        player = window.open('', 'Flash Player', 'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,width=<?php echo $flv_w; ?>,height=<?php echo $flv_h; ?>,left=20,top=20');
        player.document.write('<html><body style="background-color: black; margin: 0px; padding: 0px;">'+$$('.x-pixmap')[0].textContent+'</body></html>');
    }

    function watchShow(host, chanid, starttime) {
        new Ajax.Request('<?php echo root_url;?>remote/play_program_on_frontend', {
                         method: 'get',
                         parameters: {exit: 1,
                                      host: host,
                                      chanid: chanid,
                                      starttime: starttime
                                      }
                        }
                        );
    }

    // Tries to find metadata for the current item
    // If found adds a "Home Page" link to the page
    function detailLookupMetadata() {
        new Ajax.Request('<?php echo root_url ?>tv/lookup_metadata',
                         {
                            parameters: {
                                              'title'        : "<?php echo $schedule->title ?>",
                                              'subtitle'     : "<?php echo $schedule->subtitle ?>",
                                              'inetref'      : "<?php echo ($program ? $program->inetref : $schedule->inetref) ?>",
                                              'season'       : "<?php echo ($program ? $program->season : $schedule->season) ?>",
                                              'episode'      : "<?php echo ($program ? $program->episode : $schedule->episode) ?>",
                                              'allowgeneric' : "true"
                                        },
                            asynchronous: true,
                            method: 'get',
                            onSuccess: detailOnMetadata,
                            onFailure: detailOnMetadataFailure
                         }
                        );

    }

    // if metadata is found inserts a home page then update the links
    function detailOnMetadata(transport) {
        var list = transport.responseJSON.VideoLookupList;

        updateHomePage(list.VideoLookups[0] || {});

    }

    // silently fail (no need to disrupt the page)
    function detailOnMetadataFailure(transport) {
    }

    function updateHomePage(item) {
         var homePage = $("home-page");
         var homeButton = $("metadata-home-page-link");

         // if this item doesn't have a home page link then
         // remove the existing link or ignore
         if (!item.HomePage) {
             homePage && Element.remove(homePage);
             homeButton && Element.remove(homeButton);
             return;
         }

         // update the link or create it if this item does have a home page
         if (homePage) {
              homePage.href = item.HomePage;
         } else {
              $($$(".x-links")[0].children[1]).insert({top:
                  new Element("a",
                      {href: item.HomePage,
                       target: "_new", id: "home-page"}).
                      update(item.Title + " " + "<?php echo t("Metadata Home Page") ?>")});
         }

         if (homeButton) {
              homeButton.href = item.HomePage;
         }  else {
              var mhp = $("metadata-home-page");
              mhp && mhp.insert(
                         new Element("a",
                              {id: "metadata-home-page-link",
                               href: item.HomePage,
                               target: "_new"}).
                              update("<?php echo t("Metadata Home Page")?>")
                          );
         }


    }


    // hook to look up data once the page has started
    detailLookupMetadata();
// -->
</script>

    <div id="content">
        <div id="contentBlock">
        <div id="div-x-info">
        <table id="x-info" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
<?php   if ($channel) { ?>
            <td class="x-channel">
                <a href="<?php echo root_url ?>tv/channel/<?php echo $channel->chanid, '/', $program->starttime ?>"
                        title="<?php
                            echo t('Details for: $1',
                                   html_entities($channel->name))
                        ?>">
<?php       if ($_SESSION["show_channel_icons"] == true && !empty($channel->icon)) { ?>
                    <img src="<?php echo $channel->icon ?>">
<?php       } ?>
                <br>
                    <?php echo ($_SESSION["prefer_channum"] ? $channel->callsign : $channel->channum), "\n" ?>
                </a>
            </td>
<?php   } ?>
            <td id="x-title"<?php
                    if (!$channel)
                        echo ' colspan="2"';
                    if ($program && $program->css_class)
                        echo ' class="', $program->css_class, '"';
                    ?>>
                <a href="<?php echo root_url ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode('^'.$schedule->title.'$')) ?>?field=title"><?php
                    echo $schedule->title;
                    if ($schedule->subtitle)
                        echo ':<br>', $schedule->subtitle;
                    ?></a>
                <div id="x-time"><?php
                echo strftime('%a, %b %e', $schedule->starttime);
                echo ', '
                    .t('$1 to $2', strftime($_SESSION['time_format'], $schedule->starttime),
                                   strftime($_SESSION['time_format'], $schedule->endtime));
                if ($program)
                    echo ' ('.tn('$1 min', '$1 mins', intval($program->length/60)).')';
                echo "<br>\n";
                ?></div>
                </td>
        </tr><?php
        if (!empty($schedule->fancy_description)) {
        ?><tr>
            <td id="x-description" colspan="2">
                <?php echo nl2br($schedule->fancy_description) ?>
            </td>
        </tr><?php
        }
        if ($program) {
        ?><tr id="x-progflags">
            <td colspan="2">
			<?php if (setting('recommend_enabled', null) && strlen($program->inetref) > 0) { ?>
				<div id="feelings" inetref="<?php echo $program->inetref; ?>">
					<div inetref="<?php echo $program->inetref; ?>" class="dislike feeling"></div>
					<div inetref="<?php echo $program->inetref; ?>" class="meh feeling"></div>
					<div inetref="<?php echo $program->inetref; ?>" class="like feeling"></div>
				</div>
			<?php } ?>
			
			<?php
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

            // Report transcoded status for recordings
            if ($program->filename) {
                if ($program->is_transcoded)
                    echo '<img src="'.skin_url.'/img/flags/transcoded.png" title="'.t('Transcoded').'">';
            }
            ?>
			</td>
        </tr><?php
            if (strlen($program->category)) {
        ?><tr class="x-extras">
            <th><?php echo t('Category') ?>:</th>
            <td><?php echo $program->category ?></td>
        </tr><?php
            }
            if (strlen($program->category_type)) {
        ?><tr class="x-extras">
            <th><?php echo t('Type') ?>:</th>
            <td><?php echo $program->category_type;
                          if ($program->seriesid)
                              echo ' (', $program->seriesid, ')' ?></td>
        </tr><?php
            }
            if (strlen($program->syndicatedepisodenumber) > 0) {
        ?><tr class="x-extras">
            <th><?php echo t('Episode Number') ?>:</th>
            <td><?php echo $program->syndicatedepisodenumber ?></td>
        </tr><?php
            }
            if (strlen($program->inetref) > 0) {
        ?><tr class="x-extras">
            <th><?php echo t('Internet Reference #') ?>:</th>
            <td><?php echo $program->inetref ?> <span class="commands" id="metadata-home-page"></span></td>
        </tr><?php
            }
            if ($program->season > 0) {
        ?><tr class="x-extras">
            <th><?php echo t('Season') ?>:</th>
            <td><?php echo $program->season ?></td>
        </tr><?php
            }
            if ($program->episode > 0) {
        ?><tr class="x-extras">
            <th><?php echo t('Episode') ?>:</th>
            <td><?php echo $program->episode ?></td>
        </tr><?php
            }
            if (strlen($program->airdate)) {
        ?><tr class="x-extras">
            <th><?php echo t('Original Airdate') ?>:</th>
            <td><?php echo $program->airdate ?></td>
        </tr><?php
            }
            if (strlen($program->programid) > 0) {
        ?><tr class="x-extras">
            <th><?php echo t('Program ID') ?>:</th>
            <td><?php echo $program->programid ?></td>
        </tr><?php
            }
            if ($program->get_credits('host', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Hosted by') ?>:</th>
            <td><?php echo $program->get_credits('host', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('presenter', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Presented by') ?>:</th>
            <td><?php echo $program->get_credits('presenter', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('actor', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Cast') ?>:</th>
            <td><?php echo $program->get_credits('actor', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('guest_star', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Guest Starring') ?>:</th>
            <td><?php echo $program->get_credits('guest_star', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('director', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Directed by') ?>:</th>
            <td><?php echo $program->get_credits('director', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('producer', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Produced by') ?>:</th>
            <td><?php echo $program->get_credits('producer', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('executive_producer', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Exec. Producer') ?>:</th>
            <td><?php echo $program->get_credits('executive_producer', TRUE) ?></td>
        </tr><?php
            }
            if ($program->get_credits('writer', TRUE)) {
        ?><tr class="x-extras">
            <th><?php echo t('Written by') ?>:</th>
            <td><?php echo $program->get_credits('writer', TRUE) ?></td>
        </tr><?php
            }
            if (strlen($program->starstring) > 0) {
        ?><tr class="x-extras">
            <th><?php echo t('Guide rating') ?>:</th>
            <td><?php echo $program->starstring ?></td>
        </tr><?php
            }
        ?><tr class="x-extras">
            <th><?php echo t('Length') ?>:</th>
            <td><?php echo nice_length($program->length) ?></td>
        </tr><?php
            if ($program->filename) {
        ?><tr class="x-extras">
            <th><?php echo t('File Size') ?>:</th>
            <td><?php echo nice_filesize($program->filesize) ?></td>
        </tr><?php
            }
            if (strlen($program->recgroup)) {
        ?><tr class="x-extras">
            <th><?php echo t('Recording Group') ?>:</th>
            <td><?php echo $program->recgroup ?></td>
        </tr><?php
            }
            if (strlen($program->playgroup)) {
        ?><tr class="x-extras">
            <th><?php echo t('Playback Group') ?>:</th>
            <td><?php echo $program->playgroup ?></td>
        </tr><?php
            }
        }
    // Can we perform an accurate duplicate check?
        $can_dupcheck = preg_match('/\S/', $program->title)
                        && preg_match('/\S/', $program->programid.$program->subtitle.$program->description);
        if (!empty($program->recstatus) || $can_dupcheck) {
        ?><tr id="x-status">
            <th><?php echo t('MythTV Status') ?>:</th>
            <td><?php
                if (!empty($program->recstatus)) {
                    echo $GLOBALS['RecStatus_Reasons'][$program->recstatus], '<br>';
                    if ($can_dupcheck && in_array($program->recstatus, array('Recorded', 'NeverRecord', 'PreviousRecording'))) {
                        echo '<a href="'.root_url.'tv/detail/'.$program->chanid
                            .'/'.$program->starttime.'?forget_old=yes"'
                            .'title="'.html_entities(t('info:forget old')).'">'
                            .t('Forget Old').'</a>';
                    }
                }
                if ($can_dupcheck && !in_array($program->recstatus, array('Recorded', 'NeverRecord'))) {
                    echo '<a href="'.root_url.'tv/detail/'.$program->chanid
                        .'/'.$program->starttime.'?never_record=yes"'
                        .'title="'.html_entities(t('info:never record')).'">'
                        .t('Never Record').'</a>';
                }
                if ($program->filename && $program->can_delete) {
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
        ?><tr id="x-conflicts">
            <th><?php echo t('Possible conflicts') ?>:<br><br>
        <div style="text-align: left;">
                <?php echo t('Filters'); ?><br>
            <form id="change_display" name="change_display" action="<?php echo root_url; ?>tv/detail<?php if ($_GET['recordid'])
                             echo '?recordid='.urlencode($_GET['recordid']);
                      else
                         echo '/'.urlencode($_GET['chanid']).'/'.urlencode($_GET['starttime']) ?>" method="post">
            <input type="hidden" name="change_display" value="1">

                <label for="CurrentRecording"><input type="checkbox" id="CurrentRecording" name="CurrentRecording" onclick="$('change_display').submit()" <?php if ($_SESSION['recording_details']['show_CurrentRecording']) echo "CHECKED"; ?>> <?php echo t('Current Recording'); ?></label><br>

                <label for="EarlierShowing"><input type="checkbox" id="EarlierShowing" name="EarlierShowing" onclick="$('change_display').submit()" <?php if ($_SESSION['recording_details']['show_EarlierShowing']) echo "CHECKED"; ?>> <?php echo t('Earlier Showing'); ?></label><br>

                <label for="PreviousRecording"><input type="checkbox" id="PreviousRecording" name="PreviousRecording" onclick="$('change_display').submit()" <?php if ($_SESSION['recording_details']['show_PreviousRecording']) echo "CHECKED"; ?>> <?php echo t('Previous Recording'); ?></label><br>

                <label for="WillRecord"><input type="checkbox" id="WillRecord" name="WillRecord" onclick="$('change_display').submit()" <?php if ($_SESSION['recording_details']['show_WillRecord']) echo "CHECKED"; ?>> <?php echo t('Will Record'); ?></label><br>

                <label for="Conflict"><input type="checkbox" id="Conflict" name="Conflict" onclick="$('change_display').submit()" <?php if ($_SESSION['recording_details']['show_Conflict']) echo "CHECKED"; ?>> <?php echo t('Conflicts'); ?></label><br>
                </div>
        </form>
        </th>
            <td><?php
        // A program id counter for popup info
            $program_id_counter = 0;
            foreach ($conflicting_shows as $show) {
                if (!isset($_SESSION['recording_details']['show_'.$show->recstatus]))
                    continue;
                $program_id_counter++;
            // Print the link to edit this scheduled recording
                echo '<a class="', $show->css_class,
                     '" title="', html_entities(t('$1 to $2',
                                                  strftime($_SESSION['time_format'], $show->starttime),
                                                  strftime($_SESSION['time_format'], $show->endtime))
                                                .', '.($_SESSION["prefer_channum"] ? $show->channel->channum : $show->channel->callsign)
                                                .' - '.$show->channel->name).'"';
                if ($_SESSION["show_popup_info"])
                    echo show_popup("program_$program_id_counter", $show->details_list(), NULL, 'popup');
                echo ' href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'
                    .$show->title
                    .(preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
                    .'</a>';
            }
            ?></td>
        </tr><?php
        }
        ?><tr class="x-links">
            <th><?php echo t('More') ?>:</th>
            <td>
<?php           if ($schedule->title) { ?>
                <a href="http://www.themoviedb.org/search/movie?query=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'themoviedb') ?></a>
                <a href="http://www.imdb.com/search/title?title=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'IMDB') ?></a>
                <a href="http://www.thetvdb.com/?string=<?php echo urlencode($schedule->title) ?>&searchseriesid=&tab=listseries&function=Search"><?php echo t('Search $1', 'TheTVDB') ?></a>
                <a href="http://www.tv.com/search.php?type=11&stype=all&qs=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'TV.com') ?></a>
                <a href="http://www.google.com/search?q=<?php echo urlencode($schedule->title) ?>"><?php echo t('Search $1', 'Google') ?></a>
                <a href="<?php echo root_url ?>tv/search/<?php echo str_replace('%2F', '/', rawurlencode('^'.$schedule->title.'$')) ?>?field=title"><?php
                    if ($_GET['recordid'])
                        echo t('Find showings of this program');
                    else
                        echo t('Find other showings of this program');
                ?></a>
<?php           }
                if ($_GET['recordid']) {
                    echo '<a href="',  root_url, 'tv/schedules">',
                         t('Back to the recording schedules'),
                         '</a>';
                    echo '<a href="', root_url, 'tv/list?time=', $_SESSION['list_time'], '">',
                         t('Back to the program listing'),
                         '</a>';
                }
                else {
                    if ($program->endtime > time()) {
                        echo '<a href="', root_url, 'tv/list?time=', $program->starttime, '">',
                             t('What else is on at this time?'),
                             '</a>';
                    }
                    if ($program->filename) {
                        echo '<a href="', root_url, 'tv/recorded">',
                             t('Back to the recorded programs'),
                             '</a>';
                    }
                    else {
                        echo '<a href="', root_url, 'tv/list?time=', $_SESSION['list_time'], '">',
                             t('Back to the program listing'),
                             '</a>';
                    }
                } ?>
                </td>
        </tr>
        </table>
    </div>

<?php if (!$program || !$program->filename || ($program->filename && $program->recendts > time())) { ?>
    <div id="schedule">
        <form name="program_detail" method="post" action="<?php echo root_url ?>tv/detail<?php
            if ($_GET['recordid'])
                echo '?recordid='.urlencode($_GET['recordid']);
            else
                echo '/'.urlencode($_GET['chanid']).'/'.urlencode($_GET['starttime'])
            ?>">

<?php   if (!$schedule || $schedule->type != rectype_override && $schedule->type != rectype_dontrec) { ?>
        <div class="x-options">
            <h3><?php echo t('Schedule Options') ?>:</h3>
<?php
            if ($program && $schedule) {
                echo '(<a href="'.root_url.'tv/';
            // Link to different places for different kinds of schedules
                if ($schedule->search) {
                    echo 'schedules/',
                         ($schedule->search == searchtype_manual) ? 'manual'
                                                                  : 'custom',
                         '/', $schedule->recordid;
                }
                else
                    echo 'detail?recordid='.$schedule->recordid;
                echo '">'.t('View').'</a>)';
            }
?>
            <ul>
                <li><input type="radio" class="radio" name="record" value="0" id="record_never"<?php
                        if (!$schedule->recordid || $schedule->search) echo ' CHECKED' ?> />
                    <label for="record_never"><?php
                        if ($schedule->search) {
                            echo t('Schedule via $1.',
                                   '<a href='.root_url.'tv/schedules/'
                                   .($schedule->search == searchtype_manual
                                        ? 'manual'
                                        : 'custom'
                                    )
                                   .'/'.$schedule->recordid.'>'
                                   .$schedule->search_title.'</a>');
                        }
                        elseif ($schedule->recordid)
                            echo t('Cancel this schedule.');
                        else
                            echo t('Don\'t record this program.');
                        ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_once ?>" id="record_once"<?php
                        echo $schedule->type == rectype_once ? ' CHECKED' : '' ?> />
                    <label for="record_once"><?php echo t('rectype-long: once') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_findone ?>" id="record_findone"<?php
                        echo $schedule->type == rectype_findone ? ' CHECKED' : '' ?> />
                    <label for="record_findone"><?php echo t('rectype-long: findone') ?></label></li>
                <li><input type="radio" class="radio" name="record" value="<?php echo rectype_always ?>" id="record_always"<?php
                        echo $schedule->type == rectype_always ? ' CHECKED' : '' ?> />
                    <label for="record_always"><?php echo t('rectype-long: always') ?></label></li>
            </ul>
        </div>
<?php
        }
        if ($schedule && $schedule->type != rectype_once && ($schedule->search || $schedule->type)) {
?>
        <div class="x-options">
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

        <div class="x-options">
<?php    require_once tmpl_dir.'_advanced_options.php' ?>
        </div>

        <div id="x-schedule_submit">
            <input type="submit" class="submit" name="save" value="<?php echo t('Update Recording Settings') ?>">
        </div>

        </form>

    </div>

<?php
    }
    if ($program && $program->filename) {
?>

        <div id="x-downloads">

            <div class="x-pixmap">
<?php   if (setting('WebFLV_on')) { ?>
<?php       if (file_exists('js/libs/flowplayer/flowplayer.swf')) { ?>


          <!-- this A tag is where your Flowplayer will be placed. it can be anywhere -->
            <a href=""
                style="display:block;width:<?php echo $flv_w ?>px;height:<?php echo $flv_h ?>px"
                id="player">
            </a>

            <!-- this will install flowplayer inside previous A- tag. -->
            <script>
                flowplayer(
                    "player",
                    "<?php echo root_url ?>js/libs/flowplayer/flowplayer.swf", {
                    playlist: [
                        // this first PNG clip works as a splash image
                        {
                            url: '<?php echo $program->thumb_url($flv_w,0) ?>',
                            scaling: 'orig'
                            },
                        // Then we have the video
                        {
                            url: "<?php echo video_url($program, 'flv'); ?>",
                            duration: <?php echo $program->length ?>,
                            autoPlay: false,
                            scaling: 'fit',
                            // Would be nice to auto-buffer, but we don't want to
                            // waste bandwidth and CPU on the remote machine.
                            autoBuffering: false
                            }
                        ]}
                    );
            </script>
<?php       } elseif (file_exists('modules/tv/MFPlayer.swf')) { ?>
                    <script language="JavaScript" type="text/javascript">
                    <!--
                    // Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
                    var hasProductInstall = DetectFlashVer(6, 0, 65);

                    // Version check based upon the values defined in globals
                    var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);

                    // Check to see if a player with Flash Product Install is available and the version does not meet the requirements for playback
                    if ( hasProductInstall && !hasRequestedVersion ) {
                        // MMdoctitle is the stored document.title value used by
                        // the installation process to close the window that
                        // started the process.   This is necessary in order to
                        // close browser windows that are still utilizing the
                        // older version of the player after installation has
                        // completed

                        // DO NOT MODIFY THE FOLLOWING FOUR LINES
                        // Location visited after installation is complete if
                        // installation is required
                        var MMPlayerType  = (isIE == true) ? "ActiveX" : "PlugIn";
                        var MMredirectURL = window.location;
                        var MMdoctitle    = document.title;
                        document.title    = document.title.slice(0, 47)
                                            +" - Flash Player Installation";

                        AC_FL_RunContent(
                                "src",              "playerProductInstall",
                                "FlashVars",        "MMredirectURL="+MMredirectURL
                                                    +'&MMplayerType='+MMPlayerType
                                                    +'&MMdoctitle='+MMdoctitle,
                                "width",            "<?php echo $flv_w ?>",
                                "height",           "<?php echo $flv_h ?>",
                                "align",            "middle",
                                "id",               "MFPlayer",
                                "quality",          "high",
                                "bgcolor",          "#869ca7",
                                "name",             "MFPlayer",
                                "allowScriptAccess","sameDomain",
                                "movie",            "<?php echo root_url; ?>tv/playerProductInstall",
                                "type",             "application/x-shockwave-flash",
                                "pluginspage",      "http://www.adobe.com/go/getflashplayer"
                            );
                    } else if (hasRequestedVersion) {
                        // If we've detected an acceptable version, embed
                        // the Flash Content SWF when all tests are passed
                        AC_FL_RunContent(
                                "src",              "MFPlayer",
                                "width",            "<?php echo $flv_w ?>",
                                "height",           "<?php echo $flv_h ?>",
                                "align",            "middle",
                                "id",               "MFPlayer",
                                "quality",          "high",
                                "bgcolor",          "#869ca7",
                                "name",             "MFPlayer",
                                "flashvars",'file=<?php     echo video_url($program, 'flv');
                                         ?>&still=<?php     echo $program->thumb_url($flv_w,$flv_h);
                                         ?>&totalTime=<?php echo $program->length;
                                         ?>&width=<?php     echo $flv_w;
                                         ?>&height=<?php    echo $flv_h;
                                         ?>&styles=<?php    echo root_url ?>tv/MFPlayer_styles.swf',
                                "allowScriptAccess","sameDomain",
                                "allowFullScreen",  "true",
                                "movie",            "<?php echo root_url; ?>tv/MFPlayer",
                                "type",             "application/x-shockwave-flash",
                                "pluginspage",      "http://www.adobe.com/go/getflashplayer"
                            );
                    } else {  // flash is too old or we can't detect the plugin
                        document.write('<img src="<?php echo $program->thumb_url($flv_w,0) ?>"'
                                      +' width="<?php echo $flv_w ?>"><br>'
                                      +'Web-based video playback requires the '
                                      +'<a href=http://www.adobe.com/go/getflash/>Adobe Flash Player</a>.'
                                      );
                    }
                    // -->
                    </script>
                    <noscript>
                    <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                        id="MFPlayer" width="<?php echo $flv_w ?>" height="<?php echo $flv_h ?>"
                        codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
                        <param name="movie" value="<?php echo root_url; ?>tv/MFPlayer.swf" />
                        <param name="quality" value="high" />
                        <param name="bgcolor" value="#869ca7" />
                        <param name="allowScriptAccess" value="sameDomain" />
                        <param name="allowFullScreen" value="true" />
                        <param name="FlashVars" value="file=<?php     echo video_url($program, 'flv');
                                                   ?>&still=<?php     echo $program->thumb_url($flv_w,$flv_h);
                                                   ?>&totalTime=<?php echo $program->length;
                                                   ?>&width=<?php     echo $flv_w;
                                                   ?>&height=<?php    echo $flv_h;
                                                   ?>&styles=<?php    echo root_url ?>tv/MFPlayer_styles.swf"
                                                   >
                        <embed src="<?php echo root_url; ?>tv/MFPlayer.swf" quality="high" bgcolor="#869ca7"
                            width="<?php echo $flv_w ?>" height="<?php echo $flv_h ?>" name="MFPlayer" align="middle"
                            play="true"
                            loop="false"
                            quality="high"
                            allowScriptAccess="sameDomain"
                            allowFullScreen="true"
                            FlashVars="file=<?php     echo video_url($program, 'flv');
                                   ?>&still=<?php     echo $program->thumb_url($flv_w,0);
                                   ?>&totalTime=<?php echo $program->length;
                                   ?>&width=<?php     echo $flv_w;
                                   ?>&height=<?php    echo $flv_h;
                                   ?>&styles=<?php    echo root_url ?>tv/MFPlayer_styles.swf"
                            type="application/x-shockwave-flash"
                            pluginspage="http://www.adobe.com/go/getflashplayer">
                        </embed>
                    </object>
                    </noscript>
<?php       } ?>
<?php   } else { ?>
                <a href="<?php echo $program->url ?>" title="<?php echo t('Direct Download') ?>"
                    ><img src="<?php echo $program->thumb_url($flv_w,0) ?>" width="<?php echo $flv_w ?>"></a>
<?php   } ?></td>
            </div>
            <div class="x-links">
                <a href="<?php echo video_url($program, 'asx') ?>" title="<?php echo t('ASX Stream') ?>"
                    ><img src="<?php echo skin_url ?>/img/play_sm.png">
                    <?php echo t('ASX Stream') ?></a>
                <a href="<?php echo $program->url ?>" title="<?php echo t('Direct Download') ?>"
                    ><img src="<?php echo skin_url ?>/img/video_sm.png">
                    <?php echo t('Direct Download') ?></a>
                <?php if (setting('WebFLV_on') && file_exists('modules/tv/MFPlayer.swf')) { ?>
                    <a onclick="openFlashPlayerInNewWindow(); return false;" title="<?php echo t('Pop-out player'); ?>">
                        <?php echo t('Pop-out player'); ?>
                    </a>
                <?php } ?>
            </div>
            <div class="x-jobs">
<?php
        if (count($program->jobs_possible)) {
            echo t('Queue a job'), ':',
                 '            <ul class="x-queue">';
            foreach ($program->jobs_possible as $id => $job) {
                echo '                <li>',
                     '<a href="',
                     root_url, 'tv/detail/', $program->chanid, '/', $program->recstartts,
                     '?job=', $id,
                     '">', $job, "</a></li>";
            }
            echo '            </ul>';
        }
        if (count($program->jobs['queue'])) {
            echo t('Queued jobs'), ':',
                 '            <ul class="-queued">';
            foreach ($program->jobs['queue'] as $job) {
                echo '                <li>',
                     $Jobs[$job['type']],
                     ' (', $Job_Status[$job['status']],
                     ':  ', strftime($_SESSION['date_listing_key'], $job['statustime']),
                     ')<br>',
                     html_entities($job['comment']),
                     '</li>';
            }
            echo '            </ul>';
        }
        if (count($program->jobs['done'])) {
            echo t('Recently completed jobs'), ':',
                 '            <ul class="-done">';
            foreach ($program->jobs['done'] as $job) {
                echo '                <li>',
                     $Jobs[$job['type']],
                     ' (', $Job_Status[$job['status']],
                     ':  ', strftime($_SESSION['date_listing_key'], $job['statustime']),
                     ')<br>',
                     html_entities($job['comment']),
                     '</li>';
            }
            echo '            </ul>';
        }
?>
            </div>

        <?php
            flush();
            $frontends = MythFrontend::findFrontends();
            if (is_array($frontends)) {
                echo '<div class="x-frontends">'.t('Play Recording on Frontend').':<ul>';
                    foreach ($frontends as $frontend)
                        echo '<li><a onclick="watchShow(\''.urlencode($frontend->getHost()).'\', \''.urlencode($program->chanid).'\', \''.urlencode($program->recstartts).'\');">'.$frontend->getHost().'</a><br>';
                echo '</ul></div>';
            }
        ?>

        </div>

<?php
    }
?>
    </div>
    </div>
<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
