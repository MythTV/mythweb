<?php
/**
 * Proxies requests to ttvdb.com so that we can grab images from their site
 * Tries to avoid being a total open proxy by only proxying to thetvdb.com
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

    header('Content-Type: image/jpg');

    echo @file_get_contents("http://www.thetvdb.com" . $_REQUEST['url']);
