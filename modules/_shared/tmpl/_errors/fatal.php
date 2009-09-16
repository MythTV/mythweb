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
    $page_title = 'MythWeb - '.t('Error').' - '.htmlentities($errstr, ENT_COMPAT, 'UTF-8');

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="skins/errors.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="message">

<h2><?php echo t('Fatal Error'); ?></h2>

<p class="err">
    <?php echo nl2br(htmlentities($errstr, ENT_COMPAT, 'UTF-8')) ?>
</p>

<div id="backtrace">

    <p>
        <?php echo t('If you choose to $1 submit a bug report $2 please make sure to include a brief description of what you were doing,
                        along with the following backtrace as an attachment <i>(please don\'t just paste the whole thing into the ticket)</i>.',
                     '<b><u><a href="http://svn.mythtv.org/trac/newticket" target="_blank">',
                     '</a></u></b>'); ?>
    </p>

    <textarea cols=100 rows=100><?php echo htmlentities($err) ?></textarea>

</div>


</div>

<?php

// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
