<?php
/**
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
/**/
/*
    $SubModules[] = array('Name'    => 'Listings',
                          'URL'     => 'tv/list',
                          'Icon'    => skin_url.'img/Icons/logs'
                         );
*/
    $SubModules[] = array('Name'    => 'Upcoming',
                          'URL'     => 'tv/upcoming',
                          'Icon'    => skin_url.'img/Icons/clock'
                         );
/*
    $SubModules[] = array('Name'    => 'Schedules',
                          'URL'     => 'tv/schedules',
                          'Icon'    => skin_url.'img/Icons/cal'
                         );
*/
    $SubModules[] = array('Name'    => 'Recorded',
                          'URL'     => 'tv/list_recording_groups/',
                          'Icon'    => skin_url.'img/Icons/video'
                         );

    $Page_Previous_Location = root_url;
    $Page_Previous_Location_Name = 'MythWeb';
    $Page_Title_Short = 'Tv';

// Load the class for this page
    require_once tmpl_dir.'submenu.php';
