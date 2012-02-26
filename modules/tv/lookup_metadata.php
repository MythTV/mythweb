<?php
/**
 * Does a query against the backend to look up metadata for a show
 * returns the result as JSON
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

    header('Content-Type: application/json');

    $url = "Video/LookupVideo";
    $args = array( 
                   'Title'        => $_REQUEST['title'],
                   'Subtitle'     => $_REQUEST['subtitle'],
                   'Inetref'      => $_REQUEST['inetref'],
                   'Season'       => $_REQUEST['season'],
                   'Episode'      => $_REQUEST['episode'],
                   'GrabberType'  => $_REQUEST['grabbertype'],
                   'AllowGeneric' => $_REQUEST['allowgeneric']);

    echo MythBackend::find()->httpRequestAsJson($url, $args);
