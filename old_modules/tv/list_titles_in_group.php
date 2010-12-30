<?php
/**
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
/**/

    if (!isset($_REQUEST['group']) || strtolower($_REQUEST['group']) == 'all')
        $group = 'All';
    else
        $group = $_REQUEST['group'];

    $sh = $db->query('SELECT recorded.title,
                             COUNT(recorded.subtitle) AS `count`
                        FROM recorded
                       WHERE recorded.recgroup LIKE ?
                    GROUP BY recorded.title
                    ORDER BY recorded.title
                    ',
                    ($group == 'All' ? '%' : $group));
    while ($title = $sh->fetch_row())
        $Titles[] = $title;

    $Page_Previous_Location = root_url.'tv/list_recording_groups';
    $Page_Previous_Location_Name = 'Rec Groups';
    $Page_Title_Short = 'Titles ('.$group.')';

// Load the class for this page
    require_once tmpl_dir.'list_titles_in_group.php';
