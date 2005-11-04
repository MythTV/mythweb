<?php
/***                                                                        ***\
    css.php                                  Last Updated: 2005.03.21 (xris)

    various routines that deal with figuring out and/or displaying css.
\***                                                                        ***/

/*
    category_class:
    returns a classname for a Program or a Schedule, based on its recording
    settings.
*/
    function category_class(&$item) {
        $class =array();
    // Recording classes?
        $class[] = recstatus_class($item);
    // Category type?
        if ($item->category_type && !preg_match('/unknown/i', $item->category_type))
            $class[] = 'type_'.preg_replace("/[^a-zA-Z0-9\-_]+/", '_', $item->category_type);
    // Category cache
        $category = strtolower($item->category);    // user lowercase to avoid a little overhead later
        static $cache = array();
        if ($cache[$category])
            $class[] = $cache[$category];
    // Scan the $Categories hash for any matches
        else {
            global $Categories;
            foreach ($Categories as $cat => $details) {
                if (!$details[1])
                    continue;
                if (preg_match('/'.$details[1].'/', $category)) {
                    $class[] = $cache[$category] = 'cat_'.$cat;
                    break;
                }
            }
        }
    // No category found?
        if (!$cache[$category])
            $class[] = $cache[$category] = 'cat_Unknown';
    // Return
        return preg_replace('/ +/', ' ', implode(' ', $class));
    }

/*
    recstatus_class:
    Returns a classname for a Program or a Schedule, based on its recording
    status.
*/
    function recstatus_class(&$item) {
        if ($item->recordid && !strcasecmp(get_class($item), 'program')) {
            switch ($item->recstatus) {
                case 'ForceRecord':
                    return 'record_override_record';
                case 'WillRecord':
                    return 'will_record';
                case 'Conflict':
                case 'Overlap':
                    return 'record_conflicting';
                case 'PreviousRecording':
                case 'CurrentRecording':
                    return 'record_duplicate';
                case 'ManualOverride':
                case 'Cancelled':
                    return 'record_override_suppress';
                default:
                    return 'record_suppressed';
            }
        }
        return NULL;
    }

