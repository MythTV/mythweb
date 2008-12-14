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
    $page_title = 'MythWeb - ' . t('Upcoming Recordings');

    $headers[] = '<link rel="stylesheet" type="text/css" href="'.skin_url.'/ListPanel.css">';

    // Setup some vars for the ipod template
    $Page_Previous_Location = root.'tv/submenu';
    $Page_Previous_Location_Name = 'Television';
    $Page_Title_Short = 'Upcoming';

// Print the page header
    require 'modules/_shared/tmpl/'.tmpl.'/header.php';

    $prev_group = '';

    foreach ($all_shows as $show) {
        if ($show->recstatus != 'Recording' && $show->recstatus != 'WillRecord')
            continue;

        $cur_group = strftime($_SESSION['date_listing_jump'], $show->recstartts);

        if ($cur_group != $prev_group) {
            if ($prev_group != '')
                echo '</ul>';
            echo '<h3>'.$cur_group.'</h3>';
            echo '<ul class="ListPanel">';
        }

        $prev_group = $cur_group;

        echo '<li class="small"><span class="right" style="padding-top: 4px; padding-right: 4px;">'.date('H:i', $show->recstartts).' - '.date('H:i', $show->recendts).'</span><div class="text" style="max-height: 15px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 4px 8px 8px 8px;" >'.$show->title.( $show->subtitle ? ': '.$show->subtitle : '').'</div>';
    }

    echo '</ul>';

    require 'modules/_shared/tmpl/'.tmpl.'/footer.php';
?>
