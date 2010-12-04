<?php
/**
 * Search
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Print the main page header
    $page_title = 'MythWeb - '.t('Search');
    require_once 'modules/_shared/tmpl/'.tmpl.'/header.php';

// Search, but nothing found - notify the user
    global $Results;
    if (!is_array($Results) || !count($Results)) {
        echo '<p class="huge" align="center">No matches found</p>';
        return;
    }
// Get the url search string so we don't have to recreate it for each sort type
    $search_str = '&s='.urlencode($_GET['s']);
    $fields = array();
    if (preg_match('/\btitle/i', $_REQUEST['field'])) $fields[] = 'title';
    if (stristr($_REQUEST['field'], 'subtitle'))      $fields[] = 'subtitle';
    if (stristr($_REQUEST['field'], 'desc'))          $fields[] = 'description';
    if (stristr($_REQUEST['field'], 'cat'))           $fields[] = 'category';
    if ($fields)
        $search_str .= '&amp;fields='.implode(',', $fields);
// Display the results

    $row = 0;
    foreach ($Results as $show) {
// Print the content
    echo $show->channel->name.'<br />';
    echo '<a href="'.root_url.'tv/detail/'.$show->chanid.'/'.$show->starttime.'"><b>'.$show->title.'</b></a><br />';
    if(strlen($show->subtitle))
        echo $show->subtitle.'<br />';
//  echo $show->description.'<br />';
    echo strftime($_SESSION['date_search'], $show->starttime).'<br />';
    echo nice_length($show->length).'<br /><br />';

        $row++;
    }
    require_once 'modules/_shared/tmpl/'.tmpl.'/footer.php';
