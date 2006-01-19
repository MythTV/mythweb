<?php
/***                                                                        ***\
    recorded.php                    Last Updated: 2004.10.25 (jbuckshin)

    This file defines a theme class for the recorded programs section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

    print_page();

    function print_page() {

        // Print the main page header
        $page_title = "MythWeb - ".t('Recorded Programs');
        require_once theme_dir.'header.php';

        // Print the page contents
        global $All_Shows, $Total_Time;
        global $disk_size, $disk_used;
        global $Total_Programs, $Total_Used, $Groups, $Program_Titles;

        $page = $_GET['page'];
        $confirm_cards = "";
?>
<p>
<?php
        $row = 0;
        $page_size=10; // start out with page size of 10

        if (! isset($page)) $page = 1;
        $page_start = ($page - 1) * $page_size + 1;
        $page_end = $page_start + $page_size;

        if ($page != 1) echo '<a href="'.root.'tv/recorded?page='.($page - 1).'">&lt; prev</a>';
        if (($page * $page_size) < count($All_Shows)) echo ' <a href="'.root.'tv/recorded?page='.($page + 1).'">next &gt;</a>';

        foreach ($All_Shows as $show) {

            $row++;

            // pager code
            if (($row < $page_start) || ($row >= $page_end)) {
                continue;
            }

            echo "<br />".htmlspecialchars($show->title)."<br />";

// think we know the cannel num, skip it for brevity
//        echo $show->channame."<br />";

            if(strlen($show->subtitle)>1)

            echo "<b>".htmlspecialchars($show->subtitle)."</b><br />";

// keep it short, no description in the wml version
//        if(strlen($show->description)>1)
//            echo $show->description."<br />";

            echo strftime($_SESSION['date_scheduled_popup'], $show->starttime)."<br />";
            echo nice_length($show->length)." "; // .nice_filesize($show->filesize)."<br />";

            if ($show->endtime > time()) {
?>
currently recording<br />
<?php
            } else {
$confirm_cards .= "<card id=\"card".$row."\" title=\"Confirm\"><p>Confirm Delete?<br /><a href=\"#main\">Cancel</a>&nbsp;<a href=\"".root."tv/recorded?delete=yes&amp;file=".$show->filename."\">Delete</a></p></card>\n";
?>
<b><a href="#card<?php echo $row ?>">Delete</a></b><br />
<?php
            }
        }
?>
</p>
<p>
<?php
        if ($page != 1) echo '<a href="'.root.'tv/recorded?page='.($page - 1).'">&lt; prev</a>';
        if (($page * $page_size) < count($All_Shows)) echo ' <a href="'.root.'tv/recorded?page='.($page + 1).'">next &gt;</a>';

        echo "<br />".t('$1 programs, using $2 ($3) out of $4 ($5 free).', t($GLOBALS['Total_Programs']),
                                                    nice_filesize(disk_used),
                                                    nice_length($Total_Time),
                                                    nice_filesize(disk_size),
                                                    nice_filesize(disk_size - disk_used));
?>
</p></card>
<?php
        echo $confirm_cards;

        // Print the main page footer
        require_once theme_dir.'footer.php';
    }

