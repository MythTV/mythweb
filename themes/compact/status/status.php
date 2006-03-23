<?php
/**
 * The display code for the main welcome page that lists the available mythweb
 * sections.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Set the desired page title
    $page_title = 'MythTV Backend Status';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/status.css" />';

// Print the page header
    require_once theme_dir.'/header.php';

// Print the content itself
    echo "<div id=\"content_wrapper\">\n"
        .$status
        ."\n</div>";

// Print the page footer
    require_once theme_dir.'/footer.php';

