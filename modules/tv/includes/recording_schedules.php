<?php
/**
 * A couple of related subroutines.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Include our dependencies -- these are probably called elsewhere, but require_once will handle it
    require_once 'includes/mythbackend.php';
    require_once 'includes/channels.php';
    require_once 'includes/programs.php';
    require_once 'includes/css.php';

// Constants for the recording types
    define('rectype_once',        1);
    define('rectype_daily',       2);
    define('rectype_channel',     3);
    define('rectype_always',      4);
    define('rectype_weekly',      5);
    define('rectype_findone',     6);
    define('rectype_override',    7);
    define('rectype_dontrec',     8);
    define('rectype_finddaily',   9);
    define('rectype_findweekly', 10);

// Define the search types
    define('searchtype_power',    1);
    define('searchtype_title',    2);
    define('searchtype_keyword',  3);
    define('searchtype_people',   4);
    define('searchtype_manual',   5);

// Methods for determining duplicate recordings (against previous)
    define('dupsin_recorded',       0x01);
    define('dupsin_oldrecorded',    0x02);
    define('dupsin_all',            0x0F);

// More methods for duplicate recordings (restrictions against future showings)
    define('dupsin_newepisodes',    0x10);
    define('dupsin_ex_repeats',     0x20);
    define('dupsin_ex_generic',     0x40);

// Recording types -- enum at the top of libs/libmythtv/recordingtypes.h
    $RecTypes = array(
                      rectype_once       => t('rectype: once'),
                      rectype_daily      => t('rectype: daily'),
                      rectype_channel    => t('rectype: channel'),
                      rectype_always     => t('rectype: always'),
                      rectype_weekly     => t('rectype: weekly'),
                      rectype_findone    => t('rectype: findone'),
                      rectype_override   => t('rectype: override'),
                      rectype_dontrec    => t('rectype: dontrec'),
                      rectype_finddaily  => t('rectype: finddaily'),
                      rectype_findweekly => t('rectype: findweekly'),
                     );

// Global lists of recording schedules and scheduled recordings
    global $Schedules;
    $Schedules = array();

    $result = $db->query('SELECT record.*,
                                 IF(record.type='.rectype_always.',-1,record.chanid)            AS chanid,
                                 UNIX_TIMESTAMP(record.startdate)+TIME_TO_SEC(record.starttime) AS starttime,
                                 UNIX_TIMESTAMP(record.enddate)+TIME_TO_SEC(record.endtime)     AS endtime
                            FROM record');

    while ($row = $result->fetch_assoc())
        $Schedules[$row['recordid']] =& new Schedule($row);

// Initialize
    global $Scheduled_Recordings, $Num_Conflicts, $Num_Scheduled;
    $Scheduled_Recordings = array();
    $Num_Conflicts        = 0;
    $Num_Scheduled        = 0;

// Load all of the scheduled recordings.  We will need them at some point, so we
// might as well get it overwith here.
    foreach (MythBackend::find()->queryProgramRows('QUERY_GETALLPENDING', 2) as $key => $program) {
        if ($key === 'offset')
            list($Num_Conflicts, $Num_Scheduled) = $program;
    // Normal entry:  $Scheduled_Recordings[callsign][starttime][]
        else
            $Scheduled_Recordings[$program[6]][$program[11]][] =& new Program($program);
    }

// Transcoder names
    global $Transcoders;
    $Transcoders = array();
    $Transcoders[0] = 'Autodetect';
    $result = $db->query('SELECT recordingprofiles.id,
                                 recordingprofiles.name
                            FROM recordingprofiles
                            JOIN profilegroups
                              ON recordingprofiles.profilegroup  = profilegroups.id
                           WHERE cardtype                        = "TRANSCODE"
                             AND recordingprofiles.name         != "RTjpeg/MPEG4"
                             AND recordingprofiles.name         != "MPEG2"
                           ');
    while ($row = $result->fetch_assoc())
        $Transcoders[$row['id']] = $row['name'];
