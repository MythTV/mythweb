<?php
/**
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/_shared/tmpl/default/welcome.php $
 * @date        $Date: 2008-02-09 18:36:08 -0800 (Sat, 09 Feb 2008) $
 * @version     $Revision: 15879 $
 * @author      $Author: kormoc $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

    $chanid    = $_REQUEST['chanid'];
    $starttime = $_REQUEST['starttime'];

    if ($_REQUEST['host']) {
        $host = $_REQUEST['host'];
        $frontends = MythFrontend::findFrontends();
        $frontends[$host]->play_program($chanid, $starttime);
        header('Location: '.root.'/tv/detail/'.urlencode($chanid).'/'.urlencode($starttime));
        exit;
    }

    $Page_Previous_Location = root.'/tv/detail/'.urlencode($chanid).'/'.urlencode($starttime);
    $Page_Previous_Location_Name = 'Details';
    $Page_Title_Short = 'Pick Frontend';

// Display the page
    require_once tmpl_dir.'play_program_on_frontend.php';
