<?php
/**
 * Collection of functions used by the various pages that set up recording
 * schedules.
 *
 * @license     GPL
 *
 * @package     MythTV
 * @subpackage  TV
 *
/**/

/**
 *  Generates a schedule filter parameter from the POST parameters
/**/
    function generateFilter() {
        $total = 0;
        foreach (Schedule::availableRecordFilters() as $id => $filter) {
            $enabled = intval($_POST["recordfilter_$id"]);
            $total |= $enabled << $id;
        }
        return $total;
    }

/**
 * Prints a <select> of the available recording inputs
/**/
    function input_select($selected, $ename='prefinput') {
        static $inputs;
    // Gather the data
        if (empty($inputs)) {
            global $db;
            $sh = $db->query('SELECT cardinputid,
                                     IF(LENGTH(IFNULL(displayname,"")) > 0,
                                        displayname,
                                        CONCAT(cardid, ":", inputname)
                                       ) AS name
                                FROM cardinput
                            ORDER BY name');
            while (list($id, $name) = $sh->fetch_row()) {
                $inputs[$id] = $name;
            }
            $sh->finish();
        }
    // Only one input?
        if (count($inputs) == 1) {
            list($id, $name) = reset($inputs);
            echo '<input type="hidden" name="', $ename, '" value="0">',
                 t('Any');
        }
    // Print the whole <select>
        else {
            echo '<select name="', $ename, '">',
                 '<option value="0">', t('Any'), '</option>';
            foreach ($inputs as $id => $name) {
                echo '<option value="', $id, '"';
                if ($selected && $id == $selected)
                    echo ' SELECTED';
                echo '>', html_entities($name), '</option>';
            }
            echo '</select>';
        }
    }
