<?php
/*
 * Created on Mar 18, 2005
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Initialize the script, database, etc.
    require_once "includes/init.php";
 
 // Load all of the channel data from the database
    $result = mysql_query('SELECT * FROM mythlog ORDER BY logid desc limit 100')
        or trigger_error('SQL Error: '.mysql_error(), FATAL);
    $Logs = array();
    while ($row = mysql_fetch_assoc($result))
        $Logs[] = $row;
    mysql_free_result($result);
    
// Load the class for this page
    require_once theme_dir.'log.php';

// Create an instance of this page from its theme object
    $Page = new Theme_Logs();

// Display the page
    $Page->print_page();

// Exit
    exit;
    
 
?>
