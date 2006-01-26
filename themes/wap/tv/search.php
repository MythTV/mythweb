<?php
/***                                                                        ***\
    search.php                    Last Updated: 2003.08.05 (xris)

    This file defines a theme class for the search section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

        // Print the main page header
        $page_title = 'MythWeb - '.t('Search');
        require_once theme_dir.'header.php';

        global $Results;
    // Print the advanced search header

        if (!is_array($Results))
            return;
    // Search, but nothing found - notify the user
        if (!count($Results)) {
            echo '<p class="huge" align="center">No matches found</p>';
            return;
        }
    // Get the url search string so we don't have to recreate it for each sort type
        $search_str = '&searchstr='.urlencode($_GET['searchstr']);
        if ($_GET['search_title'])         $search_str .= '&search_title=yes';
        if ($_GET['search_subtitle'])      $search_str .= '&search_subtitle=yes';
        if ($_GET['search_description'])   $search_str .= '&search_description=yes';
        if ($_GET['search_category'])      $search_str .= '&search_category=yes';
        if ($_GET['search_category_type']) $search_str .= '&search_category_type=yes';
    // Display the results

        $row = 0;
        foreach ($Results as $show) {
    // Print the content
        echo $show->channel->name.'<br />';
        echo '<a href="'.root.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.$show->title.'</a><br />';
        if(strlen($show->subtitle))
            echo $show->subtitle.'<br />';
    //  echo $show->description.'<br />';
        echo date('D m/d/y', $show->starttime).'<br />';
        echo date('(g:i A)', $show->starttime).' '.nice_length($show->length).'<br /><br />';

            $row++;
        }
        require_once theme_dir.'footer.php';
