<?php
/***                                                                        ***\
    search.php                               Last Updated: 2005.02.28 (xris)

    This file defines a theme class for the search section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_search extends Theme {

    function print_page($search_name, &$results) {
    // Print the main page header
        parent::print_header('MythWeb - Search');
    // Print any search results
        $this->print_results($search_name, $results);
    // Print the main page footer
        parent::print_footer();
    }

    function print_results($search_name, &$results) {
    // No search was performed, just return
        if (!is_array($results))
            return;

    // Print the search name
        echo '<p class="normal" align="center">'.t('Search for:  $1', $search_name).'</p>';

    // Search, but nothing found - notify the user
        if (empty($results)) {
            echo '<hr width="25%"><p class="normal" align="center">'.t('No matches found').'</p>';
            return;
        }

    // Setup for grouping by various sort orders
        $group_field = $_SESSION['search_sortby'][0]['field'];
        if ($group_field == '')
            $group_field = "airdate";
        elseif ($group_field != "title" && $group_field != "channum" && $group_field != "airdate")
            $group_field = '';

    // Display the results
?>
<p>
<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if (!empty($group_field)) echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td><?php echo get_sort_link('title',       t('title')) ?></td>
    <td><?php echo get_sort_link('subtitle',    t('subtitle')) ?></td>
    <td><?php echo get_sort_link('description', t('description')) ?></td>
    <td><?php echo get_sort_link('channum',     t('channum')) ?></td>
    <td><?php echo get_sort_link('airdate',     t('airdate')) ?></td>
    <td><?php echo get_sort_link('length',      t('length')) ?></td>
</tr><?php
        $row = 0;

        $prev_group = '';
        $cur_group  = '';

        foreach ($results as $show) {

            // Print a dividing row if grouping changes
            if ($group_field == "airdate") {
                $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
            } elseif ($group_field == "channum") {
                $cur_group = $show->channel->name;
            } elseif ($group_field == "title") {
                $cur_group = $show->title;
            }

            if ( ($cur_group != $prev_group) && !empty($group_field) ) { ?>
    <tr class="list_separator">
    <td colspan="9">
        <?php echo $cur_group ?>
        </td>
    </tr><?php
            }

    // Print some additional information for movies
    $additional = '';
    if ($show->category_type == 'movie'
            || $show->category_type == 'Film') {
        if ($show->airdate > 0)
                $additional = sprintf('%4d', $show->airdate);
        if (strlen($show->rating) > 0) {
            if ($additional)
                $additional .= ", ";
            $additional .= "<i>$show->rating</i>";
        }
        if (strlen($show->starstring) > 0) {
            if ($additional)
                $additional .= ", ";
            $additional .= $show->starstring;
        }
        if ($additional)
            $additional = ' (' . $additional . ')';
    }

    // Print the content
    ?><tr class="<?php echo $show->class ?>">
    <?php if (!empty($group_field)) echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td class="<?php echo $show->class ?>"><?php
        if ($show->hdtv)
            echo '<span class="hdtv_icon">HD</span>';
        echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
             .$show->title . $additional.'</a>';
        ?></td>
    <td><?php echo $show->subtitle ?></td>
    <td><?php echo $show->description ?></td>
    <td><?php echo $show->channel->channum.' - '.$show->channel->name ?></td>
    <td nowrap><?php
            echo '<br /><a href="program_detail.php?chanid='. $show->chanid.
                '&starttime='.$show->starttime.'">'.
                strftime($_SESSION['date_search'], $show->starttime) . '</a>';
            if( $show->extra_showings )
                foreach( $show->extra_showings as $showtime )
                    echo '<br /><a href="program_detail.php?chanid='.
                        $show->chanid.'&starttime='.$showtime.'">'.
                        strftime($_SESSION['date_search'],$showtime). '</a>';
                ?></td>
    <td nowrap><?php echo nice_length($show->length) ?></td>
</tr><?php
            $prev_group = $cur_group;
            $row++;
        }
?>

</table>
</p>
<?php
    }

}

