<?php
/***                                                                        ***\
    search.php                               Last Updated: 2004.08.09 (xris)

    This file defines a theme class for the search section.
    It must define one method.   documentation will be added someday.

\***                                                                        ***/

class Theme_search extends Theme {

    function print_page() {
    // Print the main page header
        parent::print_header('MythWeb - Search');
    // Print the advanced search header
?>
<p>
<form action="search.php" method="post">
<table class="command command_border_l command_border_t command_border_b command_border_r" align="center" width="90%" cellspacing="2" cellpadding="2">
<tr>
    <td align="right"><?php echo t('Search') ?>:</td>
    <td><input type="text" name="searchstr" size="15" value="<?php echo htmlentities($_SESSION['search']['searchstr'], ENT_COMPAT, 'UTF-8') ?>"></td>
    <td>&nbsp; <input type="submit" class="submit" value="<?php echo t('Search') ?>"></td>
    <td align="right"><input type="checkbox" class="radio" id="search_title" name="search_title" value="1"<?php echo $_SESSION['search']['search_title'] ? ' CHECKED' : ''?>></td>
    <td onclick="get_element('search_title').checked=get_element('search_title').checked ? false : true;"><a><?php echo t('Title') ?></a></td>
    <td align="right"><input type="checkbox" class="radio" id="search_subtitle" name="search_subtitle" value="1"<?php echo $_SESSION['search']['search_subtitle'] ? ' CHECKED' : ''?>></td>
    <td onclick="get_element('search_subtitle').checked=get_element('search_subtitle').checked ? false : true;"><a><?php echo t('Subtitle') ?></a></td>
    <td align="right"><input type="checkbox" class="radio" id="search_description" name="search_description" value="1"<?php echo $_SESSION['search']['search_description'] ? ' CHECKED' : ''?>></td>
    <td onclick="get_element('search_description').checked=get_element('search_description').checked ? false : true;"><a><?php echo t('Description') ?></a></td>
    <td align="right"><input type="checkbox" class="radio" id="search_category" name="search_category" value="1"<?php echo $_SESSION['search']['search_category'] ? ' CHECKED' : ''?>></td>
    <td onclick="get_element('search_category').checked=get_element('search_category').checked ? false : true;"><a><?php echo t('Category') ?></a></td>
    <td align="right"><input type="checkbox" class="radio" id="search_category_type" name="search_category_type" value="1"<?php echo $_SESSION['search']['search_category_type'] ? ' CHECKED' : ''?>></td>
    <td onclick="get_element('search_category_type').checked=get_element('search_category_type').checked ? false : true;"><a><?php echo t('Category Type') ?></a></td>
    <td align="right"><input type="checkbox" class="radio" id="search_exact" name="search_exact" value="1"<?php echo $_SESSION['search']['search_exact'] ? ' CHECKED' : ''?>></td>
    <td onclick="get_element('search_exact').checked=get_element('search_exact').checked ? false : true;"><a><?php echo t('Exact Match') ?></a></td>
</tr>
</table>
</form>
</p>
<?php
    // Print any search results
        $this->print_results();
    // Print the main page footer
        parent::print_footer();
    }

    function print_results() {
        global $Results;
    // No search was performed, just return
        if (!is_array($Results))
            return;
    // Search, but nothing found - notify the user
        if (!count($Results)) {
            echo '<p class="huge" align="center">'.t('No matches found').'</p>';
            return;
        }

    // Setup for grouping by various sort orders
        $group_field = $_SESSION['search_sortby'][0]['field'];
        if ($group_field == "")
            $group_field = "airdate";
        elseif ($group_field != "title" && $group_field != "channum" && $group_field != "airdate")
            $group_field = "";

    // Display the results
?><table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if ($group_field != "") echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td><?php echo get_sort_link('title')       ?></td>
    <td><?php echo get_sort_link('subtitle')    ?></td>
    <td><?php echo get_sort_link('description') ?></td>
    <td><?php echo get_sort_link('channum')     ?></td>
    <td><?php echo get_sort_link('airdate')     ?></td>
    <td><?php echo get_sort_link('length')      ?></td>
</tr><?php
        $row = 0;

        $prev_group="";
        $cur_group="";

        foreach ($Results as $show) {

            // Print a dividing row if grouping changes
            if ($group_field == "airdate") {
                $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
            } elseif ($group_field == "channum") {
                $cur_group = $show->channel->name;
            } elseif ($group_field == "title") {
                $cur_group = $show->title;
            }

            if ( ($cur_group <> $prev_group) && ($group_field <> "") ) { ?>
    <tr class="list_separator">
    <td colspan="9">
        <?php echo $cur_group?>
        </td>
    </tr><?
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
    <?php if ($group_field != "") echo "<td class=\"list\">&nbsp;</td>\n"; ?>
    <td class="<?php echo $show->class ?>"><?php
        echo '<a href="program_detail.php?chanid='.$show->chanid.'&starttime='.$show->starttime.'">'
             .$show->title . $additional.'</a>';
        ?></td>
    <td><?php echo $show->subtitle?></td>
    <td><?php echo $show->description?></td>
    <td><?php echo $show->channel->channum.' - '.$show->channel->name?></td>
    <td nowrap><?php echo strftime($_SESSION['date_search'], $show->starttime)?></td>
    <td nowrap><?php echo nice_length($show->length)?></td>
</tr><?php
            $prev_group = $cur_group;
            $row++;
        }
?>

</table>
<?php
    }

}

?>
