<?php
/***                                                                        ***\
    css.php                                  Last Updated: 2005.02.04 (xris)

    various routines that deal with figuring out and/or displaying css.
\***                                                                        ***/

/*
    category_class:
    returns a classname for a Program or a Schedule, based on its recording
    settings.
*/
    function category_class(&$item) {
        $class = '';
    // Recording classes?
        if ($item->recordid && !strcasecmp(get_class($item), 'program')) {
            if ($item->recstatus == 'ForceRecord')
                $class .= 'record_override_record ';
            elseif ($item->recstatus == 'WillRecord')
                $class .= 'will_record ';
            elseif ($item->recstatus == 'Conflict' || $item->recstatus == 'Overlap')
                $class .= 'record_conflicting ';
            elseif ($item->recstatus == 'PreviousRecording' || $item->recstatus == 'CurrentRecording')
                $class .= 'record_duplicate ';
            elseif ($item->recstatus == 'ManualOverride' || $item->recstatus == 'Cancelled')
                $class .= 'record_override_suppress ';
            else
                $class .= 'record_suppressed ';
        }
    // Category type?
        if ($item->category_type && !preg_match('/unknown/i', $item->category_type))
            $class .= 'type_'.preg_replace("/[^a-zA-Z0-9\-_]+/", '_', $item->category_type).' ';
    // Category cache
        $category = strtolower($item->category);    // user lowercase to avoid a little overhead later
        static $cache = array();
        if ($cache[$category])
            $class .= $cache[$category];
    // Scan the $Categories hash for any matches
        else {
            global $Categories;
            foreach ($Categories as $cat => $details) {
                if (!$details[1])
                    continue;
                if (preg_match('/'.$details[1].'/', $category)) {
                    $class .= $cache[$category] = 'cat_'.$cat.' ';
                    break;
                }
            }
        }
    // No category found?
        if (!$cache[$category])
            $class .= $cache[$category] = 'cat_Unknown';
    // Return
        return trim($class);
    }


?>
