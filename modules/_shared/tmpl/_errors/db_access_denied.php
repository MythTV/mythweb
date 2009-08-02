<?php
/**
 *
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.t('Error').' - '.t('Database Access Denied');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="skins/errors.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="message">

<h2><?php echo t('Database Access Denied'); ?></h2>

<p>
    <?php echo t('You are most likely receiving this message because you have failed to configure mythweb\'s database login info.'); ?>
</p>

<p>
    <?php echo t('Please see INSTALL for instructions.'); ?>
</p>

</div>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
