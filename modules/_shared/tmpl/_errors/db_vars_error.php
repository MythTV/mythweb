<?php
/**
 *
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - Error - Database Setup Error';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="skins/errors.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="message">

<h2>Database Setup Error</h2>

<p>
    The database environment variables are not correctly
    set in the webserver conf or .htaccess file.
    Please read through the comments included in the file
    and set up the db_* environment variables correctly.
</p>

<p>
    Some possible solutions are to make sure that mod_env
    is enabled in httpd.conf, as well as having followed
    the instructions in the README and INSTALL files.
</p>

</div>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
