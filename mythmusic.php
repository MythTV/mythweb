<?php

	//
	//	This file is part of MythWeb,
	//	a php-based interface into MythTV.
	//
	//	(c) 2002 by Thor Sigvaldason and Isaac Richards
	//	MythWeb is distributed under the
	//	GNU GENERAL PUBLIC LICENSE version 2
	//	(see http://www.gnu.org)
	//


//
//	Someday, music.php will let us stream
//	entire playlists to any spot on planet earth
//
require_once "includes/init.php";
require_once "themes/Default/mythmusic.php";

$music = new Theme_mythmusic();

$music->print_page();

?>