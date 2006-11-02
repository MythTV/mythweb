<?php
/**
 * Show recorded programs.
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
    $page_title = 'MythWeb - '.t('Recorded Programs');

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Global variables used here
    global $All_Shows, $Total_Programs, $Total_Time, $Total_Used,
           $Groups,    $Program_Titles;
?>

<script language="JavaScript" type="text/javascript">
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
    file.title     = '<?php echo addslashes($show->title)                  ?>';
    file.subtitle  = '<?php echo addslashes($show->subtitle)               ?>';
    file.chanid    = '<?php echo addslashes($show->chanid)                 ?>';
    file.starttime = '<?php echo addslashes($show->recstartts)             ?>';
    file.group     = '<?php echo addslashes(str_replace('%2F', '/', rawurlencode($show->group)))    ?>';
    file.filename  = '<?php echo addslashes(str_replace('%2F', '/', rawurlencode($show->filename))) ?>';
    file.size      = '<?php echo addslashes($show->filesize)               ?>';
    file.length    = '<?php echo addslashes($show->recendts - $show->recstartts) ?>';
    files.push(file);

<?php
    }
?>

    function set_autoexpire(id) {
        var file = files[id];
        submit_url('<?php echo root ?>tv/recorded?ajax&autoexpire='+
                   +(get_element('autoexpire_' + file.chanid + '.' + file.starttime).checked ? '1' : '0')
                   +'&chanid='+file.chanid+'&starttime='+file.starttime);
    }

    function confirm_delete(id, forget_old) {
        var file = files[id];
        if (confirm("<?php echo t('Are you sure you want to delete the following show?') ?>\n\n     "+file.title+": "+file.subtitle)) {
        // Do the actual deletion
            if (programs_shown == 1)
                location.href = '<?php echo root ?>tv/recorded?delete=yes&chanid='+file.chanid+'&starttime='+file.starttime;
            else
                submit_url('<?php echo root ?>tv/recorded?ajax&delete=yes&chanid='+file.chanid+'&starttime='+file.starttime,
                           http_success, http_failure, id, file);
        // Debug statements - uncomment to verify that the right file is being deleted
            //alert('row number ' + id + ' belonged to section ' + section + ' which now has ' + rowcount[section] + ' elements');
            //alert('just deleted an episode of "' + title + '" which now has ' + episode_count + ' episodes left');
        }
    }

    function http_success(result, args) {
        var id   = args.shift();
        var file = args.shift();
    // Hide the row from view
        toggle_vis('inforow_' + id,   'display');
        toggle_vis('statusrow_' + id, 'display');
        toggle_vis('descunderrow_' + id, 'display');
    // decrement the number of rows in a section
        var section   = rowsection[id];
        rowcount[section]--;
    // Decrement the number of episodes for this title
        titles[file.title]--;
        var episode_count = titles[file.title]
    // If we just hid the only row in a section, then hide the section break above it as well
        if (rowcount[section] == 0) {
            toggle_vis('breakrow_' + section, 'display');
        }
    // Change the recordings dropdown menu on the fly
        if (episode_count == 0) {
            toggle_vis('Title ' + file.title, 'display');
        }
        else {
            var count_text;
            count_text = (episode_count > 1) ? ' (' + episode_count + ' episodes)' : '';
            get_element('Title ' + file.title).innerHTML = file.title + count_text;
        }
    // TODO: test changing the groups dropdown on the fly.
    // I can't test it because I haven't set up any recording groups, and probably never will
        if (file.group) {
        // Decrement the number of episodes for this group
            groups[file.group]--;
            var group_count = titles[file.title]
        // Change the groups dropdown menu on the fly
            if (group_count == 0) {
                toggle_vis('Group ' + file.group, 'display');
            }
            else {
                var count_text;
                group_text = (group_count >1) ? ' (' + group_count + ' episodes)' : '';
                get_element('Group ' + file.group).innerHTML = file.group + group_text;
            }
        }
    // Decrement the total number of shows and update the page
        programs_shown--;
        programcount--;
        get_element('programcount').innerHTML = programcount;
    // Decrease the total amount of time by the amount of the show
        totaltime -= file.length;
        get_element('totaltime').innerHTML = nice_length(totaltime, <?php
                                                         echo "'", addslashes(t('$1 hr')),   "', ",
                                                              "'", addslashes(t('$1 hrs')),  "', ",
                                                              "'", addslashes(t('$1 min')),  "', ",
                                                              "'", addslashes(t('$1 mins')), "'";
                                                         ?>);
    // Decrease the disk usage indicator by the amount of the show
        diskused -= file.size;
        get_element('diskused').innerHTML = nice_filesize(diskused);
    // Adjust the freespace shown
        get_element('diskfree').innerHTML = nice_filesize(<?php echo disk_size ?> - diskused);
        // Eventually, we should perform the removal-from-the-list here instead
        // of in confirm_delete()
    }

    function http_failure(err, errstr, args) {
        var file = args[0];
        alert("Can't delete "+file.title+': '+file.subtitle+".\nHTTP Error:  " + errstr + ' (' + err + ')');
    }

// -->
</script>

<p>
<form id="program_titles" action="<?php echo root ?>tv/recorded" method="get">
<table class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
<?php if (count($Groups) > 1) { ?>
    <td><?php echo t('Show group') ?>:</td>
    <td><select name="recgroup" onchange="get_element('program_titles').submit()">
        <option value=""><?php echo t('All groups') ?></option><?php
        foreach($Groups as $recgroup => $count) {
            echo '<option id="Group '.htmlspecialchars($recgroup).'" value="'.htmlspecialchars($recgroup).'"';
            if ($_GET['recgroup'] == $recgroup)
                echo ' SELECTED';
            echo '>'.html_entities($recgroup)
                .' ('.tn('$1 recording', '$1 recordings', $count)
                .')</option>';
        }
        ?>
    </select></td>
<?php   $recgroup_cols = 1;
    } else {
        $recgroup_cols = 0;
    } ?>
    <td><?php echo t('Show recordings') ?>:</td>
    <td width="250" align="center"><select name="title" onchange="get_element('program_titles').submit()">
        <option id="All recordings" value=""><?php echo t('All recordings') ?></option>
<?php
        foreach($Program_Titles as $title => $count) {
            echo '<option id="Title '.htmlspecialchars($title).'" value="'.htmlspecialchars($title).'"';
            if ($_GET['title'] == $title)
                echo ' SELECTED';
            echo '>'.html_entities($title)
                .($count > 1 ? ' ('.tn('$1 episode', '$1 episodes', $count).')' : "")
                ."</option>\n";
        }
?>
    </select></td>
    <td><noscript><input type="submit" value="<?php echo t('Go') ?>"></noscript></td>
</tr>
</table>
</form>
</p>

<?php
// Setup for grouping by various sort orders
$group_field = $_GET['sortby'];
if ($group_field == "") {
    $group_field = "airdate";
} elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate") || ($group_field == "recgroup")) ) {
    $group_field = "";
}

?>

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
<?php
    if ($group_field != "")
        echo "\t<td class=\"list\">&nbsp;</td>\n";
    if ($_SESSION['recorded_pixmaps'])
        echo "\t<td>".t('preview')."</td>\n";
?>
    <td><?php echo get_sort_link('title',    t('title')) ?></td>
    <td><?php echo get_sort_link('subtitle', t('subtitle')) ?></td>
<?php
    if (!$_SESSION['recorded_descunder'])
        echo "\t<td>".get_sort_link('description', t('description'))."</td>\n";
?>
    <td><?php echo get_sort_link('channum',   t('channum')) ?></td>
<?php
    if ($recgroup_cols)
        echo "\t<td>" . get_sort_link('recgroup', t('recgroup')) . "</td>\n";
?>
    <td><?php echo get_sort_link('airdate',   t('airdate')) ?></td>
    <td><?php echo get_sort_link('length',    t('length')) ?></td>
    <td><?php echo get_sort_link('file_size', t('file size')) ?></td>
</tr><?php
    $row     = 0;
    $section = -1;

    $prev_group = '';
    $cur_group  = '';

    foreach ($All_Shows as $show) {

    // Print a dividing row if grouping changes
        switch ($group_field) {
            case 'airdate':
                $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
                break;
            case 'recgroup':
                $cur_group = $show->recgroup;
                break;
            case 'channum':
                $cur_group = $show->channel->name;
                break;
            case 'title':
                $cur_group = $show->title;
                break;
        }

        if ( $cur_group != $prev_group && $group_field != '' ) {
            $section++;
            $colspan = 9 + $recgroup_cols;
            print <<<EOM
<tr id="breakrow_$section" class="list_separator">
    <td colspan="$colspan" class="list_separator">$cur_group</td>
</tr>
EOM;
        }

        echo "<tr id=\"inforow_$row\" class=\"recorded\">\n";
        if ($group_field != "")
            echo "\t<td class=\"list\" rowspan=\"".($_SESSION['recorded_descunder'] ? 3 : 2)."\">&nbsp;</td>\n";
        if ($_SESSION['recorded_pixmaps']) {
            echo "\t<td rowspan=\"".($_SESSION['recorded_descunder'] ? 3 : 2).'">';
            if (file_exists(cache_dir.'/'.basename($show->filename).'.png')) {
                list($width, $height, $type, $attr) = getimagesize(cache_dir.'/'.basename($show->filename).'.png');
                echo "<a href=\"$show->url\" name=\"$row\">"
                    .'<img id="'.$show->filename.'" src="'.$show->thumb_url.'.png" '.$attr.' border="0">'
                    .'</a>';
            }
            else
                echo "<a name=\"$row\">&nbsp;</a>";
            echo "</td>\n";
        }
    ?>
    <td><?php echo '<a href="'.$show->url.'"'
                    .($_SESSION['recorded_pixmaps'] ? '' : " name=\"$row\"")
                    .'>'.$show->title.'</a>' ?></td>
    <td><?php echo "<a href=\"$show->url\">"
                    .$show->subtitle.'</a>' ?></td>
<?php
        if (!$_SESSION['recorded_descunder'])
            echo "\t<td>".$show->description."</td>\n";
?>
    <td><?php echo $show->channel->channum, ' - <nobr>', $show->channel->name ?></nobr></td>
<?php
    if ($recgroup_cols)
        echo "\t<td nowrap align=\"center\">$show->recgroup</td>\n";
?>
    <td nowrap align="center"><?php echo strftime($_SESSION['date_recorded'], $show->starttime) ?></td>
    <td nowrap><?php echo nice_length($show->length) ?></td>
    <td nowrap><?php echo nice_filesize($show->filesize) ?></td>
<?php   if ($show->endtime > time()) { ?>
    <td width="5%">currently recording</td>
<?php   } else { ?>
    <td width="5%" rowspan="<?php echo $_SESSION['recorded_descunder'] ? 2 : 1 ?>" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <a id="delete_<?php echo $row ?>"
            href="<?php echo root ?>tv/recorded?delete=yes&chanid=<?php echo $show->chanid ?>&starttime=<?php echo $show->recstartts ?>"
            js_href="javascript:confirm_delete(<?php echo $row ?>, false)";
            title="<?php echo html_entities(t('Delete $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete') ?></a>
    </td>
<?php   }

        if ($_SESSION['recorded_descunder'])
            echo("</tr><tr id=\"descunderrow_".$row."\" class=\"recorded\">\n\t<td colspan=\"" . (6 + $recgroup_cols) . "\">".$show->description."</td>\n");
?>
</tr><tr id="statusrow_<?php echo $row ?>" class="recorded">
    <td nowrap colspan="<?php echo 6 + ($_SESSION['recorded_descunder'] ? 0 : 1) + $recgroup_cols ?>" align="center">
        <span style="padding-right: 25px"><?php echo t('has commflag') ?>:&nbsp;
            <b><?php echo $show->has_commflag ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('has cutlist') ?>:&nbsp;
            <b><?php echo $show->has_cutlist ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('is editing') ?>:&nbsp;
            <b><?php echo $show->is_editing ? t('Yes') : t('No') ?></b></span>
        <span style="padding-right: 25px"><?php echo t('auto-expire') ?>:&nbsp;
            <input type="checkbox" id="autoexpire_<?php echo $show->chanid, '.', $show->recstartts ?>"
             name="autoexpire_<?php echo $show->chanid, '.', $show->recstartts ?>"
             <?php if ($show->auto_expire) echo ' CHECKED' ?> onclick="set_autoexpire(<?php echo $row ?>)" />
            </span>
        <span style="padding-right: 25px"><?php echo t('has bookmark') ?>:&nbsp;
            <b><?php echo $show->bookmark ? t('Yes') : t('No') ?></b></span>
        <?php echo t('has been watched') ?>:&nbsp;
            <b><?php echo $show->is_watched ? t('Yes') : t('No') ?></b>
        </td>
    <td width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center">
        <a id="delete_rerecord_<?php echo $row ?>"
            href="<?php echo root ?>tv/recorded?delete=yes&chanid=<?php echo $show->chanid ?>&starttime=<?php echo $show->recstartts ?>&forget_old"
            js_href="javascript:confirm_delete(<?php echo $row ?>, true)";
            title="<?php echo html_entities(t('Delete and rerecord $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete + Rerecord') ?></a></td>
    </td>
</tr><?php
        $prev_group = $cur_group;
    // Keep track of how many shows are visible in each section
        $row_count[$section]++;
    // Keep track of which shows are in which section
        $row_section[$row] = $section;
    // Increment row last
        $row++;
    }
?>

</table>

<script language="JavaScript" type="text/javascript">
<?php
    foreach ($row_count as $count) {
        echo 'rowcount.push(['.escape($count)."]);\n";
    }
    foreach ($row_section as $section) {
        echo 'rowsection.push(['.escape($section)."]);\n";
    }
    foreach($Program_Titles as $title => $count) {
        echo 'titles['.escape($title).'] = '.escape($count).";\n";
    }
    foreach($Groups as $recgroup => $count) {
        echo 'groups['.escape($recgroup).'] = '.escape($count).";\n";
    }
?>
</script>

<?php
    echo '<p align="right" style="padding-right: 75px">'
        .t('$1 programs, using $2 ($3) out of $4 ($5 free).',
           '<span id="programcount">'.t($Total_Programs).'</span>',
           '<span id="diskused">'.nice_filesize($Total_Used).'</span>',
           '<span id="totaltime">'.nice_length($Total_Time).'</span>',
           '<span id="disksize">'.nice_filesize(disk_size).'</span>',
           '<span id="diskfree">'.nice_filesize(disk_size - disk_used).'</span>'
          )
        .'</p>';

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';


