<?php
        echo $program->channel->callsign."  "; //chanid." ";
        echo strftime($_SESSION['time_format'], $program->starttime);
        echo ' - <a href="'.root.'tv/detail/'.$program->chanid.'/'.$program->starttime.'">';
        echo htmlspecialchars($program->title);
        echo "</a><br />\n";
?>
