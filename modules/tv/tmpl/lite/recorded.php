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
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/recorded.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Global variables used here
    global $All_Shows, $Total_Programs, $Total_Time, $Total_Used,
           $Groups,    $Program_Titles;

// Show the recgroup?
    if (count($Groups) > 1) {
        $recgroup_cols = 1;
    }
    else {
        $recgroup_cols = 0;
    }

// Setup for grouping by various sort orders
    $group_field = $_SESSION['recorded_sortby'][0]['field'];
    if ($group_field == "") {
        $group_field = "airdate";
    } elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "airdate") || ($group_field == "recgroup")) ) {
        $group_field = "";
    }

?>

<form id="change_title" action="<?php echo root_url ?>tv/recorded" method="get">
<table id="title_choices" class="command command_border_l command_border_t command_border_b command_border_r" border="0" cellspacing="0" cellpadding="4" align="center">
<tr>
<?php if (count($Groups) > 1) { ?>
    <td><?php echo t('Show group') ?>:</td>
    <td><select name="recgroup">
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
<?php
    }
?>
    <td><?php echo t('Show recordings') ?>:</td>
    <td width="250" align="center"><select name="title">
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
    <td><input type="submit" value="<?php echo t('Go') ?>"></td>
</tr>
</table>
</form>

<table id="recorded_list" border="0" cellpadding="0" cellspacing="0" class="list small">
<tr class="menu">
<?php
    if ($group_field != "")
        echo "    <td class=\"list\" colspan=\"2\">&nbsp;</td>\n";
?>
    <th class="x-title"><?php     echo get_sort_link('title',     t('Title')) ?></td>
    <th class="x-subtitle"><?php  echo get_sort_link('subtitle',  t('Subtitle')) ?></td>
    <th class="x-programid"><?php echo get_sort_link('programid', t('Program ID')) ?></td>
    <th class="x-channum"><?php   echo get_sort_link('channum',   t('Channel')) ?></td>
    <th class="x-airdate"><?php   echo get_sort_link('airdate',   t('Airdate')) ?></td>
<?php
    if ($recgroup_cols)
        echo '    <th class="x-recgroup">', get_sort_link('recgroup', t('Recording Group')), "</td>\n";
?>
    <th class="x-length"><?php        echo get_sort_link('length',    t('Length')) ?></td>
    <th class="x-filesize"><?php echo get_sort_link('file_size', t('File Size')) ?></td>
</tr><?php
    $row     = 0;
    $section = -1;
    $row_count = array();
    $row_section = array();

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
                $cur_group = $show->channel->channum;
                break;
            case 'title':
                $cur_group = $show->title;
                break;
        }

        if ( $cur_group != $prev_group && $group_field != '' ) {
            $section++;
            $colspan = 10 + $recgroup_cols;
            print <<<EOM
<tr id="breakrow_$section" class="list_separator">
    <td colspan="$colspan" class="list_separator">$cur_group</td>
</tr>
EOM;
        }

        echo "<tr id=\"inforow_$row\" class=\"recorded\">\n";
        if ($group_field != "")
            echo "    <td class=\"list\" rowspan=\"2\">&nbsp;</td>\n";
?>
    <td rowspan="2" class="x-pixmap">
        <a class="x-pixmap" href="<?php echo $show->url ?>" title="<?php echo t('Direct Download') ?>"
            ><img src="<?php echo $show->thumb_url(100,0) ?>"></a>
        <a class="x-download"
            href="<?php echo video_url($show, true) ?>" title="<?php echo t('ASX Stream') ?>"
            ><img src="<?php echo skin_url ?>/img/play_sm.png"></a>
        <a class="x-download"
            href="<?php echo $show->url ?>" title="<?php echo t('Direct Download') ?>"
            ><img src="<?php echo skin_url ?>/img/video_sm.png"></a>
        </td>
    <td class="x-title"><?php echo '<a href="'.$show->url.'"'
                    .($_SESSION['recorded_pixmaps'] ? '' : " name=\"$row\"")
                    .'>'.$show->title.'</a>' ?></td>
    <td class="x-subtitle"><?php echo "<a href=\"$show->url\">"
                    .$show->subtitle.'</a>' ?></td>
    <td class="x-programid"><?php echo $show->programid ?></td>
    <td class="x-channum"><?php echo $show->channel->channum, ' - ', $show->channel->name ?></td>
    <td class="x-airdate"><?php echo strftime($_SESSION['date_recorded'], $show->starttime) ?></td>
<?php
    if ($recgroup_cols)
        echo "    <td class=\"-recgroup\">$show->recgroup</td>\n";
?>
    <td class="x-length"><?php echo nice_length($show->length) ?></td>
    <td class="x-filesize"><?php echo nice_filesize($show->filesize) ?></td>
    <td class="x-commands" rowspan="2"><?php
        if ($show->endtime > time()) {
            echo '<a href="', root_url, 'tv/detail/', $show->chanid, '/', $show->starttime, '">',
                 t('Still Recording: Edit'),
                 "</a>\n        ";
        }
        ?><a href="<?php echo root_url ?>tv/recorded?delete=yes&chanid=<?php echo $show->chanid ?>&starttime=<?php echo $show->recstartts ?>"
            title="<?php echo html_entities(t('Delete $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete') ?></a>
        <a href="<?php echo root_url ?>tv/recorded?delete=yes&chanid=<?php echo $show->chanid ?>&starttime=<?php echo $show->recstartts ?>&forget_old=yes"
            title="<?php echo html_entities(t('Delete and rerecord $1', preg_replace('/: $/', '', $show->title.': '.$show->subtitle))) ?>"
            ><?php echo t('Delete + Rerecord') ?></a>
        </td>
</tr><tr id="statusrow_<?php echo $row ?>" class="recorded">
    <td colspan="2" valign="top"><?php echo $show->description ?></td>
    <td colspan="<?php echo (false && $_SESSION['recorded_pixmaps'] ? 3 : 5) + $recgroup_cols ?>" class="x-progflags"><?php
        // Auto expire is not interactive in the lite template
            if ($show->auto_expire)
                echo '<img src="', skin_url, '/img/flags/autoexpire.png" title="', t('Auto Expire'), '">';
        // The rest of the flags are just for display
            if ($show->closecaptioned)
                echo '<img src="'.skin_url.'/img/flags/cc.png" title="'.t('Closed Captioning').'">';
            if ($show->stereo)
                echo '<img src="'.skin_url.'/img/flags/stereo.png" title="'.t('Stereo').'">';
            if ($show->hdtv)
                echo '<img src="'.skin_url.'/img/flags/hd.png" title="'.t('HD').'">';
            if ($show->has_commflag)
                echo '<img src="'.skin_url.'/img/flags/commflagged.png" title="'.t('Commercials Flagged').'">';
            if ($show->has_cutlist)
                echo '<img src="'.skin_url.'/img/flags/cutlist.png" title="'.t('Has Cutlist').'">';
            if ($show->bookmark)
                echo '<img src="'.skin_url.'/img/flags/bookmark.png" title="'.t('has Bookmark').'">';
            if ($show->is_watched)
                echo '<img src="'.skin_url.'/img/flags/watched.png" title="'.t('Watched').'">';
        ?></td>
<?php   if (false && $_SESSION['recorded_pixmaps']) { ?>
    <td colspan="2" class="x-download">
        <ul>
            <li><a href="<?php echo video_url($show, true) ?>">
                    <img src="<?php echo skin_url ?>/img/play_sm.png"><?php echo t('ASX Stream') ?></a></li>
            <li><a href="<?php echo $show->url ?>">
                    <img src="<?php echo skin_url ?>/img/video_sm.png"><?php echo t('Direct Download') ?></a></li>
        </ul>
        </td>
<?php   } ?>
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

