<?php
/***                                                                        ***\
    recorded_programs.php                    Last Updated: 2003.08.20 (xris)

    This file defines a theme class for the recorded programs section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

#class theme_program_detail extends Theme {
class Theme_recorded_programs extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header("MythWeb - Recorded Programs");
    // Print the page contents
        global $All_Shows;
?>

<p>
<form class="form" id="program_titles" action="recorded_programs.php" method="get">
<center>
    Recordings<br />
    <select name="title">
        <option value="">All recordings</option><?php
        global $Program_Titles;
        foreach($Program_Titles as $title => $count) {
            echo '<option value="'.$title.'"';
            if ($_GET['title'] == $title)
                echo ' SELECTED';
            echo '>'.$title.($count > 1 ? " ($count episodes)" : "").'</option>';
        }
        ?>
    </select><br />
    <input type="submit" value="Go"><br /><br />
</center>
</form>
</p>

<?php
    $row = 0;
    foreach ($All_Shows as $show) {
        echo $show->title."<br />";
        echo $show->channame."<br />";
        if(strlen($show->subtitle)>1)
            echo "<b>".$show->subtitle."</b><br />";
        if(strlen($show->description)>1)
            echo $show->description."<br />";
        echo date('D, M j,Y (g:i A)', $show->starttime)."<br />";
        echo nice_length($show->length)." ".nice_filesize($show->filesize)."<br />";

        if ($show->endtime > time()) { ?>
            <font color="#FF0000">currently recording - </font>
<?php   } ?>
            <b></b><a id="delete_<?php echo $row ?>" href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename) ?>">Delete </a></b>
            <b></b><a id="delete_<?php echo $row ?>" href="recorded_programs.php?delete=yes&file=<?php echo urlencode($show->filename) ?>&forget_old">Rerecord</a></b><br />
<?php
        echo "<br />";

        $row++;
    }
?>

<?php
    echo $GLOBALS['Total_Programs'].' programs, using '.nice_filesize(disk_used).' out of '.nice_filesize(disk_size);

    // Print the main page footer
        parent::print_footer();
    }

}

