<?php
/***                                                                        ***\
	utils.php                             Last Updated: 2003.08.02 (xris)

	utility routines used throughout mythweb
\***                                                                        ***/

	//
	//	This file is part of MythWeb,
	//	a php-based interface into MythTV.
	//
	//	(c) 2002 by Thor Sigvaldason and Isaac Richards
	//	MythWeb is distributed under the
	//	GNU GENERAL PUBLIC LICENSE version 2
	//	(see http://www.gnu.org)
	//

// Set up some constants used by nice_filesystem()
	define('kb', 1024);			// Kilobyte
	define('mb', 1024 * kb);	// Megabyte
	define('gb', 1024 * mb);	// Gigabyte
	define('tb', 1024 * gb);	// Terabyte

/*
	nice_filesize:
	pass in a filesize in bytes, and receive a more human-readable version
	JS: adapted from php.net: sponger 10-Jun-2002 12:28
*/
function nice_filesize($size) {
//	If it's less than a kb we just return the size
	if ($size < kb)
		return $size.' B';
// Otherwise we keep going until the size is in the appropriate measurement range.
	elseif ($size < mb)
		return round($size / kb, 1).' KB';
	elseif ($size < gb)
		return round($size / mb, 1).' MB';
	elseif ($size < tb)
		return round($size / gb, 1).' GB';
	else
		return round($size / tb, 1).' TB';
}

/*
	nice_largefilesize:
	pass in high- and low-word portions of a large filesize in bytes,
	and receive a more human-readable version
*/

function nice_largefilesize($high_word, $low_word) {
// An array of the various human-readable sizes
	static $label = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB');
// Make sure we have integers
	$high_word = (int)$high_word;
	$low_word  = (int)$low_word;
// Leave early?  (zero-byte file)
	if ($low_word == 0)
		return '0 B';
// start going through the bits and doing some shifting
	$shiftcount = 0;
	while ($shiftcount < 6 && ($high_word != 0 || $low_word <= 0 || $low_word > 1024)) {
		$high_lowbits = $high_word & 0x3FF;
		$high_word >>= 10;

		$low_lowbits = $low_word & 0x3FF;
		if ($low_word < 0)
			$low_word = (((($low_word & 0x7FFFFFFF)) >> 1) | 0x40000000) >> 9;
		else
			$low_word >>= 10;
		$low_word |= $high_lowbits << 22;
		$shiftcount++;
	}
// Cleanup and return
	$low_word += round($low_lowbits / 1024, 1);
	return $low_word . $label[$shiftcount];
}

/*
	unixtime:
	converts an sql timestamp into unixtime
*/
	function unixtime($sql_timestamp) {
		return mktime(substr($sql_timestamp, 8, 2),		// hour
					  substr($sql_timestamp, 10, 2),	// minute
					  substr($sql_timestamp, 12, 2),	// second
					  substr($sql_timestamp, 4, 2),		// month
					  substr($sql_timestamp, 6, 2),		// day
					  substr($sql_timestamp, 0, 4));	// year
	}

/*
	escape:
	For lack of a function that escapes strings AND adds quotes, I wrote one
	myself to make the rest of my code read a bit easier.
*/
	function escape($string) {
		return "'".mysql_escape_string($string)."'";
	}

/*
	DEBUG:
	prints out a piece of data
*/
	function DEBUG($data) {
		echo "<hr>";
		if (is_array($data) || is_object($data)) {
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
		elseif (isset($data))
			echo $data;
		else
			echo "NULL";
		echo "<hr>";
	}

?>
