<?php
/**
 * Various routines that deal with figuring out and/or displaying css.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

/**
 * Returns a classname for a Program or a Schedule, based on its recording
 * settings.
/**/
    function category_class(&$item) {
        $css_class = array();
        $cache = array();
    // Disable categories colorization
        if (isset($_SESSION['genre_colors'])
                  && $_SESSION['genre_colors'] == 0) {
            $css_class[] = $cache[$category] = 'cat_Unknown';
            return $css_class[0];
        }
    // Recording classes?
        $css_class[] = recstatus_class($item);
    // Category type?
        if ($item->category_type && !preg_match('/unknown/i', $item->category_type))
            $css_class[] = 'type_'.preg_replace("/[^a-zA-Z0-9\-_]+/", '_', $item->category_type);
    // Category cache
        $category = strtolower($item->category);    // user lowercase to avoid a little overhead later
        static $cache = array();
        if ($cache[$category])
            $css_class[] = $cache[$category];
    // Scan the $Categories hash for any matches
        else {
            global $Categories;
            if (!empty($Categories)) {
                foreach ($Categories as $cat => $details) {
                    if ($category == strtolower($details[0])) {
                        $css_class[] = $cache[$category] = 'cat_'.$cat;
                        break;
                    }
                    if (!$details[1])
                        continue;
                    if (preg_match('/'.$details[1].'/', $category)) {
                        $css_class[] = $cache[$category] = 'cat_'.$cat;
                        break;
                    }
                }
            }
        }
    // No category found?
        if (!$cache[$category])
            $css_class[] = $cache[$category] = 'cat_Unknown';
    // Return
        return preg_replace('/ +/', ' ', implode(' ', $css_class));
    }

/**
 * Returns a classname for a Program or a Schedule, based on its recording
 * status.
/**/
    function recstatus_class(&$item) {
        if ($item->recstatus && !strcasecmp(get_class($item), 'program')) {
            switch ($item->recstatus) {
                case 'ForceRecord':
                    return 'record_override_record';
                case 'Recording':
                case 'WillRecord':
                    return 'will_record';
                case 'Conflict':
                case 'Overlap':
                    return 'record_conflicting';
                case 'PreviousRecording':
                case 'CurrentRecording':
                    return 'record_duplicate';
                case 'Recorded':
                    return 'record_old_duplicate';
                case 'ManualOverride':
                case 'Cancelled':
                    return 'record_override_suppress';
                default:
                    return 'record_suppressed';
            }
        }
        return NULL;
    }

