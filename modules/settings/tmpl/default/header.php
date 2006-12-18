<?php
/**
 * Header for the settings section
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
/**/

// Set the desired page title
    $page_title = 'MythWeb - '.$Settings[$Path[1]]['name'].' :: '.$Settings[$Path[1]]['choices'][$Path[2]];

// Custom headers
    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/settings.css" />';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

?>

<table id="settings" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td class="_overview" rowspan="2" valign="top">
        <div class="_title">
            <?php echo t('Settings') ?>:
        </div>
        <div class="_modules">
            <ul><?php
                foreach ($Settings as $module => $set) {
                    echo '<li><a href="', root, 'settings/', $module;
                    if ($module == $Path[1])
                        echo '" class="_selected';
                    echo '">', html_entities($set['name']), '</a></li>';
                }
                ?></ul>
        </div>
        <div class="_notice">
            <?php echo t('settings: notice') ?>
        </div>
        </td>
    <td class="_sections">
        <ul><?php
            foreach ($Settings[$Path[1]]['choices'] as $path => $name) {
                echo '<li><a href="', root, 'settings/', $Path[1];
                if ($path == $Path[2])
                    echo '" class="_selected';
                else
                    echo '/'.$path;
                echo '">', html_entities($name), '</a></li>';
            }
        ?></ul>
        </td>
    <td class="_host"><?php echo t('Edit settings for: $1', host_choices()) ?></td>
</tr><tr>
    <td class="_content" colspan="2">

