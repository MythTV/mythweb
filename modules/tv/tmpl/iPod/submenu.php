<?php
/**
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/tv/tmpl/default/list.php $
 * @date        $Date: 2008-06-21 17:31:37 -0700 (Sat, 21 Jun 2008) $
 * @version     $Revision: 17555 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
/**/

// Set the desired page title
    $page_title = 'MythWeb - ' . t('TV Submenu');

    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/AppPanel.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="AppPanel">
    <?php
        foreach ($SubModules as $submodule) {
            ?>
            <div class="appicon">
                <a href="<?php echo $submodule['URL']; ?>">
                    <img src="<?php echo $submodule['Icon']; ?>.png"><br>
                    <?php echo $submodule['Name']; ?>
                </a>
            </div>
            <?php
        }
    ?>
</div>

<?php
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
?>
