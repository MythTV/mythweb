<?php
/***                                                                        ***\
    recording_schedules.php                 Last Updated: 2004.03.07 (xris)

    This file defines a theme class for the all recordings section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_recording_schedules extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header('MythWeb - Recording Schedules');
    // Print the page contents
        global $All_Shows;
?>

<script language="JavaScript" type="text/javascript">
<!--
    function changevisible() {
        var prev_visible_class = "no_padding";

        for (var i=1; i < document.getElementById("listings").rows.length; i++) {
            if (document.getElementById("listings").rows[i].className == "list_separator") {
                if (prev_visible_class == "list_separator")
                    document.getElementById("listings").rows[i].style.display = "none";
                else
                    document.getElementById("listings").rows[i].style.display = "";
                prev_visible_class = "list_separator";
            }
            else {
                if (document.getElementById(document.getElementById("listings").rows[i].className).checked) {
                    document.getElementById("listings").rows[i].style.display = "";
                    prev_visible_class = document.getElementById("listings").rows[i].className;
                }
                else
                    document.getElementById("listings").rows[i].style.display = "none";
            }
        }
    }
// -->
</script>

<?php
$group_field = $_GET['sortby'];
if ($group_field == "title")
    $group_field = "";
elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "type") || ($group_field == "profile")) )
    $group_field = "";

?>

<table id="listings" width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td><a href="recording_schedules.php?sortby=title"><?php echo _LANG_TITLE?></a></td>
    <td><a href="recording_schedules.php?sortby=channum"><?php echo _LANG_STATION?></a></td>
    <td><a href="recording_schedules.php?sortby=profile"><?php echo _LANG_PROFILE?></a></td>
    <td><a href="recording_schedules.php?sortby=type"><?php echo _LANG_TYPE?></a></td>
</tr><?php
    $row = 0;

    $prev_group="";
    $cur_group="";

    foreach ($All_Shows as $show) {
    // Reset the command variable to a default URL
        $commands = array();
        $urlstr = 'recordid='.$show->recordid;

        $class   = 'scheduled';
    // If this is an 'always on any channel' recording, set the channel name to 'Any'
        if (($show->type == 4))
            $show->channel->name = '[ '._LANG_ANY.' ]';
    // Build a popup table for the mouseover of the cell, with extra program information?
        if (show_popup_info) {
        // A program id counter
            static $program_id_counter = 0;
            $program_id_counter++;
        // Add a footnote
            global $Footnotes;
            $Footnotes[] = "<div id=\"program_{$program_id_counter}_popup\" class=\"hidden\">
<table class=\"menu small\" border=\"1\" cellpadding=\"5\" cellspacing=\"0\">
<tr>
    <td><table class=\"menu small\" cellpadding=\"2\" cellspacing=\"0\">
        <tr>
            <td align=\"right\">"._LANG_TITLE.":</td>
            <td>$show->title</td>
        </tr>";
            if (($show->type == 1) || ($show->type == 2) || ($show->type == 5)) {
                $Footnotes[] .= "
        <tr>
            <td align=\"right\">"._LANG_AIRTIME.":</td>
            <td>".strftime($_SESSION['date_scheduled_popup'].', '.$_SESSION['time_format'], $show->starttime).' to '.strftime($_SESSION['time_format'], $show->endtime)."</td>
        </tr>"
            .(preg_match('/\\S/', $show->subtitle) ? "<tr>
            <td align=\"right\">"._LANG_SUBTITLE.":</td>
            <td>$show->subtitle</td>
        </tr>" : '')
            .(preg_match('/\\S/', $show->description) ? "<tr>
            <td align=\"right\" valign=\"top\">"._LANG_DESCRIPTION.":</td>
            <td>".nl2br(wordwrap($show->description, 70))."</td>
        </tr>" : '')
            .(preg_match('/\\S/', $show->rating) ? "<tr>
            <td align=\"right\" valign=\"top\">"._LANG_RATING.":</td>
            <td>$show->rating</td>
        </tr>" : '');
            }

            $Footnotes[] .= "<tr>
            <td align=\"right\">"._LANG_TYPE.":</td>
            <td>$show->texttype</td>
        </tr>"
//      .($show->airdate > 0 ? "<tr>
//          <td align=\"right\">"._LANG_ORIG_AIRDATE.":</td>
//          <td>$show->airdate</td>
//      </tr>" : '')
        .(preg_match('/\\S/', $show->category) ? "<tr>
            <td align=\"right\">"._LANG_CATEGORY.":</td>
            <td>$show->category</td>
        </tr>" : '')
        .($show->previouslyshown ? "<tr>
            <td align=\"right\">"._LANG_RERUN.":</td>
            <td>Yes</td>
        </tr>" : '')
        .($show->will_record ? "<tr>
            <td align=\"right\">"._LANG_SCHEDULE.":</td>
            <td>".($show->record_daily       ? _LANG_RECTYPE_LONG_DAILY
                    : ($show->record_weekly  ? _LANG_RECTYPE_LONG_WEEKLY
                    : ($show->record_once    ? _LANG_RECTYPE_LONG_ONCE
                    : ($show->record_channel ? _LANG_RECTYPE_LONG_CHANNEL
                    : ($show->record_findone ? _LANG_RECTYPE_LONG_FINDONE
                    : _LANG_RECTYPE_LONG_ALWAYS)))))."</td>
        </tr>" : '')
        .($show->dupmethod > 0 ? "<tr>
            <td align=\"right\">"._LANG_DUP_METHOD.":</td>
            <td>".($show->dupmethod == 1    ? "None"
                    : ($show->dupmethod == 2    ? _LANG_SUBTITLE
                    : ($show->dupmethod == 4    ? _LANG_DESCRIPTION
                    : ($show->dupmethod == 6    ? _LANG_SUBTITLE_AND_DESCRIPTION
                    : ($show->dupmethod == 22   ? _LANG_SUB_AND_DESC
                    : "")))))."</td>
        </tr>" : '')
        .(preg_match('/\\S/', $show->profile) ? "<tr>
            <td align=\"right\">"._LANG_PROFILE.":</td>
            <td>$show->profile</td>
        </tr>" : '')
        .($show->recstatus ? "<tr>
            <td align=\"right\">"._LANG_NOTES.":</td>
            <td>".$GLOBALS['RecStatus_Reasons'][$show->recstatus]."</td>
        </tr>" : '')
        ."</table></td>
</tr>
</table>
</div>";
        }

    // Print a dividing row if grouping changes
    if ($group_field == 'type')
        $cur_group = $show->texttype;
    elseif ($group_field == 'channum')
        $cur_group = $show->channel->name;
    elseif ($group_field == 'profile')
        $cur_group = $show->profile;

    if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="5" class="list_separator"><?php echo $cur_group?></td>
</tr><?php
    }

    // Print the content
    ?><tr class="<?php echo $class?>">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td class="<?php echo $show->class?>"><?php
        // Print a link to record this show
        echo '<a id="program_'.$program_id_counter.'" href="program_detail.php?recordid='.$show->recordid.'"'
             .(show_popup_info ? ' onmouseover="window.status=\'Details for: '.str_replace('\'', '\\\]', $show->title).'\';show(\'program_'.$program_id_counter.'\');return true"'
                                .' onmouseout="window.status=\'\';hide();return true"'
                               : '')
             .'>'.$show->title
             .($show->type == 1 && preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
             .'</a>';
        ?></td>
    <td><?php echo $show->channel->name?></td>
    <td nowrap><?php echo $show->profile ?></td>
    <td nowrap><?php echo $show->texttype ?></td>
<?php   foreach ($commands as $command) { ?>
    <td nowrap width="5%" class="command command_border_l command_border_t command_border_b command_border_r" align="center"><?php echo $command?></td>
<?php   } ?>
</tr><?php
        $prev_group = $cur_group;
        $row++;
    }
?>

</table>
<?php

    // Print the main page footer
        parent::print_footer();
    }

}

?>
