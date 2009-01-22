<?php
/**
 * The display code for the main welcome page that lists the available mythweb
 * sections.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Set the desired page title
    $page_title = 'Welcome to MythWeb!';
    $Page_Title_Short = 'MythWeb';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/AppPanel.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="AppPanel">
    <?php
        $module_directories = get_sorted_files(modules_path);
        $module_directories = array_unique(array_merge(array('tv', 'video', 'music', 'remote', 'settings'), $module_directories));
        foreach ($module_directories as $module) {
            if (preg_match('/^_/', $module))
                continue;
            if (!file_exists("modules/$module/tmpl/".tmpl.'/welcome.php'))
                continue;

            require "modules/$module/tmpl/".tmpl.'/welcome.php';
            ?>
            <div class="appicon">
                <a href="<?php echo $Module_URL; ?>">
                    <img src="<?php echo $Module_Icon; ?>.png"><br>
                    <?php echo $Module_Name; ?>
                </a>
            </div>
            <?php
        }
    ?>
</div>

<a id="reset" href="<?php echo root; ?>?RESET_SKIN&RESET_TMPL"><?php echo t('Reset template and skin to defaults'); ?></a>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
