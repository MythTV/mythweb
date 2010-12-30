<?php
/**
 * This file is part of MythWeb, a php-based interface for MythTV.
 * See http://www.mythtv.org/ for details.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/
    define('PHP_MIN_VERSION', floatval(5.3));

// Make sure we're running a new enough version of php
    if (floatval(substr(phpversion(), 0, 3)) < PHP_MIN_VERSION)
        trigger_error('You must be running at least php '.PHP_MIN_VERSION.' to use this program.', FATAL);

    if (   !extension_loaded('mysql')
        && !extension_loaded('mysqli')
        && !extension_loaded('mysqlnd'))
        trigger_error('You are missing a php extension for mysql interaction. Please install php-mysqli or similar', FATAL);
