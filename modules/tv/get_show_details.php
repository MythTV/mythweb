<?php
// Attempt to force some caching, will make secondary views so much faster.
    header('Cache-Control: max-age-'.($_REQUEST['starttime'] - time() + 604800));
    header('Pragma: ');
    header('Expires: '.date('D, d M Y H:i:s e', $_REQUEST['starttime'] + 604800));
    header('Content-Type: application/json');

    $program = new Program($db->query_assoc('SELECT program.*,
                                                    UNIX_TIMESTAMP(program.starttime)   AS `starttime_unix`,
                                                    UNIX_TIMESTAMP(program.endtime)     AS `endtime_unix`,
                                                    oldrecorded.recstatus               AS `recstatus`
                                               FROM program
                                          LEFT JOIN oldrecorded
                                                 ON (    oldrecorded.programid      = program.programid
                                                     AND oldrecorded.seriesid       = program.seriesid)
                                                 OR (    oldrecorded.title          = program.title
                                                     AND oldrecorded.subtitle       = program.subtitle
                                                     AND oldrecorded.description    = program.description)
                                              WHERE program.chanid    = ?
                                                AND program.starttime = FROM_UNIXTIME(?)',
                                            $_REQUEST['chanid'],
                                            $_REQUEST['starttime']
                                            ));
    echo JSON::encode(array( 'id'               => 'program-'.$_REQUEST['chanid'].'-'.$_REQUEST['starttime'],
                             'info'             => $program->details_list()
                           ));
