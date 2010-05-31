<?php
/**
 * This stub redirects to the default header.
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/_shared/tmpl/default/header.php $
 * @date        $Date: 2009-08-01 21:50:00 -0700 (Sat, 01 Aug 2009) $
 * @version     $Revision: 21099 $
 * @author      $Author: kormoc $
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
