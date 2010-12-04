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
    if (!$Settings['tv']) {
?>
<h2>No TV Configured</h2>
<p>
MythTV is intended to run with TV settings configured.  Your installation does
not appear to have been fully configured for TV viewing (there are no channels).
If you intend to use MythTV's TV functionality, please finish configuration
via mythtv-setup before using MythWeb.
</p>
<p>
MythWeb is capable of functioning without TV settings, but so much of its
interface is designed to make the TV process as smooth as possible that you
will likely find many nonfunctional links to TV functionality.  Don't be
surprised to find &quot;unknown module&quot; messages when you follow links.
</p>
<?php
    }
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

</div>

<a id="reset" href="<?php echo root_url; ?>?RESET_SKIN&RESET_TMPL"><?php echo t('Reset template and skin to defaults'); ?></a>

<?php
// Print the page footer
    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
