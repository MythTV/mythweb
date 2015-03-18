<?php
// Attempt to force some caching, will make secondary views so much faster.
    header('Cache-Control: max-age=7200, public');
    header('Pragma: ');
    header('Expires: '.date('D, d M Y H:i:s e', time() + 7200));
    header('Content-Type: application/json');

    $program = load_one_program($_REQUEST['starttime'], $_REQUEST['chanid'], false);

    echo json_encode(array( 'id'               => 'program-'.$_REQUEST['chanid'].'-'.$_REQUEST['starttime'],
                             'info'             => $program->details_list()
                           ));
