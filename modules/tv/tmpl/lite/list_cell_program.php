<?php
    // then, we just display the info
        $percent = intVal($timeslots_used * 96 / num_time_slots);
?>
    <td class="small <?php echo $program->css_class ?>" colspan="<?php echo $timeslots_used ?>" width="<?php echo $percent ?>%" valign="top"><?php
    // Window status text, for the mouseover
        $wstatus = strftime($_SESSION['time_format'], $program->starttime).' - '.strftime($_SESSION['time_format'], $program->endtime).' -- '
                  .str_replace(array("'", '"'),array("\\'", '&quot;'), $program->title)
                  .($program->subtitle ? ':  '.str_replace(array("'", '"'),array("\\'", '&quot;'), $program->subtitle)
                                          : '');
    // hdtv?
        if ($program->hdtv && $percent > 5)
            echo '<span class="hdtv_icon">HD</span>';
    // Start printing the link to record this show
        echo '<a href="'.root_url.'tv/detail/'.$program->chanid.'/'.$program->starttime.'">';
    // Is this program 'Already in Progress'?
        if ($program->starttime < $GLOBALS['list_starttime'])
            echo '<img src="'.skin_url.'img/left_sm.png" border="0" class="left_arrow">';
    // Does this program 'Continue'?
        if ($program->endtime > $GLOBALS['list_endtime'])
            echo '<img src="'.skin_url.'img/right_sm.png" border="0" class="right_arrow">';
        if ($percent > 5) {
            echo $program->title;
            if (strlen($program->subtitle) > 0) {
                if ($percent > 8)
                    echo ":<br />$program->subtitle";
                else
                    echo ': ...';
            }
        }
        else
            echo '...';
    // Finish off the link
        echo '</a>';

    // Print some additional information for movies
        if ($program->category_type == 'movie'
                || $program->category_type == 'Film') {
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

