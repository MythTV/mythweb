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
/*
    $SubModules[] = array('Name'    => 'Listings',
                          'URL'     => root.'/tv/list',
                          'Icon'    => skin_url.'img/Icons/logs'
                         );
*/
    $SubModules[] = array('Name'    => 'Upcoming',
                          'URL'     => root.'/tv/upcoming',
                          'Icon'    => skin_url.'img/Icons/clock'
                         );
/*
    $SubModules[] = array('Name'    => 'Schedules',
                          'URL'     => root.'/tv/schedules',
                          'Icon'    => skin_url.'img/Icons/cal'
                         );
*/
    $SubModules[] = array('Name'    => 'Recorded',
                          'URL'     => root.'/tv/list_recording_groups/',
                          'Icon'    => skin_url.'img/Icons/video'
                         );

    $Page_Previous_Location = root;
    $Page_Previous_Location_Name = 'MythWeb';
    $Page_Title_Short = 'Tv';

// Load the class for this page
    require_once tmpl_dir.'submenu.php';
