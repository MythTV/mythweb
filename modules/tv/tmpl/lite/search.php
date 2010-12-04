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
    #$headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_search.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

/**
 * Sorry, no advanced search options in the lite template for now.
/**/

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
                echo '<br />(', implode(', ', $info), ')';
        }

        ?></td>
    <td><?php echo $show->category ?></td>
    <td><?php echo $show->description ?></td>
    <td><?php echo $show->channel->channum.' - '.$show->channel->name ?></td>
    <td nowrap><?php
            echo '<a href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'">'.
                strftime($_SESSION['date_search'], $show->starttime) . '</a>';
            if ($show->extra_showings)
                foreach ($show->extra_showings as $pair) {
                    list($chanid, $showtime) = $pair;
                    echo '<br /><a href="', root_url, 'tv/detail/', $chanid, '/', $showtime, '">',
                         strftime($_SESSION['date_search'] ,$showtime),
                         '</a>';
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

