<?php
/**
 * Print the program list
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Set the desired page title
    $page_title = 'MythWeb - ' . t('Program Listing') . ': '.strftime($_SESSION['date_statusbar'], $list_starttime);

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/tv_list.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<script type="application/x-javascript">
    function list_update(timestamp) {
        ajax_add_request();
        new Ajax.Updater($('list_content'),
                         '<?php echo root ?>tv/list',
                         {
                            parameters: {
                                            ajax: true,
                                            time: timestamp
                                        },
                            onComplete: ajax_remove_request
                         }
                        );
    }
</script>

<div id="list_content">
    <?php require_once tmpl_dir.'list_data.php'; ?>
</div>
<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
