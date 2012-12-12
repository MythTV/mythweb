<?php
/**
 *
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
        header('Location: '.root_url.'tv/detail/'.urlencode($chanid).'/'.urlencode($starttime));
        exit;
    }

    $Page_Previous_Location = root_url.'tv/detail/'.urlencode($chanid).'/'.urlencode($starttime);
    $Page_Previous_Location_Name = 'Details';
    $Page_Title_Short = 'Pick Frontend';

// Display the page
    require_once tmpl_dir.'play_program_on_frontend.php';
