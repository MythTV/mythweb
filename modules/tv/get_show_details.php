<?php
// Attempt to force some caching, will make secondary views so much faster.
    header('Cache-Control: max-age-'.($_REQUEST['starttime'] - time() + 604800));
    header('Pragma: ');
    header('Expires: '.date('D, d M Y H:i:s e', $_REQUEST['starttime'] + 604800));
    header('Content-Type: application/json');

    $program = load_one_program($_REQUEST['starttime'], $_REQUEST['chanid'], false);

    echo JSON::encode(array( 'id'               => 'program-'.$_REQUEST['chanid'].'-'.$_REQUEST['starttime'],
                             'info'             => $program->details_list()
                           ));
