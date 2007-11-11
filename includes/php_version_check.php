<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @url         $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/includes/init.php $
 * @date        $Date: 2007-07-28 21:46:51 -0700 (Sat, 28 Jul 2007) $
 * @version     $Revision: 14075 $
 * @author      $Author: xris $
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Make sure we're running a new enough version of php
    if (substr(phpversion(), 0, 3) < 4.3)
        trigger_error('You must be running at least php 4.3 to use this program.', FATAL);

// If we're not using php 5.0.0 or newer, setup some compatability functions
    if (version_compare(phpversion(), '5.0.0') < 0)
        require_once 'includes/php5_compat.php';
