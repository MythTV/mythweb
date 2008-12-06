<?php
/**
 * Welcome page for the WAP template
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythTV
 *
/**/

   require_once 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<a id="reset" href="<?php echo root; ?>?RESET_SKIN&RESET_TMPL"><?php echo t('Reset template and skin to defaults'); ?></a>

<?php
   require_once 'modules/_shared/tmpl/'.tmpl.'/footer.php';
