<?php
    // A program id counter for popup info
        if ($_SESSION["show_popup_info"])
            $program_id_counter++;
    // then, we just display the info
        $percent = intVal($timeslots_used * 96 / num_time_slots);
?>
    <td class="small <?php echo $program->css_class; ?>" colspan="<?php echo $timeslots_used ?>" style="width: <?php echo $percent; ?>%" valign="top"><?php
    // hdtv?
        if ($program->hdtv && $percent > 5)
            echo '<span class="hdtv_icon">HD</span>';
    // Start printing the link to record this show
        echo '<a id          = "program-'.$program->chanid.'-'.$program->starttime.'"
                 class       = "program"
                 onmouseover = "currently_hovered_id = this.id; details_delay_timer_id = setTimeout(function () {load_tool_tip(\'program-'.$program->chanid.'-'.$program->starttime.'\',\''.$program->chanid.'\',\''.$program->starttime.'\');}, 250);"
                 onmouseout  = "currently_hovered_id = null; clearTimeout( details_delay_timer_id ); details_delay_timer_id = null;"
                 href        = "'.root_url.'tv/detail/'.$program->chanid.'/'.$program->starttime.'">';
    // Is this program 'Already in Progress'?
        if ($program->starttime < $GLOBALS['list_starttime'])
            echo '<img src="'.skin_url.'img/left_sm.png" class="left_arrow" alt="'.t('left').'">';
    // Does this program 'Continue'?
        if ($program->endtime > $GLOBALS['list_endtime'])
            echo '<img src="'.skin_url.'img/right_sm.png" class="right_arrow" alt="'.t('right').'">';
        if ($percent > 5) {
            echo $program->title;
            if (strlen($program->subtitle) > 0) {
                if ($percent > 8)
                    echo ":<br>$program->subtitle";
                else
                    echo ': ...';
            }
        }
        else
            echo '...';
    // Finish off the link
        echo '</a>';

    // Print some additional information for movies
        if (   strcasecmp($program->category_type, t('movie')) == 0
            || strcasecmp($program->category_type, t('film'))  == 0) {
            $parens = '';
            if ($program->airdate > 0)
                $parens = sprintf('%4d', $program->airdate);
            if (strlen($program->rating) > 0) {
                if ($parens)
                    $parens .= ", ";
                $parens .= "<i>$program->rating</i>";
            }
            if (strlen($program->starstring) > 0) {
                if ($parens)
                    $parens .= ", ";
                $parens .= $program->starstring;
            }
            if ($parens)
                echo " ($parens)";
        }
        $parens = '';
    // Finally, print some other information
        if ($program->previouslyshown)
            $parens = '<i>'.t('Repeat').'</i>';
        if ($parens)
            echo "<BR>($parens)";

    ?></td>
