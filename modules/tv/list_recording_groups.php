<?php
/**
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/tv/recorded.php $
 * @date        $Date: 2008-03-26 12:46:06 -0700 (Wed, 26 Mar 2008) $
 * @version     $Revision: 16806 $
 * @author      $Author: xris $
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
/**/

    $sh = $db->query('SELECT DISTINCT recorded.recgroup
                        FROM recorded');
    while ($group = $sh->fetch_col())
        $Groups[] = $group;

    $Groups[] = 'All';
    $Groups[] = 'iPod viewable';

    $Page_Previous_Location = root.'/tv/submenu';
    $Page_Previous_Location_Name = 'Television';
    $Page_Title_Short = 'Rec Groups';

// Load the class for this page
    require_once tmpl_dir.'list_recording_groups.php';
