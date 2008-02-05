<?php
    $program = new Program($db->query_assoc('SELECT program.*
                                               FROM program
                                              WHERE program.chanid    = ?
                                                AND program.starttime = FROM_UNIXTIME(?)',
                                            $_REQUEST['chanid'],
                                            $_REQUEST['starttime']
                                            ));
    echo 'program-'.$_REQUEST['chanid'].'-'.$_REQUEST['starttime']."\n";
    echo $program->details_list();

