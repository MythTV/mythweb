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

// Make sure we're running a new enough version of php
    if (substr(phpversion(), 0, 3) < 4.3)
        trigger_error('You must be running at least php 4.3 to use this program.', FATAL);

// If we're not using php 5.0.0 or newer, setup some compatability functions
    if (version_compare(phpversion(), '5.0.0') < 0)
        require_once 'includes/php5_compat.php';

// For now, use the pear version of JSON until we can only support php 5.2 and thus use the builtin-json object...
    require_once 'includes/JSON.php';
