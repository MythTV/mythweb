<?php
/**
 * Welcome page for the WAP template
 *
 * @license     GPL
 *
 * @package     MythTV
 *
/**/

   require_once 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<a id="reset" href="<?php echo root_url; ?>?RESET_SKIN&RESET_TMPL"><?php echo t('Reset template and skin to defaults'); ?></a>

<?php
   require_once 'modules/_shared/tmpl/'.tmpl.'/footer.php';
