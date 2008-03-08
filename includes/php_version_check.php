<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/
    define('PHP_MIN_VERSION', 5.1);

// Make sure we're running a new enough version of php
    if (substr(phpversion(), 0, 3) < PHP_MIN_VERSION)
        trigger_error('You must be running at least php '.PHP_MIN_VERSION.' to use this program.', FATAL);
