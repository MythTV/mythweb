<?php
/**
 * This stub redirects to the default header.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

if (!defined('tmpl'))
    define('tmpl', 'default');
else
    die('I have no idea why you are here, please report to svn.mythtv.org');

require 'modules/_shared/tmpl/'.tmpl.'/header.php';
