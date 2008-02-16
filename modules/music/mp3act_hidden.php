<?php
// hidden iframe to process streaming
require_once('modules/music/mp3act_functions.php');

// Play the Music
if ('' != $_GET['id'])
    echo play($_GET['type'], $_GET['id'], $_GET['quality']);

