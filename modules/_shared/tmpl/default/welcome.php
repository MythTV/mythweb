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
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/welcome.css">';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';
?>

<script type="text/javascript">
<!--

    var visible_module = 'tv';
    function show_module_info(module) {
        if (visible_module == module)
            return;
    // Change the outline on the list item
        $('module_'+ visible_module).removeClassName('selected');
        $('module_'+ module).addClassName('selected');
    // Show and hide the appropriate info boxes
        $('info_' + visible_module).hide();
        $('info_' + visible_module).addClassName('hidden');
        $('info_' + module).show();
        $('info_' + module).removeClassName('hidden');
    // Keep track of what's visible now
        visible_module = module;
    }

// -->
</script>

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
        if ($id == 'tv')
            echo ' class="selected"';
        echo ' onmouseover="show_module_info(\''.$id.'\')">',
             '<a href="', root_url, $module['path'], '">', $module['name'], '</a>',
             "</li>\n";
    }
?>
    </ul>
    </div>

    <div id="module_info">
<?php
// Print out the list of modules.  Each theme should include a welcome page for
// each module.
    foreach (Modules::getModules() as $id => $module) {
    // Hidden module?
        if ($module['hidden'])
            continue;
        require "modules/$id/tmpl/".tmpl.'/welcome.php';
    }
?>
    </div>

    <div id="mythtv_link">
        <a href="http://www.mythtv.org/"><?php echo t('Visit $1', 'MythTV.org') ?></a>
    </div>

<?php
    if (!$Settings['tv']) {
?>
        <div id="tv_warning">
            <h2><?php echo t('No TV configured!'); ?></h2>
            <p>
            <?php echo t('NO_TV_CONFIGURED_NOTICE_1'); ?>
            </p>
            <p>
            <?php echo t('NO_TV_CONFIGURED_NOTICE_2'); ?>
            </p>
        </div>
<?php
    }
?>

</div>

<a id="reset" href="<?php echo root_url; ?>?RESET_SKIN&RESET_TMPL"><?php echo t('Reset template and skin to defaults'); ?></a>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
