<?php
/**
 * Show search results, or how to perform a detailed search.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Search');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_search.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the advanced search options
?>

<script type="text/javascript">
<!--

    function search_field_change(i) {
    }

    function add_search_field(i) {
    // Temporary until we add DOM support
        submit_form('add_search_field', i, 'search_advanced');
    }

    function add_search_string() {
    // Temporary until we add DOM support
        submit_form('add_search_string', 1, 'search_advanced');
    }

    function set_search(type) {
        $('type_' + type).checked = true;
    }

// -->
</script>

<form class="form" id="search_advanced" action="<?php echo root_url ?>tv/search" method="get">
    <div><input type="hidden" name="type" value="a"></div>

<table id="search_options" border="0" cellspacing="0" cellpadding="0" class="commandbox commands">
<tr>
    <td class="x-advanced"><?php
        print_advanced_search_strings()
        ?></td>
    <td class="x-timeopts"><p style="margin-top: 0">
        <p>
        <input type="checkbox" name="hd" id="hd" value="1"<?php
            if ($_SESSION['search']['hd']) echo ' CHECKED' ?>>
        <label for="hd"><?php echo t('Only match HD programs') ?></label>
        <br>
        <input type="checkbox" name="commfree" id="commfree" value="1"<?php
            if ($_SESSION['search']['commfree']) echo ' CHECKED' ?>>
        <label for="commfree"><?php echo t('Only match commercial-free channels') ?></label>
        <br>
        <input type="checkbox" name="unwatched" id="unwatched" value="1"<?php
            if ($_SESSION['search']['unwatched']) echo ' CHECKED' ?>>
        <label for="unwatched"><?php echo t('Only match non-recorded shows') ?></label>
        <br>
        <input type="checkbox" name="scheduled" id="scheduled" value="1"<?php
            if ($_SESSION['search']['scheduled']) echo ' CHECKED' ?>>
        <label for="scheduled"><?php echo t('Ignore scheduled shows') ?></label>
        <br>
        <input type="checkbox" name="generic" id="generic" value="1"<?php
            if ($_SESSION['search']['generic']) echo ' CHECKED' ?>>
        <label for="generic"><?php echo t('Ignore generic shows') ?></label>
        <br>
        <input type="checkbox" name="distinctTitle" id="distinctTitle" value="1"<?php
            if ($_SESSION['search']['distinctTitle']) echo ' CHECKED' ?>>
        <label for="distinctTitle"><?php echo t('Only show distinct shows') ?></label>
        </p>
        <p>
        <?php echo t('Showings between'); ?>:<br>
        <input type="text" size="12" name="starttime" style="text-align: center" value="<?php echo html_entities($_SESSION['search']['starttime']) ?>">
        <?php echo t('and'); ?>
        <input type="text" size="12" name="endtime"   style="text-align: center" value="<?php echo html_entities($_SESSION['search']['endtime']) ?>">
        </p>
        <p>
        <?php echo t('Originally aired between'); ?>:<br>
        <input type="text" size="12" name="airdate_start" style="text-align: center" value="<?php echo html_entities($_SESSION['search']['airdate_start']) ?>">
        <?php echo t('and'); ?>
        <input type="text" size="12" name="airdate_end" style="text-align: center" value="<?php echo html_entities($_SESSION['search']['airdate_end']) ?>">
        </p>
        </td>
        <td class="x-progtype">
            <?php echo t('Program Type'); ?>:<br>
            <?php echo category_type_list() ?><br><br>
            <?php echo t('Program Categories'); ?>:<br>
            <?php echo category_list() ?>
        </td>
        <td class="x-submit">
        <input type="submit" class="submit" name="search" value="<?php echo t('Search') ?>">
        </td>
</tr>
</table>

</form>

<?php

// Print the results list if a search was performed
    if ($_REQUEST['search']) {
    // Print the search name
        echo '<p id="x_search_name">',
             ($_SESSION['search']['type'] == 'a'
                ? t('Advanced Search')
                : t('Search for:  $1', $_SESSION['search']['s'])
             ),
             '</p>';
    // Search, but nothing found - notify the user
        if (empty($Results)) {
            echo '<hr width="25%"><p class="normal" align="center">'.t('No matches found').'</p>';
            return;
        }
    // Setup for grouping by various sort orders
        $group_field = $_SESSION['search_sortby'][0]['field'];
        if ($group_field == '')
            $group_field = 'airdate';
        elseif ($group_field != 'channum' && $group_field != 'airdate')
            $group_field = '';

    // Display the results
?>

<table id="search_results" class="list small" width="100%" border="0" cellpadding="4" cellspacing="2">
<tr class="menu">
    <?php if (!empty($group_field)) echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <th class="x-title"><?php       echo get_sort_link('title',       t('Title'))       ?></th>
    <th class="x-category"><?php    echo get_sort_link('category',    t('Category'))    ?></th>
    <th class="x-description"><?php echo get_sort_link('description', t('Description')) ?></th>
    <th class="x-channum"><?php     echo get_sort_link('channum',     t('Channel'))     ?></th>
    <th class="x-airdate"><?php     echo get_sort_link('airdate',     t('Airdate'))     ?></th>
    <th class="x-length"><?php      echo get_sort_link('length',      t('Length'))      ?></th>
</tr><?php
        $row = 0;

        $prev_group = '';
        $cur_group  = '';

        foreach ($Results as $show) {

        // Print a dividing row if grouping changes
            switch ($group_field) {
                case 'airdate':
                    $cur_group = strftime($_SESSION['date_listing_jump'], $show->starttime);
                    break;
                case 'channum':
                    $cur_group = $show->channel->name;
                    break;
                case 'title':
                    $cur_group = $show->title;
                    break;
            }
            if ($cur_group != $prev_group && !empty($group_field)) { ?>
    <tr class="list_separator">
    <td colspan="9">
        <?php echo $cur_group ?>
        </td>
    </tr><?php
            }
    // Print the content
    ?><tr class="<?php echo $show->css_class ?>" valign="top">
    <?php if (!empty($group_field)) echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td class="x-title <?php echo $show->css_class ?>"><?php
        if ($show->hdtv)
            echo '<span class="hdtv_icon">HD</span>';
        echo '<a href="', root_url, 'tv/detail/', $show->chanid, '/', $show->starttime, '">',
             $show->title, '</a>';
        if ($show->subtitle)
            echo ': ', $show->subtitle;
    // Print some additional information for movies
        if ($show->category_type == 'movie') {
            $info = array();
            if ($show->airdate > 0)
                $info[] = sprintf('%4d', $show->airdate);
            if (strlen($show->rating) > 0)
                $info[] = "<i>$show->rating</i>";
            if (strlen($show->starstring) > 0)
                $info[] = $show->starstring;
            if (count($info) > 0)
                echo '<br>(', implode(', ', $info), ')';
        }

        ?></td>
    <td class="x-category"><?php    echo $show->category ?></td>
    <td class="x-description"><?php echo $show->description ?></td>
    <td class="x-channum"><?php     echo $show->channel->channum.' - '.$show->channel->name ?></td>
    <td class="x-airdate"><?php
            echo '<a href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.
                strftime($_SESSION['date_search'], $show->starttime) . '</a>';
            if ($show->extra_showings)
                foreach ($show->extra_showings as $pair) {
                    list($chanid, $showtime) = $pair;
                    echo '<br><a href="', root_url, 'tv/detail/', $chanid, '/', $showtime, '" class="italic">',
                         strftime($_SESSION['date_search'] ,$showtime);
                    if ($chanid != $show->chanid)
                        echo ' (', Channel::find($chanid)->callsign, ')';
                    echo '</a>';
                }
                ?></td>
    <td class="x-length"><?php echo nice_length($show->length) ?></td>
</tr><?php
            $prev_group = $cur_group;
            $row++;
        }
?>

</table>

<?php
    }

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
