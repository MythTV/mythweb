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
    $page_title = 'MythWeb - Error';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="skins/errors.css">';

// Print the page header
    @include 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="message">

<h2><?php echo htmlentities($header, ENT_COMPAT, 'UTF-8') ?></h2>

<p>
<?php echo nl2br(htmlentities($text, ENT_COMPAT, 'UTF-8')) ?>
</p>

</div>

<?php

// Print the page footer
    @include 'modules/_shared/tmpl/'.tmpl.'/footer.php';
