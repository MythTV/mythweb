<?
/***                                                                ***\
    errordisplay.php				Last Updated: 2003.05.27 (xris)

	This file contains a number of error-display related routines
\***                                                                ***/

// These are arrays that will contain error messages
	$Errors = array();
	$Warnings = array();

// This is an associative array for keeping track of whether items have been marked as "bad"
// in order that they can properly be displayed with highlight_error()
	$BadItems = array();

// This function will actually display any errors or warnings
	function display_errors($leading='<p align="center">', $trailing = '</p>') {
		global $Errors, $Warnings;
		$errstr = implode("<BR>\n", array_merge($Errors, $Warnings));
		if (!$errstr) return;
		echo "$leading<table border=\"1\" cellspacing=\"0\" cellpadding=\"8\" class=\"error\"><tr><td>$errstr</td></tr></table>$trailing";
	}

// This function just draws a simple red line around something, to mark it as containing erroneous data
	function highlight_error($content, $field = '') {
		global $BadItems;
		if (!$field || $BadItems[$field])
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\" class=\"error\"><tr><td>$content</td></tr></table>";
		else
			echo $content;
	}

?>
