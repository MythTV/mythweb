<?php
/**
 * Show recorded programs.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Recorded Programs');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_recorded.css">';

// Rss links
    $headers[] = '<link rel="alternate" type="application/rss+xml" href="'.str_replace(root_url, root_url.'rss/', $_SERVER['REQUEST_URI']).'">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Global variables used here
    global $All_Shows, $Total_Programs, $Total_Time, $Total_Used, $Groups, $Program_Titles;

// Show the recgroup?
    if (count($Groups) > 1)
        $recgroup_cols = 1;
    else
        $recgroup_cols = 0;

// Setup for grouping by various sort orders
    $group_field = $_SESSION['recorded_sortby'][0]['field'];
    if ($group_field == "")
        $group_field = "airdate";
    elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate") || ($group_field == "recgroup")) )
        $group_field = "";

?>

<form id="change_title" action="<?php echo root_url ?>tv/recorded" method="get">
<table id="title_choices" class="commandbox commands" border="0" cellspacing="0" cellpadding="4">
<tr>
<?php if (count($Groups) > 1) { ?>
    <td class="x-group"><?php echo t('Show group') ?>:</td>
    <td><select name="recgroup" onchange="$('change_title').submit()">
        <option value=""><?php echo t('All groups') ?></option><?php
        foreach($Groups as $recgroup => $count) {
            echo '<option id="Group '.htmlspecialchars($recgroup).'" value="'.htmlspecialchars($recgroup).'"';
            if ($_REQUEST['recgroup'] == $recgroup)
                echo ' SELECTED';
            echo '>'.html_entities($recgroup)
                .' ('.tn('$1 recording', '$1 recordings', $count)
                .')</option>';
        }
        ?>
    </select></td>
<?php
    }
?>
    <td class="x-recordings"><?php echo t('Show recordings') ?>:</td>
    <td><select name="title" onchange="$('change_title').submit()">
        <option id="All recordings" value=""><?php echo t('All recordings') ?></option>
<?php
        foreach($Program_Titles as $title => $count) {
            echo '<option id="Title '.htmlspecialchars($title).'" value="'.htmlspecialchars($title).'"';
            if ($_REQUEST['title'] == $title)
                echo ' SELECTED';
            echo '>'.html_entities($title)
                .($count > 1 ? ' ('.tn('$1 episode', '$1 episodes', $count).')' : "")
                ."</option>\n";
        }
?>
    </select></td>
</tr>
</table>
</form>
<table id="recorded_list" border="0" cellpadding="0" cellspacing="0" class="list small">
<tr class="menu">
    <td class="list"<?php if ($group_field) echo ' colspan="2"' ?>>&nbsp;</td>
    <th class="x-title"><?php             echo get_sort_link('title',           t('Title'))            ?></th>
    <th class="x-subtitle"><?php          echo get_sort_link('subtitle',        t('Subtitle'))         ?></th>
    <th class="x-seasep"><?php            echo get_sort_link('season',          t('Seas/Ep'))          ?></th>
    <th class="x-programid"><?php         echo get_sort_link('programid',       t('Program ID'))       ?></th>
    <th class="x-originalairdate"><?php   echo get_sort_link('originalairdate', t('Original Airdate')) ?></th>
    <th class="x-airdate"><?php           echo get_sort_link('airdate',         t('Airdate'))          ?></th>
    <th class="x-channum"><?php           echo get_sort_link('channum',         t('Channel'))          ?></th>
<?php
    if ($recgroup_cols)
        echo '    <th class="x-recgroup">', get_sort_link('recgroup', t('Recording Group')), "</td>\n";
?>
    <th class="x-length"><?php   echo get_sort_link('length',    t('Length'));    ?></th>
    <th class="x-filesize"><?php echo get_sort_link('file_size', t('File Size')); ?></th>
</tr><?php
    $row     = 0;
    $section = -1;
    $row_count = array();
    $row_section = array();

    $prev_group = '';
    $cur_group  = '';

    $offset = $_REQUEST['offset'];
    $rows = $offset;

    foreach ($All_Shows as $show) {
        flush();

        if (is_null($show))
            continue;

        if ($_SESSION['recorded_paging'] > 0 && $rows > 0) {
            $rows--;
            continue;
        }

    // Print a dividing row if grouping changes
        switch ($group_field) {
            case 'airdate':
                $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
                break;
            case 'recgroup':
                $cur_group = $show->recgroup;
                break;
            case 'channum':
                $cur_group = $show->channel->channum.' - '.$show->channel->name;
                break;
            case 'title':
                $cur_group = $show->title;
                break;
        }

        if ( $cur_group != $prev_group && $group_field != '' ) {
            $section++;
            $colspan = 11 + $recgroup_cols;
            print <<<EOM
<tr id="breakrow_$section" class="list_separator">
    <td colspan="$colspan" class="list_separator">$cur_group</td>
</tr>
EOM;
        }

        echo "<tr id=\"inforow_$row\" class=\"recorded inforow\">\n";
        if ($group_field != "")
            echo "    <td class=\"list\" rowspan=\"2\">&nbsp;</td>\n";
?>
    <td rowspan="2" class="x-pixmap<?php
        if ($_SESSION['recorded_pixmaps']) { ?>"><?php
        $padding = 39 - (50 / $show->getAspect());
        if ($padding > 0) { ?>
        <div style="height: <?php echo $padding; ?>px; width: 100px; float: left;">
        </div><?php } ?>
        <a class="x-pixmap" href="<?php echo root_url ?>tv/detail/<?php echo $show->chanid, '/', $show->recstartts ?>" title="<?php echo t('Recording Details') ?>"
            ><img src="<?php echo $show->thumb_url(100,0) ?>" width="100" height="<?php echo floor(100 / $show->getAspect()); ?>"></a>
<?php   }
        else
            echo ' -noimg">';
?>
        <a class="x-download"
            href="<?php echo video_url($show, true) ?>" title="<?php echo t('ASX Stream'); ?>"
            ><img height="24" width="24" src="<?php echo skin_url ?>/img/play_sm.png" alt="<?php echo t('ASX Stream'); ?>"></a>
        <a class="x-download"
            href="<?php echo $show->url ?>" title="<?php echo t('Direct Download'); ?>"
            ><img height="24" width="24" src="<?php echo skin_url ?>/img/video_sm.png" alt="<?php echo t('Direct Download'); ?>"></a>
        </td>
    <td class="x-title"><?php echo '<a href="', root_url, 'tv/detail/', $show->chanid, '/', $show->recstartts, '"'
                    .($_SESSION['recorded_pixmaps'] ? '' : " name=\"$row\"")
                    .' title="', t('Recording Details'), '"'
                    .'>'.$show->title.'</a>' ?></td>
    <td class="x-subtitle"><?php echo '<a href="', root_url, 'tv/detail/', $show->chanid, '/', $show->recstartts, '"'
                    .' title="', t('Recording Details'), '"'
                    .'>'.$show->subtitle.'</a>' ?></td>
    <td class="x-seasep"><?php if ($show->episode > 0) {echo $show->season,'x',str_pad($show->episode,2,"0",STR_PAD_LEFT);} ?></td>
    <td class="x-programid"><?php echo $show->programid ?></td>
    <td class="x-originalairdate"><?php echo $show->airdate ?></td>
    <td class="x-airdate"><?php echo strftime($_SESSION['date_recorded'], $show->starttime) ?></td><?php
        if ($_SESSION["show_channel_icons"] == true && !empty($show->channel->icon)) {
    ?><td class="x-chanicon" rowspan="2"><a href="<?php echo root_url ?>tv/channel/<?php echo $show->channel->chanid, '/', $list_starttime ?>"
                    title="<?php echo t('Details for: $1', html_entities($show->channel->name)) ?>">
                    <img class="channelicon" src="<?php echo $show->channel->icon ?>"></a></td><?php
        } else { ?>
    <td class="x-channum" rowspan="2"><?php echo $show->channel->channum, ' - ', $show->channel->name ?></td><?php
        }
    if ($recgroup_cols)
        echo "    <td class=\"-recgroup\">$show->recgroup</td>\n";
?>
    <td class="x-length"><?php echo nice_length($show->length) ?></td>
    <td class="x-filesize"><?php echo nice_filesize($show->filesize) ?></td>
    <td class="x-commands commands" rowspan="2"><?php
        if ($show->is_recording) {
            echo '<a href="', root_url, 'tv/detail/', $show->chanid, '/', $show->recstartts, '">',
                 t('Still Recording: Edit'),
                 "</a>\n        ";
        }
        if ($show->can_delete) {
        ?><a onclick="javascript:confirm_delete(<?php echo $row+$offset ?>, false)"
            title="<?php echo html_entities(t('Delete $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php if (get_backend_setting('AutoExpireInsteadOfDelete') > 0 &&
                       $show->recgroup == 'Deleted')
                        echo t('Delete Forever');
                    else
                        echo t('Delete');
              ?></a>
        <a onclick="javascript:confirm_delete(<?php echo $row+$offset ?>, true)"
            title="<?php echo html_entities(t('Delete and allow rerecord: $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete + Rerecord') ?></a>

<?php       if ($show->recgroup == 'Deleted') {
                echo '<a href="', root_url, 'tv/recorded?undelete=yes&chanid=', $show->chanid,
                    '&starttime=', $show->recstartts, '" ' ?>
                title="<?php echo html_entities(t('Undelete: $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
                <?php echo '>' , t('Undelete') ?></a>
<?php       } ?>
<?php   } ?>
        </td>
</tr><tr id="statusrow_<?php echo $row ?>" class="recorded statusrow">
    <td colspan="6" valign="top"><?php echo $show->description ?></td>
    <td colspan="<?php echo 2 + $recgroup_cols ?>" class="x-progflags"><?php
        // Auto expire is interactive
            echo '<a onclick="set_autoexpire(', $row, ')" class="_autoexpire">',
                 '<img id="autoexpire_', $row, '" src="', skin_url, '/img/flags/';
            if ($show->auto_expire)
                echo 'autoexpire.png" title="', t('Click to disable Auto Expire'), '"';
            else
                echo 'no_autoexpire.png" title="', t('Click to enable Auto Expire'), '"';
            echo ' alt=""></a>';
        // The rest of the flags are just for display
            if ($show->closecaptioned)
                echo '<img src="'.skin_url.'/img/flags/cc.png"          title="'.t('Closed Captioning').'"   alt="">';
            if ($show->stereo)
                echo '<img src="'.skin_url.'/img/flags/stereo.png"      title="'.t('Stereo').'"              alt="">';
            if ($show->hdtv)
                echo '<img src="'.skin_url.'/img/flags/hd.png"         height=18 title="'.t('HD').'"                  alt="">';
            if ($show->hd_ready)
                echo '<img src="'.skin_url.'/img/flags/hd720.png"      height=18    title="'.t('720').'"                  alt="">';
            if ($show->fullhd)
                echo '<img src="'.skin_url.'/img/flags/hd1080.png"     height=18     title="'.t('1080').'"                  alt="">';
            if ($show->damaged)
                echo '<img src="'.skin_url.'/img/flags/damaged.png"    height=22      title="'.t('Damaged').'"                  alt="">';
            if ($show->has_commflag)
                echo '<img src="'.skin_url.'/img/flags/commflagged.png" title="'.t('Commercials Flagged').'" alt="">';
            if ($show->has_cutlist)
                echo '<img src="'.skin_url.'/img/flags/cutlist.png"     title="'.t('Has Cutlist').'"         alt="">';
            if ($show->bookmark)
                echo '<img src="'.skin_url.'/img/flags/bookmark.png"    title="'.t('has Bookmark').'"        alt="">';
            if ($show->is_watched)
                echo '<img src="'.skin_url.'/img/flags/watched.png"     title="'.t('Watched').'"             alt="">';
            if ($show->is_transcoded)
                echo '<img src="'.skin_url.'/img/flags/transcoded.png"     title="'.t('Transcoded').'"             alt="">';
        ?></td>
</tr><?php
        $prev_group = $cur_group;
    // Keep track of how many shows are visible in each section
        $row_count[$section]++;
    // Keep track of which shows are in which section
        $row_section[$row] = $section;
    // Increment row last
        $row++;
    // Only display as many as requested
        if ($_SESSION['recorded_paging'] > 0 && $row >= $_SESSION['recorded_paging'])
            break;
    }
?>

</table>

<div id="recorded_pager">
<?php
    if ($_SESSION['recorded_paging'] > 0) {
        echo 'Pages - ';
        $total_pages = ceil(count($All_Shows)/$_SESSION['recorded_paging']);
        $current_page = $_REQUEST['offset'] / $_SESSION['recorded_paging'];
        for ($i = 1; $i <= $total_pages; $i++) {
            $query = '';
            foreach($_GET as $key => $value) {
                if ($key == 'offset')
                    continue;
                $query .= urlencode($key).'='.urlencode($value).'&';
            }
            $query .= 'offset='.(($i-1)*$_SESSION['recorded_paging']);
            if ($i != 1)
                echo ' | ';
            echo '<a href="'.root_url.'tv/recorded?'.$query.'">'.$i.'</a>';
        }
    }
?>
</div>

<script type="text/javascript">
<!--

// Some initial values for global counters
    var diskused       = parseInt('<?php echo addslashes(disk_used) ?>');
    var programcount   = parseInt('<?php echo addslashes($Total_Programs) ?>');
    var programs_shown = parseInt('<?php echo count($All_Shows) ?>');
    var totaltime      = parseInt('<?php echo addslashes($Total_Time) ?>');

// Initialize some variables that will get set after the page table is printed
    var rowcount     = new Array();
    var rowsection   = new Array();
    var titles       = new Object;
    var groups       = new Object;

// Load the known shows
    var file  = null;
    var files = new Array();

<?php
    foreach ($All_Shows as $show) {
?>
    file = new Object();
    file.title      = '<?php echo addslashes($show->title)                  ?>';
    file.subtitle   = '<?php echo str_replace("\n", '', nl2br(addslashes($show->subtitle)))               ?>';
    file.chanid     = '<?php echo addslashes($show->chanid)                 ?>';
    file.starttime  = '<?php echo addslashes($show->recstartts)             ?>';
    file.recgroup   = '<?php echo addslashes(str_replace('%2F', '/', rawurlencode($show->recgroup)))    ?>';
    file.filename   = '<?php echo addslashes(str_replace('%2F', '/', rawurlencode($show->filename)))    ?>';
    file.size       = '<?php echo addslashes($show->filesize)               ?>';
    file.length     = '<?php echo addslashes($show->recendts - $show->recstartts) ?>';
    file.autoexpire = <?php echo $show->auto_expire ? 1 : 0                 ?>;
    files.push(file);

<?php
    }
?>

// Set the autoexpire flag
    function set_autoexpire(id) {
        var file = files[id];
        var r = new Ajax.Request('<?php echo root_url ?>tv/detail/' + file.chanid + '/' + file.starttime,
                                 {
                                    parameters: 'toggle_autoexpire='+(1 - file.autoexpire),
                                  asynchronous: false
                                 });
        if (r.transport.responseText == 'success') {
        // Update to the new value
            file.autoexpire = 1 - file.autoexpire;
        // Fix the images
            $('autoexpire_'+id).src = '<?php echo skin_url, '/img/flags/' ?>'
                                      + (file.autoexpire
                                         ? ''
                                         : 'no_')
                                      + 'autoexpire.png';
            if (file.autoexpire)
                $('autoexpire_'+id).title = '<?php echo addslashes(t('Click to disable Auto Expire')) ?>';
            else
                $('autoexpire_'+id).title = '<?php echo addslashes(t('Click to enable Auto Expire')) ?>';
        }
        else if (r.transport.responseText) {
            alert('Error: '+r.transport.responseText);
        }
    }

    function confirm_delete(id, forget_old) {
        var file = files[id];
        if (confirm("<?php echo t('Are you sure you want to delete the following show?')
                    ?>\n\n     "+file.title + ((file.subtitle == '') ? "" : ": " +file.subtitle))) {
        // Do the actual deletion
            if (programs_shown == 1)
                location.href = '<?php echo root_url ?>tv/recorded?delete=yes&chanid='+file.chanid
                                +'&starttime='+file.starttime
                                +(forget_old
                                    ? '&forget_old=yes'
                                    : ''
                                 );
            else {
                ajax_add_request();
                new Ajax.Request('<?php echo root_url; ?>tv/recorded',
                                 {
                                    method: 'post',
                                    onSuccess: http_success,
                                    onFailue: http_failure,
                                    parameters: { ajax:       'yes',
                                                  'delete':   'yes',
                                                  chanid:     file.chanid,
                                                  starttime:  file.starttime,
                                                  forget_old: (forget_old ? 'yes' : ''),
                                                  id:         id,
                                                  file:       Object.toJSON(file)
                                                }
                                });
            }
        // Debug statements - uncomment to verify that the right file is being deleted. Now with firebug goodness
            //console.log('row number ' + id + ' belonged to section ' + section + ' which now has ' + rowcount[section] + ' elements');
            //console.log('just deleted an episode of "' + title + '" which now has ' + episode_count + ' episodes left');
        }
    }

    function http_success(result) {
        var id   = result.responseJSON['id'];
        var file = result.responseJSON['file'].evalJSON();
    // Hide the row from view
        $('inforow_' + id).toggle();
        $('statusrow_' + id).toggle();
    // decrement the number of rows in a section
        var section   = rowsection[id];
        rowcount[section]--;
    // Decrement the number of episodes for this title
        titles[file.title]--;
        var episode_count = titles[file.title]
    // If we just hid the only row in a section, then hide the section break above it as well
        if (rowcount[section] == 0) {
            $('breakrow_' + section).toggle();
        }
// UGLY! but works well enough...
    <?php if (count($Groups) > 1) { ?>
    // Change the recording groups dropdown on the fly.
        if (file.recgroup) {
        // Decrement the number of episodes for this group
            groups[file.recgroup]--;
            var group_count = groups[file.recgroup]
        // Change the groups dropdown menu on the fly
            if (group_count == 0) {
                $('Group ' + file.recgroup).toggle();
            }
            else {
                var group_text;
                group_text = (group_count > 1) ? ' (' + group_count + ' episodes)' : '';
                $('Group ' + file.recgroup).innerHTML = file.recgroup + group_text;
            }
        }
    <?php } ?>
    // Change the recordings dropdown menu on the fly
        if (episode_count == 0) {
            $('Title ' + file.title).toggle();
        }
        else {
            var count_text;
            count_text = (episode_count > 1) ? ' (' + episode_count + ' episodes)' : '';
            $('Title ' + file.title).innerHTML = file.title + count_text;
        }
    // Decrement the total number of shows and update the page
        programs_shown--;
        programcount--;
        $('programcount').innerHTML = programcount;
    // Decrease the total amount of time by the amount of the show
        totaltime -= file.length;
        $('totaltime').innerHTML = nice_length(totaltime, <?php
                                                         echo "'", addslashes(t('$1 hr')),   "', ",
                                                              "'", addslashes(t('$1 hrs')),  "', ",
                                                              "'", addslashes(t('$1 min')),  "', ",
                                                              "'", addslashes(t('$1 mins')), "'";
                                                         ?>);
    // Decrease the disk usage indicator by the amount of the show
        diskused -= file.size;
        $('diskused').innerHTML = nice_filesize(diskused);
    // Adjust the freespace shown
        $('diskfree').innerHTML = nice_filesize(<?php echo disk_size; ?> - diskused);
        // Eventually, we should perform the removal-from-the-list here instead
        // of in confirm_delete()
        ajax_remove_request();
    }

    function http_failure(err, errstr) {
        var file = result.responseJSON['file'].evalJSON();
        alert("Can't delete "+file.title+': '+file.subtitle+".\nHTTP Error:  " + errstr + ' (' + err + ')');
        ajax_remove_request();
    }

// -->
</script>

<script type="text/javascript">
<?php
    foreach ($row_count as $count)
        echo 'rowcount.push(['.escape($count)."]);\n";

    foreach ($row_section as $section)
        echo 'rowsection.push(['.escape($section)."]);\n";

    foreach($Program_Titles as $title => $count)
        echo 'titles['.escape($title).'] = '.escape($count).";\n";

    foreach($Groups as $recgroup => $count)
        echo 'groups['.escape($recgroup).'] = '.escape($count).";\n";
?>
</script>

<?php

    echo '<div style="padding-right: 75px; text-align: right; float: right; padding-top: 1em;">'
        .t('$1 programs, using $2 ($3) out of $4 ($5 free).',
           '<span id="programcount">'.t($Total_Programs).'</span>',
           '<span id="diskused">'.nice_filesize($Total_Used).'</span>',
           '<span id="totaltime">'.nice_length($Total_Time).'</span>',
           '<span id="disksize">'.nice_filesize(disk_size).'</span>',
           '<span id="diskfree">'.nice_filesize(disk_size - disk_used).'</span>'
          )
        .'</div>';

    echo '<div id="feed_buttons"><a href="rss'.$_SERVER['REQUEST_URI'].'"><img src="'.skin_url.'/img/rss2.0.gif"></a></div>';

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
