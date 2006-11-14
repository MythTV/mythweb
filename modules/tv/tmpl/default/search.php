<?php
/**
 * Show search results, or how to perform a detailed search.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Search');

// Custom headers
    #$headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_search.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Print the advanced search options
?>

<script language="JavaScript" type="text/javascript">
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
        get_element('type_' + type).checked = true;
    }

// -->
</script>

<form class="form" id="search_advanced" action="<?php echo root ?>tv/search" method="get">
    <input type="hidden" name="type" value="a">

<table align="center" border="1" cellspacing="0" cellpadding="2" class="command command_border_l command_border_t command_border_b command_border_r">
<tr>
    <td valign="top"><?php print_advanced_search_strings() ?>
        </td>
    <td valign="top"><p style="margin-top: 0">
        <input type="checkbox" name="hd" id="hd" value="1"<?php
            if ($_SESSION['search']['hd']) echo ' CHECKED' ?>>
        <label for="hd"><?php echo t('Only match HD programs') ?></label>
        <br />
        <input type="checkbox" name="commfree" id="commfree" value="1"<?php
            if ($_SESSION['search']['commfree']) echo ' CHECKED' ?>>
        <label for="commfree"><?php echo t('Only match commercial-free channels') ?></label>
        </p>
        <p>
        Showings between:<br />
        <input type="text" size="12" name="starttime" style="text-align: center" value="<?php echo html_entities($_SESSION['search']['starttime']) ?>">
        and
        <input type="text" size="12" name="endtime"   style="text-align: center" value="<?php echo html_entities($_SESSION['search']['endtime']) ?>">
        </p>
        <p>
        Originally aired between:<br />
        <input type="text" size="12" name="airdate_start" style="text-align: center" value="<?php echo html_entities($_SESSION['search']['airdate_start']) ?>">
        and
        <input type="text" size="12" name="airdate_end" style="text-align: center" value="<?php echo html_entities($_SESSION['search']['airdate_end']) ?>">
        </p>
        </td>
    <td valign="top">Program Type:<br />
        <?php echo category_type_list() ?>
        </td>
    <td valign="middle">
        <input type="submit" name="search" value="Search" style="margin: 10px">
        </td>
</tr>
</table>

</form>

<?php

// Print the results list if a search was performed
    if ($_REQUEST['search']) {
    // Print the search name
        echo '<p class="normal" align="center">',
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

<table width="100%" border="0" cellpadding="4" cellspacing="2" class="list small">
<tr class="menu">
    <?php if (!empty($group_field)) echo "<td class=\"list\">&nbsp;</td>\n" ?>
    <td><?php echo get_sort_link('title',       t('title')) ?></td>
    <td><?php echo get_sort_link('category',    t('category')) ?></td>
    <td><?php echo get_sort_link('description', t('description')) ?></td>
    <td><?php echo get_sort_link('channum',     t('channum')) ?></td>
    <td><?php echo get_sort_link('airdate',     t('airdate')) ?></td>
    <td><?php echo get_sort_link('length',      t('length')) ?></td>
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
    <td class="<?php echo $show->css_class ?>"><?php
        if ($show->hdtv)
            echo '<span class="hdtv_icon">HD</span>';
        echo '<a href="', root, 'tv/detail/', $show->chanid, '/', $show->starttime, '">',
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
                echo '<br />(', implode(', ', $info), ')';
        }

        ?></td>
    <td><?php echo $show->category ?></td>
    <td><?php echo $show->description ?></td>
    <td><?php echo $show->channel->channum.' - '.$show->channel->name ?></td>
    <td nowrap><?php
            echo '<a href="'.root.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.
                strftime($_SESSION['date_search'], $show->starttime) . '</a>';
            if ($show->extra_showings)
                foreach ($show->extra_showings as $pair) {
                    list($chanid, $showtime) = $pair;
                    echo '<br /><a href="', root, 'tv/detail/', $chanid, '/', $showtime, '" class="italic">',
                         strftime($_SESSION['date_search'] ,$showtime);
                    if ($chanid != $show->chanid)
                        echo ' (', $Channels[$chanid]->callsign, ')';
                    echo '</a>';
                }
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

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';

