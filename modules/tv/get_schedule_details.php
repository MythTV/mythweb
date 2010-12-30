<?php
// Attempt to force some caching, will make secondary views so much faster.
    header('Cache-Control: max-age-'.($_REQUEST['starttime'] - time() + 604800));
    header('Pragma: ');
    header('Expires: '.date('D, d M Y H:i:s e', $_REQUEST['starttime'] + 604800));
    header('Content-Type: application/json');

    echo json_encode(array( 'id'               => 'schedule-'.$_REQUEST['recordid'],
                             'info'             => Schedule::find($_REQUEST['recordid'])->details_list()
                           ));
