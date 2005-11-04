<?php
/***                                                                        ***\
    search.php                    Last Updated: 2004.10.25 (jbuckshin)

    This file defines a theme class for the search section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_search extends Theme {

    function print_page() {

        // Print the main page header
        parent::print_header('MythWeb - '.t('Search'));
        parent::print_menu_content();

        // Print any search results
        $this->print_results();

        // Print the main page footer
        parent::print_footer();
    }

    function print_results() {

        global $Results;

        $page_size=10; // start out with page size of 10

        // No search was performed, just return
        if (!is_array($Results))
        {
?>
<do type="accept" label="Go">
<go href="search.php" method="get">
<postfield name="searchstr" value="$(searchstr)"/>
</go>
</do>
<p><?php echo t('Search') ?>:<input type="text" name="searchstr"/></p>
</card>
<?php
            return;
        }

        // Search, but nothing found - notify the user
        if (!count($Results)) {
?>
<do type="accept" label="Go">
<go href="search.php" method="get">
<postfield name="searchstr" value="$(searchstr)"/>
</go>
</do>
<p><?php echo "0 Results" ?></p>
<p><?php echo t('Search') ?>:<input type="text" name="searchstr"/></p>
</card>
<?php
            return;
        }

        // Get the url search string so we don't have to recreate it for each sort type
        $search_str = '&amp;searchstr='.urlencode($_GET['searchstr']);
        $page = $_GET['page'];
        if ($_GET['search_title'])         $search_str .= '&amp;search_title=yes';
        if ($_GET['search_subtitle'])      $search_str .= '&amp;search_subtitle=yes';
        if ($_GET['search_description'])   $search_str .= '&amp;search_description=yes';
        if ($_GET['search_category'])      $search_str .= '&amp;search_category=yes';
        if ($_GET['search_category_type']) $search_str .= '&amp;search_category_type=yes';
        // Display the results
?>
<do type="accept" label="Go">
<go href="search.php" method="get">
<postfield name="searchstr" value="$(searchstr)"/>
</go>
</do>
<p>
<?php echo count($Results) ?> Result(s) for "<?php echo urlencode($_SESSION['search']['searchstr']) ?>"<br />
<?php
    if (!isset($page)) {
?>
<a href="#cardresults"><?php echo t('Search Results') ?></a><br />
<?php
    } else {
?>
<a href="#cardresults">Page <?php echo $page ?> of <?php echo ceil(count($Results) / $page_size) ?></a><br />
<?php
    }
?>
<?php echo t('Search') ?>:<input type="text" name="searchstr"/>
</p>
</card>
<card id="cardresults" title="results">

<do type="options" label="Back">
<prev/>
</do>
<p>
<?php
        $row = 0;
        if (! isset($page)) $page = 1;
        $page_start = ($page - 1) * $page_size + 1;
        $page_end = $page_start + $page_size;

        if ($page != 1) echo '<a href="search.php?'.$search_str.'&amp;page='.($page - 1).'">&lt; prev</a>';
        echo " (".$page.") ";
        if (($page * $page_size) < count($Results)) {
            echo ' <a href="search.php?'.$search_str.'&amp;page='.($page + 1).'">next &gt;</a><br />';
        } else {
            echo '<br />';
        }


        // I'd really like to cache the results in the session
        // but that requires changes to the underlying search code
        // and cannot be coded only in the theme.  Maybe this will
        // change at some later date.
        foreach ($Results as $show) {

            $row++;

            // pager code
            if (($row < $page_start) || ($row >= $page_end)) {
                continue;
            }

            // Print the content
            echo '<a href="program_detail.php?chanid='.$show->chanid.'&amp;starttime='.$show->starttime.'">'.htmlspecialchars($show->title).'</a><br />';

            if(strlen($show->subtitle)) echo htmlspecialchars($show->subtitle).'<br />';

            //  echo $show->description.'<br />';
            echo strftime(t('generic_date')." ".t('generic_time'), $show->starttime).'<br />';
            echo $show->channel->callsign.' '.$show->channel->channum.' - '.nice_length($show->length)."<br /><br />\n";
        }

        if ($page != 1) echo '<a href="search.php?'.$search_str.'&amp;page='.($page - 1).'">&lt; prev</a>';
        echo " (".$page.") ";
        if (($page * $page_size) < count($Results)) echo ' <a href="search.php?'.$search_str.'&amp;page='.($page + 1).'">next &gt;</a><br />';
        echo '</p></card>';
    }
}

