<?php
/**
 * The display code for the main welcome page that lists the available mythweb
 * sections.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Set the desired page title
    $page_title = 'Welcome to MythWeb!';

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/welcome.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<div id="modules" class="clearfix">

    <div id="module_names">
    <ul>
<?php
// Print out the list of modules
    foreach (Modules::getModules() as $id => $module) {
    // Hidden module?
        if ($module['hidden'])
            continue;
    // Show this module
        echo '        <li id="module_', $id, '"';
        if ($id == $_REQUEST['view_module'])
            echo ' class="selected"';
        echo '">',
             '<a href="', root_url, '?view_module=', urlencode($id), '">', $module['name'], '</a>',
             "</li>\n";
    }
?>
    </ul>
    </div>

    <div id="module_info">
<?php
// Each template should include a welcome page for each module.
    require 'modules/'.$_REQUEST['view_module'].'/tmpl/'.tmpl.'/welcome.php';
?>
    </div>

    <div id="mythtv_link">
        <a href="http://www.mythtv.org/"><?php echo t('Visit $1', 'MythTV.org') ?></a>
    </div>

</div>

<a id="reset" href="<?php echo root_url; ?>?RESET_SKIN&RESET_TMPL"><?php echo t('Reset template and skin to defaults'); ?></a>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
