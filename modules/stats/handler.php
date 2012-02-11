<?php
/**
 * Mythweb recording stats.
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Stats
 *
 * UPDATE oldrecorded, program
 *    SET oldrecorded.endtime=FROM_UNIXTIME(UNIX_TIMESTAMP(oldrecorded.starttime)
 *                                          +(UNIX_TIMESTAMP(program.endtime)
 *                                            -UNIX_TIMESTAMP(program.starttime)))
 *  WHERE oldrecorded.title=program.title
 *        AND oldrecorded.recstatus = -3
 *        AND oldrecorded.endtime <= oldrecorded.starttime
 *        AND program.endtime > program.starttime;
 *
/**/
    $where = ' WHERE 1';
    if ($_REQUEST['query_time'] == 'day')
        $where = ' WHERE UNIX_TIMESTAMP(starttime) > '.(time()-24*60*60);
    if ($_REQUEST['query_time'] == 'week')
        $where = ' WHERE UNIX_TIMESTAMP(starttime) > '.(time()-7*24*60*60);
    if ($_REQUEST['query_time'] == 'month')
        $where = ' WHERE UNIX_TIMESTAMP(starttime) > '.(time()-31*24*60*60);
    if ($_REQUEST['query_time'] == 'year')
        $where = ' WHERE UNIX_TIMESTAMP(starttime) > '.(time()-365*24*60*60);
    $where .= ' AND oldrecorded.recstatus = -3 AND oldrecorded.future = 0';

    $limit = 'LIMIT 10';
    if (is_numeric($_REQUEST['count_dropdown']))
        $limit = 'LIMIT '.$_REQUEST['count_dropdown'];
    if ($_REQUEST['count_dropdown'] == 'all')
        $limit = '';


// Get how many show titles there are
    $title_count = $db->query_num_rows('SELECT DISTINCT title
                                          FROM oldrecorded'.$where);

// Get how many shows ever recorded
    $show_count = $db->query_col('SELECT COUNT(title)
                                    FROM oldrecorded '.$where);

// Get the time of the first recording
    $first = $db->query_col('SELECT UNIX_TIMESTAMP(starttime)
                               FROM oldrecorded '.$where
                        .' ORDER BY starttime ASC LIMIT 1');

// Get the time of the last recording
    $last = $db->query_col('SELECT UNIX_TIMESTAMP(endtime)
                              FROM oldrecorded '.$where
                       .' ORDER BY endtime DESC LIMIT 1');

// Get the total time of the recorded shows
    $time = $db->query_col('SELECT SUM(UNIX_TIMESTAMP(endtime) - UNIX_TIMESTAMP(starttime))
                              FROM oldrecorded '
                         .$where.' AND endtime > starttime');

// Get the top ten recorded shows
    $sh = $db->query('SELECT title,
                             COUNT(programid)               AS recorded,
                             MAX(UNIX_TIMESTAMP(starttime)) AS last_recorded
                        FROM oldrecorded '.$where.'
                    GROUP BY title
                    ORDER BY recorded DESC, last_recorded, title
                    '.$limit);
    while($row = $sh->fetch_assoc())
        $shows[] = $row;
    $sh->finish();

// Get the top recorded channels
    $sh = $db->query('SELECT COUNT(oldrecorded.chanid) as recorded,
                             channel.name,
                             channel.channum,
                             MAX(UNIX_TIMESTAMP(oldrecorded.starttime)) AS last_recorded
                        FROM oldrecorded
                             LEFT JOIN channel
                                    ON channel.chanid = oldrecorded.chanid
                    '.$where.'
                             AND channel.channum IS NOT NULL
                    GROUP BY channel.callsign
                    ORDER BY recorded DESC, last_recorded, name '
                    .$limit);
    while($row = $sh->fetch_assoc())
        $channels[] = $row;
    $sh->finish();

// Print the stats page template
    require_once tmpl_dir.'stats.php';

// Yup, that really is it.
    exit;
