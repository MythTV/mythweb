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

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/welcome.css" />';

// Print the page header
    require_once theme_dir.'/header.php';
?>

<script language="JavaScript" type="text/javascript">
<!--

    var visible_module = 'tv';
    function show_module_info(module) {
        if (visible_module == module)
            return;
    // Change the outline on the list item
        remove_class('module_' + visible_module, 'selected');
        add_class('module_'    + module,         'selected');
    // Show and hide the appropriate info boxes
        toggle_vis('info_' + visible_module);
        toggle_vis('info_' + module);
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
    foreach ($Modules as $id => $module) {
    // Hidden module?
        if ($module['hidden'])
            continue;
    // Show this module
        echo '        <li id="module_', $id, '"';
        if ($id == 'tv')
            echo ' class="selected"';
        echo ' onmouseover="show_module_info(\''.$id.'\')">',
             '<a href="', root, $module['path'], '">', $module['name'], '</a>',
             "</li>\n";
    }
?>
    </ul>
    </div>

    <div id="module_info">
<?php
// Print out the list of modules.  Each theme should include a welcome page for
// each module.
    foreach ($Modules as $id => $module) {
        @include(theme_dir.'/'.$id.'/welcome.php');
    }
?>
    </div>

    <div id="mythtv_link">
        <a href="http://www.mythtv.org/"><?php echo t('Visit $1', 'MythTV.org') ?></a>
    </div>

</div>

<?php
// Print the page footer
    require_once theme_dir.'/footer.php';

