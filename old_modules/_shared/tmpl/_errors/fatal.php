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
    $page_title = 'MythWeb - Error - '.htmlentities($errstr, ENT_COMPAT, 'UTF-8');
// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="skins/errors.css">';
?>

<div id="message">

<h2>Fatal Error</h2>

<p class="err">
    <?php echo nl2br(htmlentities($errstr, ENT_COMPAT, 'UTF-8')) ?>
</p>

<div id="backtrace">

    <p>
        If you choose to <b><u><a href="http://svn.mythtv.org/trac/newticket" target="_blank"> submit a bug report </a></u></b>
        please make sure to include a brief description of what you were doing,
        along with the following backtrace as an attachment <i>(please don\'t just paste the whole thing into the ticket)</i>
    </p>

    <textarea cols=100 rows=100><?php echo htmlentities($err) ?></textarea>

</div>


</div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
