<?php
/**
 * Quick and advanced search modes.
 *
 * Quick Search prefixes can be applied in the following order:
 *
 *   hd:        Only search HD objects
 *   **1/2      Movie search
 *
 *   Use ^ and/or $ to anchor the search, and enclose in // to use regex.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/


// Load the sorting routines
    require_once 'includes/sorting.php';

// Path-based search overrides request-based search type.
    if ($Path[2]) {
    // Don't forget to take all of the remaining path.
        $_SESSION['search']['s']    = implode('/', array_splice($Path, 2));
        $_SESSION['search']['type'] = 'q';
        $_REQUEST['search']         = true;
    }

// Sorting should re-trigger the search
    if ($_REQUEST['sortby'])
        $_REQUEST['search'] = true;

// Pull in updates
    if (isset($_REQUEST['type']))
        $_SESSION['search']['type']          = $_REQUEST['type'];

    if (isset($_REQUEST['s']))
        $_SESSION['search']['s']             = trim($_REQUEST['s']);

    if (isset($_REQUEST['as'])) {
        $_SESSION['search']['as']            = $_REQUEST['as'];
        $_SESSION['search']['af']            = $_REQUEST['af'];
        $_SESSION['search']['aj']            = $_REQUEST['aj'];
        $_SESSION['search']['ctype']         = $_REQUEST['ctype'];
        $_SESSION['search']['categories']    = $_REQUEST['categories'];
        $_SESSION['search']['hd']            = $_REQUEST['hd']              ? true : false;
        $_SESSION['search']['commfree']      = $_REQUEST['commfree']        ? true : false;
        $_SESSION['search']['unwatched']     = $_REQUEST['unwatched']       ? true : false;
        $_SESSION['search']['scheduled']     = $_REQUEST['scheduled']       ? true : false;
        $_SESSION['search']['generic']       = $_REQUEST['generic']         ? true : false;
        $_SESSION['search']['distinctTitle'] = $_REQUEST['distinctTitle']   ? true : false;
        $_SESSION['search']['stars_gt']      = floatVal($_REQUEST['stars_gt']);
        $_SESSION['search']['stars_lt']      = floatVal($_REQUEST['stars_lt']);
        $_SESSION['search']['airdate_start'] = trim($_REQUEST['airdate_start']);
        $_SESSION['search']['airdate_end']   = trim($_REQUEST['airdate_end']);
        $_SESSION['search']['starttime']     = trim($_REQUEST['starttime']);
        $_SESSION['search']['endtime']       = trim($_REQUEST['endtime']);
    }

// Session defaults
    if (!is_array($_SESSION['search']['ctype']) || empty($_SESSION['search']['ctype']))
        $_SESSION['search']['ctype'] = Program::category_types();

    if (!is_array($_SESSION['search']['categories']) || empty($_SESSION['search']['categories']))
        $_SESSION['search']['categories'] = array();

    if (!isset($_SESSION['search']['stars_gt']) || !isset($_SESSION['search']['stars_lt'])) {
        $_SESSION['search']['stars_gt'] = 0;
        $_SESSION['search']['stars_lt'] = 1;
    }
    if (!isset($_SESSION['search']['starttime'])) {
        $_SESSION['search']['starttime'] = 'now';
    }
    if (!isset($_SESSION['search']['endtime'])) {
        $_SESSION['search']['endtime'] = '+ 2 weeks';
    }
    if (!is_array($_SESSION['search']['as']) || empty($_SESSION['search']['as'])) {
        if (!is_string($_SESSION['search']['as']))
            $_SESSION['search']['as'] = '';
        $_SESSION['search']['as'] = array($_SESSION['search']['as']);
    }
    if (!is_array($_SESSION['search']['af'])) {
        if (gettype($_SESSION['search']['af']) == 'string')
            $_SESSION['search']['af'] = array(array($_SESSION['search']['af']));
        else
            $_SESSION['search']['af'] = array(array('title'));
    }
    if (!is_array($_SESSION['search']['aj'])) {
        if (gettype($_SESSION['search']['aj']) == 'string')
            $_SESSION['search']['aj'] = array($_SESSION['search']['aj']);
        else
            $_SESSION['search']['aj'] = array('AND');
    }

// Compact any empty strings or fields, and make sure the data is in the right format
    $fixeds = array();
    $fixedf = array();
    $fixedj = array();
    foreach ($_SESSION['search']['as'] as $i => $str) {
        if ($i > 0 && !preg_match('/\S/', $str))
            continue;
    // How is this joined to the previous string?
        if (empty($_SESSION['search']['aj'][$i]))
            $fixedj[] = 'AND';
        else
            $fixedj[] = $_SESSION['search']['aj'][$i];
    // Fields for this string
        $fields = array();
        if (is_array($_SESSION['search']['af'][$i])) {
            foreach ($_SESSION['search']['af'][$i] as $j => $field) {
                if (!preg_match('/\S/', $field)) {
                    if ($j > 0)
                        continue;
                    else
                        $field = 'title';
                }
                $fields[] = $field;
            }
        }
        else
            $_SESSION['search']['af'][$i] = array('title');
        $fixeds[] = trim($str);
        $fixedf[] = $fields;
    }
    $_SESSION['search']['as'] = $fixeds;
    $_SESSION['search']['af'] = $fixedf;
    $_SESSION['search']['aj'] = $fixedj;

// Swap mismatched star restrictions
    if ($_SESSION['search']['stars_gt'] > $_SESSION['search']['stars_lt']) {
        $tmp = $_SESSION['search']['stars_gt'];
        $_SESSION['search']['stars_gt'] = $_SESSION['search']['stars_lt'];
        $_SESSION['search']['stars_lt'] = $tmp;
    }

// Actually perform a search?
    if (isset($_REQUEST['search'])) {
    // Start the query
        $query       = array();
        $extra_query = array();

    // Advanced search?
        if ($_SESSION['search']['type'] == 'a') {
        // Which kinds of programs are we searching through?
            $extra_query[] = 'program.category_type IN ('
                             .implode(',', $db->escape_array($_SESSION['search']['ctype']))
                             .')';
            if (count($_SESSION['search']['categories']) && !in_array(t('All'), $_SESSION['search']['categories'])) {
                $extra_query[] = 'program.category IN ('
                             .implode(',', $db->escape_array($_SESSION['search']['categories']))
                             .')';
            }
        // Star restrictions only apply to movies
            if (in_array('movie', $_SESSION['search']['ctype'])) {
                if (count($_SESSION['search']['ctype']) > 1) {
                    $extra_query[] = 'IF(program.category_type = "movie",'
                                    .'     program.stars >= '.$_SESSION['search']['stars_gt']
                                    .' AND program.stars <= '.$_SESSION['search']['stars_lt']
                                    .', 1)';
                }
                else {
                    $extra_query[] = '     program.stars >= '.$_SESSION['search']['stars_gt']
                                    .' AND program.stars <= '.$_SESSION['search']['stars_lt'];
                }
            }
        // Date range
            if (preg_match('/\S/', $_SESSION['search']['starttime'])) {
                $tmpdate = strtotime($_SESSION['search']['starttime']);
                if ($tmpdate == false) {
                }
                else {
                    $extra_query[] = 'program.starttime>='.$db->escape(date('Y-m-d H:i:s', $tmpdate));
                }
            }
            if (preg_match('/\S/', $_SESSION['search']['endtime'])) {
                $tmpdate = strtotime($_SESSION['search']['endtime']);
                if ($tmpdate == false) {
                }
                else {
                    $extra_query[] = 'program.endtime<='.$db->escape(date('Y-m-d H:i:s', $tmpdate));
                }
            }
        // Airdate range
            if (preg_match('/\S/', $_SESSION['search']['airdate_start'])) {
                $tmpdate = $_SESSION['search']['airdate_start'];
                if (!preg_match('/\D/', $tmpdate))  // for some reason, strtotime doesn't like dates like 2000
                    $tmpdate .= '-01-01';
                $tmpdate = strtotime($tmpdate);
                if ($tmpdate == false) {
                }
                else {
                    $extra_query[] = 'IF(program.originalairdate IS NULL,'
                                    .'program.airdate>='        .$db->escape(date('Y',     $tmpdate)).','
                                    .'program.originalairdate>='.$db->escape(date('Y-m-d', $tmpdate)).')';
                }
            }
            if (preg_match('/\S/', $_SESSION['search']['airdate_end'])) {
                $tmpdate = $_SESSION['search']['airdate_end'];
                if (!preg_match('/\D/', $tmpdate))  // for some reason, strtotime doesn't like dates like 2000
                    $tmpdate .= '-01-01';
                $tmpdate = strtotime($tmpdate);
                if ($tmpdate == false) {
                }
                else {
                    $extra_query[] = 'IF(program.originalairdate IS NULL,'
                                    .'program.airdate<='        .$db->escape(date('Y',     $tmpdate)).','
                                    .'program.originalairdate<='.$db->escape(date('Y-m-d', $tmpdate)).')';
                }
            }
        // Build the actual search query
            $query = '';
            foreach ($_SESSION['search']['as'] as $i => $string) {
            // Joiner
                if ($i > 0)
                    $query .= ' '.$_SESSION['search']['aj'][$i];
            // Match posibilities
                if (!empty($_SESSION['search']['af'][$i])) {
                    $query .= '(';
                    list($compare, $search) = prep_search($string);
                    foreach ($_SESSION['search']['af'][$i] as $j => $af) {
                        if ($j > 0)
                            $query .= ' OR ';
                        switch ($af) {
                            case 'subtitle':
                                $query .= 'program.subtitle';
                                break;
                            case 'description':
                                $query .= 'program.description';
                                break;
                            case 'category':
                                $query .= 'program.category';
                                break;
                            case 'people':
                                $query .= 'people.name';
                                break;
                            case 'channum':
                                $query .= 'channel.channum';
                                break;
                            case 'channame':
                                $query .= 'channel.name';
                                break;
                            case 'callsign':
                                $query .= 'channel.callsign';
                                break;
                            case 'title':
                            default:
                                $query .= 'program.title';
                                break;
                        }
                    // The actual
                        $query .= " $compare $search";
                    }
                    $query .= ')';
                }
            }
        }
    // Canned search?
        elseif (preg_match('/^\s*canned:\s*(.+)\s*$/i', $_SESSION['search']['s'], $search_name)) {
            $search_name = $search_name[1];
        // Load the canned searches
            require_once 'modules/tv/canned_searches.conf.php';
        // Load the local canned searches (if it exists)
            if (file_exists('configuration/canned_searches.conf.php'))
                include 'configuration/canned_searches.conf.php';
        // Find the query
            if (empty($Canned_Searches[$search_name]))
                add_warning("Unknown canned query: $search_name");
            else
                $query = $Canned_Searches[$search_name];
        }
    // Quick search is the default
        else {
        // Make a backup so we can edit it without affecting the original
            $search_str = $_SESSION['search']['s'];
        // If it starts with hd: it's an hd-only search
            if (preg_match('/^hd:\s*(.+)$/', $search_str, $match)) {
                $extra_query[] = 'program.hdtv & 1';
                $search_str    = $match[1];
            }
        // If the next thing starts with stars, it's a movie rating query
            if (preg_match('#(\\*+\s*(1/2\b|0?\.5\b|-)?)\s*(.*?)$#', $search_str, $match)) {
                $starcount = substr_count($match[1], '*') / 4;
                if (preg_match('/1\\/2|\\.5|-/', $match[1]))
                    $starcount += 0.125;
            // Add this to the query -- convert european decimal to something mysql can understand
                $extra_query[] = 'program.stars >= '.str_replace(',', '.', $starcount);
            // Remove the stars from the search string so we can continue looking for other things
                $search_str = $match[2];
            }
        // Quick search doesn't search the past
            $extra_query[] = 'program.endtime >= NOW()';
        // Build the query
            list($compare, $search) = prep_search($search_str);
            if (empty($_REQUEST['field']) || preg_match('/\btitle/i', $_REQUEST['field']))
                $query[] = "program.title       $compare $search";
            if (empty($_REQUEST['field']) || stristr($_REQUEST['field'], 'subtitle'))
                $query[] = "program.subtitle    $compare $search";
            if (empty($_REQUEST['field']) || stristr($_REQUEST['field'], 'desc'))
                $query[] = "program.description $compare $search";
            if (empty($_REQUEST['field']) || stristr($_REQUEST['field'], 'cat'))
                $query[] = "program.category    $compare $search";
            if (empty($_REQUEST['field']) || stristr($_REQUEST['field'], 'people'))
                $query[] = "people.name         $compare $search";
            $query   = implode(' OR ', $query);
        }

    // HDTV only?
        if ($_SESSION['search']['hd'])
            $extra_query[] = 'program.hdtv & 1';
        if ($_SESSION['search']['generic'])
            $extra_query[] = 'program.generic = 0';
    // Commercial-free channels only?
        if ($_SESSION['search']['commfree'])
            $extra_query[] = 'channel.commmethod=-2';

    // Finish the query and add any extra parameters
        if ($query)
            $query = "($query)";
        if (count($extra_query) > 0) {
            if ($query)
                $query .= ' AND ';
            $query .= '('.implode(' AND ', $extra_query).')';
        }

    // Search!
        if (!empty($query))
            $tmpdate = strtotime($_SESSION['search']['starttime']);
        if ($tmpdate == false) {
            $Results =& load_all_program_data(time(), strtotime('+1 month'), NULL, false, $query, $_SESSION['search']['distinctTitle']);
        } else {
            $Results =& load_all_program_data($tmpdate, strtotime('+1 month'), NULL, false, $query, $_SESSION['search']['distinctTitle']);
        }

    }

// Only show unwatched shows?
    if ($_SESSION['search']['unwatched'] && count($Results)) {
        foreach ($Results as $key => $show) {
            switch($show->recstatus) {
                case 'PreviousRecording':
                case 'CurrentRecording':
                case 'Recorded':
                case 'NeverRecord':
                    unset($Results[$key]);
                    continue;
            }
        }
    }

// Ignore will record shows?
    if ($_SESSION['search']['scheduled'] && count($Results)) {
        foreach ($Results as $key => $show) {
            switch($show->recstatus) {
                case 'WillRecord':
                case 'Conflict':
                case 'EarlierShowing':
                case 'LaterShowing':
                    unset($Results[$key]);
                    continue;
            }
        }
    }

// Query cleanup
    if (empty($Results))
        $Results = array();
    else
        sort_programs($Results, 'search_sortby');

// Build a list of titles for figuring out alternate showings.  Use the same
// key to make parsing things below a little easier.
    $titles = array();
    $seen = array();
    foreach ($Results as $key => $show) {
        $tkey = md5($show->channel->channum.':'.$show->channel->callsign.':'.$show->title.':'.$show->subtitle.':'.$show->description);
        $skey = $show->channel->name.$show->starttime.$tkey;
        if($seen[$skey]){
            unset($Results[$key]);
            continue;
        }else{
            $titles[$tkey][$key] =& $Results[$key];
            $seen[$skey] = true;
        }
    }

// Parse the show list for showings that can be consolidated/folded
    $seen = array();
    foreach ($Results as $key => $show) {
        $tkey = md5($show->channel->channum.':'.$show->channel->callsign.':'.$show->title.':'.$show->subtitle.':'.$show->description);
    // Populate extra_showings info for other instances of this show
        if (count($titles[$tkey]) > 1) {
            foreach (array_keys($titles[$tkey]) as $key2) {
                if ($key == $key2)
                    continue;
                $Results[$key2]->extra_showings[] = array($show->chanid, $show->starttime);
            }
        }
    // Delete duplicate showings if we're sorting by title or category (genre)
        if (!in_array($_SESSION['search_sortby'][0]['field'], array('title', 'category'))) {
            continue;
        }
        elseif ($seen[$tkey]) {
            unset($titles[$tkey][$key]);
            unset($Results[$key]);
        }
        else {
            $seen[$tkey] = true;
        }
    }
    unset($titles);

// Load the class for this page
    require_once tmpl_dir.'search.php';

// Exit
    exit;

/**
 * Prep a search string for matching, and return the comparison string
 *
 * @param
 *
 * @return array
/**/
    function prep_search($str) {
    // negative match
        $neg = '';
        if (substr($str, 0, 1) == '!') {
            $neg = 'NOT ';
            $str = substr($str, 1);
        }
    // Regex search?
        if (preg_match('#^/(.+)/$#', $str, $match))
            return array($neg.'REGEXP', search_escape($match[1], 'both'));
    // Or figure out where the search should be anchored
        elseif (preg_match('#^\^(.+)\$$#', $str, $match))
            return array($neg.'LIKE', search_escape($match[1], 'both'));
        elseif (preg_match('#^\^(.+)#', $str, $match))
            return array($neg.'LIKE', search_escape($match[1], 'start'));
        elseif (preg_match('#(.+)\$$#', $str, $match))
            return array($neg.'LIKE', search_escape($match[1], 'end'));
    // Default is no anchor
        return array($neg.'LIKE', search_escape($str));
    }

/**
 * Helps format search queries.
/**/
    function search_escape($value, $anchor='none') {
        global $db;
    // MySQL trims all text fields, so we should do the same
        $value = trim($value);
    // Where do we anchor? Replace whitespace with the % wildcard, too.
        switch ($anchor) {
            case 'both':
                return $db->escape($value);
            case 'start':
                return $db->escape(preg_replace('/[\\s-_]+/', '%', $value).'%');
            case 'end':
                return $db->escape('%'.preg_replace('/[\\s-_]+/', '%', $value));
            default:
                return $db->escape('%'.preg_replace('/[\\s-_]+/', '%', $value).'%');
        }
    }

/**
 * Prints out the entire advanced search string content block;
/**/
    function print_advanced_search_strings() {
    // Search fields
        static $search_fields;
        if (empty($search_fields)) {
            $search_fields = array(''            => '',
                                   'title'       => html_entities(t('Title')),
                                   'subtitle'    => html_entities(t('Subtitle')),
                                   'description' => html_entities(t('Description')),
                                   'category'    => html_entities(t('Category')),
                                   'people'      => html_entities(t('People')),
                                   'channum'     => html_entities(t('Chan. Number')),
                                   'channame'    => html_entities(t('Chan. Name')),
                                   'callsign'    => html_entities(t('Chan. Callsign')),
                                  );
        }
    // Adding a new search string, or just compress the existing one(s)
        if (isset($_REQUEST['add_search_string']))
            $strings = array_merge($_SESSION['search']['as'], array(''));
        else
            $strings = array_merge($_SESSION['search']['as']);
    // Print each string that we know about
        foreach ($strings as $i => $string) {
        // Join the strings how?
            if ($i != 0) {
                echo '<p><select name="aj[', $i, ']">';
                foreach (array('AND', 'OR') as $join) {
                    echo '<option';
                    if ($join == $_SESSION['search']['aj'][$i])
                        echo ' SELECTED';
                    echo ">$join</option>";
                }
                echo "</select></p>\n";
            }
        // Adding a new match field, or just compress the existing one(s)
            if (empty($_SESSION['search']['af'][$i]))
                $_SESSION['search']['af'][$i] = array('title');
            if (isset($_REQUEST['add_search_field']) && $_REQUEST['add_search_field'] == $i)
                $fields = array_merge($_SESSION['search']['af'][$i], array(''));
            else
                $fields = array_merge($_SESSION['search']['af'][$i]);
        // Which fields do we match against?
            foreach ($fields as $j => $af) {
                if ($j > 0)
                    echo ' ', t('or'), ' ';
                echo '<select name="af[', $i, '][', $j, ']" id="af', $i, '.', $j, '"',
                     ' onchange="search_field_change(', $i, ')">';
                foreach ($search_fields as $field => $name) {
                    if (empty($j) && empty($field))
                        continue;
                    echo '<option value="', $field, '"';
                    if ($af == $field)
                        echo ' SELECTED';
                    echo '>', $name, '</option>';
                }
                echo '</select>';
            }
            echo ' <a id="add_search_field_', $i, '" onclick="add_search_field(', $i, ')">', t('more'), '...</a>',
                 "<br>\n",
                 t('matches'), ': <input type="text" size="35" name="as[', $i, ']" id="as', $i, '" value="',
                 html_entities($string), "\" onchange=\"set_search('a')\">\n";
        }
        echo '<a onclick="add_search_string()">', t('add string'), '...</a>';
    }

/**
 * Prints out a list of program types, along with checkboxes.
/**/
    function category_type_list() {
        foreach (Program::category_types() as $key => $type) {
            $safe_type = html_entities($type);
            echo '<input type="checkbox" name="ctype[]" id="ctype_', $key,
                 '" value="',$safe_type, '"';
            if (in_array($type, $_SESSION['search']['ctype']))
                echo ' CHECKED';
            echo '><label for="ctype_', $key, '">', $safe_type, '</label>';
            if ($type == 'movie') {
                echo ': ',
                     movie_star_select('stars_gt'),
                     ' to ',
                     movie_star_select('stars_lt');
            }
            echo '<br>';
        }
    }

/**
 * Prints out a list of program types, along with checkboxes.
/**/
    function category_list() {
        echo "<select multiple name='categories[]' size='5'>";
        echo "<option ".(in_array(t('All'), $_SESSION['search']['categories']) ? 'selected' : '' ).">".t('All')."</option>";
        foreach (program::categories() as $category) {
            echo "<option ".(in_array($category, $_SESSION['search']['categories']) ? 'selected' : '' ).">$category</option>";
        }
        echo "</select>";
    }


/**
 * Print a <select> with movie star ratings in it.
/**/
    function movie_star_select($name) {
        echo '<select name="', $name, '">';
        for ($x=0; $x<=1; $x+=.125) {
            echo '<option value="', $x, '"';
            if ($x == $_SESSION['search'][$name])
                echo ' SELECTED';
            echo '>', str_repeat(star_character, intVal($x * max_stars));
            $frac = ($x * max_stars) - intVal($x * max_stars);
            if ($frac >= .75)
                echo '&frac34;';
            elseif ($frac >= .5)
                echo '&frac12;';
            elseif ($frac >= .25)
                echo '&frac14;';
            echo '</option>';
        }
        echo '</select>';
    }
