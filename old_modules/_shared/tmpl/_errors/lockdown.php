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
    $page_title = 'MythWeb - '.t('Error');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="skins/errors.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="message">

<h2><?php echo t('MythWeb Locked'); ?></h2>

<p>
<?php
    echo t('LOCKDOWN_NOTICE').' '.realpath('lockdown').' '.t('LOCKDOWN_NOTICE_2');
?>
</p>

</div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
