<?php
/***                                                                        ***\
    status.php                               Last Updated: 2005.02.06 (xris)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.
\***                                                                        ***/

// Initialize the script, database, etc.
    require_once "includes/init.php";

// Get the address/port of the master machine
    $masterhost = get_backend_setting('MasterServerIP');
    $statusport = get_backend_setting('BackendStatusPort');

// Make sure the content is interpreted as UTF-8
    header('Content-Type:  text/html; charset=UTF-8');

// Load the status page
    if (function_exists('file_get_contents'))
        $page .= file_get_contents("http://$masterhost:$statusport");
    else
        $page .= implode("\n", file("http://$masterhost:$statusport"));

// Extract the page title
    preg_match('#<title>(.+?)</title>#s', $page, $title);
    $title = $title[1];

// Clean up the page, and add some invisible content with the actual URL grabbed
    $page = "<!-- Obtained from:  http://$masterhost:$statusport -->\n"
           .preg_replace('#\s*</body>\s*</html>\s*$#s', '',
                preg_replace('/^.+?<body>\s*\n/s', "\n",
                    $page
                )
            );

// Load the class for this page
    require_once theme_dir.'status.php';

// Create the page object
    $Page = new Theme_status;

// Print the page
    $Page->print_page($page, $title);

?>

