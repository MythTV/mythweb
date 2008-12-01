<?php
/**
 * A straight passthrough for the mythbackend status web page (usually on
 * port 6544)
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Status
 *
/**/

// Get the address/port of the master machine
    $masterhost = setting('MasterServerIP');
    $statusport = setting('BackendStatusPort', '%');

// XML mode?
    $xml_param = ($Path[1] == 'xml') ? '/xml' : '';

// Make sure the content is interpreted as UTF-8
    header('Content-Type:  text/html; charset=UTF-8');

// Load the status page
    if (function_exists('curl_exec')) {
        $ch = curl_init("http://$masterhost:$statusport$xml_param");
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $status = curl_exec($ch);
        curl_close($ch);
    } else if (function_exists('file_get_contents'))
        $status = file_get_contents("http://$masterhost:$statusport$xml_param");
    else
        $status = implode("\n", file("http://$masterhost:$statusport$xml_param"));

// Extract the page title
    preg_match('#<title>(.+?)</title>#s', $status, $title);
    $title = $title[1];

// Clean up the page, and add some invisible content with the actual URL grabbed
    $status = "<!-- Obtained from:  http://$masterhost:$statusport -->\n"
             .preg_replace('#\s*</body>\s*</html>\s*$#s', '',
                  preg_replace('/^.+?<body>\s*\n/s', "\n",
                      $status
                  )
              );

// Print the status page template
    require_once tmpl_dir.'status.php';

// Yup, that really is it.
    exit;
