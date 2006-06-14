<?php
/**
 * Shows all upcoming movies
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

// Load the sorting routines
    require_once "includes/sorting.php";

// Load all channels
    load_all_channels();

// Path-based search (take all of the remaining path)
    if ($Path[2]) {
    }

// Start the query
    $query       = array('category_type='.$db->escape(t('movie')));
    $extra_query = array();

// HDTV only?
    if ($_SESSION['movies']['movies_hd'])
        $extra_query[] = 'hdtv=1';

// Limit by start and end times?
    # obviously, we need to do something here
    # starttime
    # endtime
// Build the query string
    $query = '('.implode(' AND ', $query).')';
// Perform the query
    $Results =& load_all_program_data(time(), strtotime('+1 month'), NULL, false, $query);
    if (empty($Results))
        $Results = array();
    else
        sort_programs($Results, 'movies_sortby');

// Build a list of titles for figuring out alternate showings.  Use the same
// key to make parsing things below a little easier.
    $titles = array();
    foreach ($Results as $key => $show) {
        $titles[$show->title][$key] =& $Results[$key];
    }

// Parse the show list for
    $seen = array();
    foreach ($Results as $key => $show) {
    // Populate extra_showings info for other instances of this show
        if (count($titles[$show->title]) > 1) {
            foreach (array_keys($titles[$show->title]) as $key2) {
                if ($key == $key2)
                    continue;
                $Results[$key2]->extra_showings[] = array($show->chanid, $show->starttime);
            }
        }
    // Delete duplicate showings if we're sorting by title or category (genre)
        if (!in_array($_SESSION['movies_sortby'][0]['field'], array('title', 'category'))) {
            continue;
        }
        elseif ($seen[$show->title]) {
            unset($titles[$show->title][$key]);
            unset($Results[$key]);
        }
        else {
            $seen[$show->title] = true;
        }
    }
    unset($titles);

// Load all of the movie categories
    $Categories = $db->query_list('SELECT DISTINCT category
                                     FROM program
                                    WHERE category_type = ?',
                                  t('movie'));

// Load the class for this page
    require_once tmpl_dir.'movies.php';

// Exit
    exit;

