<?php
// Attempt to force some caching, will make secondary views so much faster.
    header('Cache-Control: max-age-'.($_REQUEST['starttime'] - time() + 604800));
    header('Pragma: ');
    header('Expires: '.date('D, d M Y H:i:s e', $_REQUEST['starttime'] + 604800));

    $program = new Program($db->query_assoc('SELECT program.*
                                               FROM program
                                              WHERE program.chanid    = ?
                                                AND program.starttime = FROM_UNIXTIME(?)',
                                            $_REQUEST['chanid'],
                                            $_REQUEST['starttime']
                                            ));
    echo 'program-'.$_REQUEST['chanid'].'-'.$_REQUEST['starttime']."\n";
    echo $program->details_list();
