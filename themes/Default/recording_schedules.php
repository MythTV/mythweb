<?php
/***                                                                        ***\
    recording_schedules.php                 Last Updated: 2004.06.22 (xris)

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
elseif ( ! (($group_field == "title") || ($group_field == "channum") || ($group_field == "type") || ($group_field == "profile") || ($group_field == "recgroup")) )
    $group_field = "";

?>

<table id="listings" width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td><?php echo get_sort_link('title',    t('title'))    ?></td>
    <td><?php echo get_sort_link('channum',  t('channum'))  ?></td>
    <td><?php echo get_sort_link('profile',  t('profile'))  ?></td>
    <td><?php echo get_sort_link('recgroup', t('recgroup')) ?></td>
    <td><?php echo get_sort_link('type',     t('type'))     ?></td>
</tr><?php
    $row = 0;

    $prev_group="";
    $cur_group="";

    foreach ($All_Shows as $show) {
    // Reset the command variable to a default URL
        $commands = array();
        $urlstr = 'recordid='.$show->recordid;

        $class = ($show->type == 8 ? 'deactivated' : 'scheduled');
    // If this is an 'always on any channel' or 'find one' recording w/o a channel, set the channel name to 'Any'
        if ($show->type == 4 || ($show->type == 6 && !preg_match('/\\S/', $show->channel->channum)))
            $show->channel->name = '[ '.t('Any').' ]';
    // A program id counter for popup info
        if (show_popup_info) {
            static $program_id_counter = 0;
            $program_id_counter++;
        }

    // Print a dividing row if grouping changes
        if ($group_field == 'type')
            $cur_group = $show->texttype;
        elseif ($group_field == 'channum')
            $cur_group = ($show->channel->channum ? $show->channel->channum.' - ' : '').$show->channel->name;
        elseif ($group_field == 'profile')
            $cur_group = $show->profile;
        elseif ($group_field == 'recgroup')
            $cur_group = $show->recgroup;

        $style_class = $show->class;
        if ($show->type == 7)
            $style_class .= ' record_override_record';
        elseif ($show->type == 8)
            $style_class .= ' record_override_suppress';

        if ( $cur_group != $prev_group && $group_field != '' ) {
?><tr class="list_separator">
    <td colspan="6" class="list_separator"><?php echo $cur_group?></td>
</tr><?php
        }
    // Print the content
    ?><tr class="<?php echo $class?>">
    <?php if ($group_field != '') echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td class="<?php echo $style_class?>"><?php
    // Window status text, for the mouseover
        $wstatus = "Details for $show->title";
    // Print a link to the program detail for this schedule
        echo '<a';
        if (show_popup_info)
            echo show_popup("program_$program_id_counter", $show->details_table(), NULL, 'popup', $wstatus);
        else
            echo " onmouseover=\"wstatus('".str_replace('\'', '\\\'', $wstatus)."');return true\" onmouseout=\"wstatus('');return true\"";
        echo ' href="program_detail.php?recordid='.$show->recordid.'"'
             .'>'.$show->title
             .(($show->type == 1 || $show->type == 7 || $show->type == 8) && preg_match('/\\w/', $show->subtitle) ? ":  $show->subtitle" : '')
             .'</a>';
        ?></td>
    <td><?php
        if ($show->channel->channum)
            echo $show->channel->channum.' - ';
        echo $show->channel->name
        ?></td>
    <td nowrap><?php if($show->type != 8) echo $show->profile; ?></td>
    <td nowrap><?php if($show->type != 8) echo $show->recgroup; ?></td>
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
