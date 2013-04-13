<?php
/**
 * Request any recommended shows from the engine and display them
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

	$recommend_enabled = setting('recommend_enabled', null);
	$recommend_server = setting('recommend_server', null);
	$recommend_key = setting('recommend_key', null);
	
	
	$url = "{$recommend_server}/shows/recommended.json?auth_token={$recommend_key}";
	
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$r=curl_exec($ch);
	curl_close($ch);
	
	$results = json_decode($r, true);
	$shows = array();
	$query = '';
	
	
	foreach($results as $result) {
		if (!strlen($result['tms_id']))
			continue;
		if (strlen($query))
			$query .= ' OR ';
		$query .= " program.seriesid = '{$result['tms_id']}'";
		
	}
	
	$shows =& load_all_program_data(time(), strtotime('+1 month'), NULL, false, "({$query})", true);

// Load the class for this page
    require_once tmpl_dir.'recommended.php';

// Exit
    exit;
