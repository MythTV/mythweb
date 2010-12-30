<?php
/**
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

if (empty($_REQUEST['host'])) {
    header('HTTP/1.0 400 Bad Request');
    echo 'No host specified.';
    exit;
}

$frontend = $Frontends[$_REQUEST['host']];
if (empty($frontend)) {
    header('HTTP/1.0 400 Bad Request');
    echo 'Unknown host:  '.$_REQUEST['host'];
    exit;
}

# Build the request
$args = array(
    'format' => strtolower(_or($_REQUEST['format'], 'jpg')),
    'height' => $_REQUEST['height'],
    'width'  => $_REQUEST['width']
    );

# Print the image
header('Content-type: image/'.$args['format']);
echo $frontend->get_screenshot($args);
