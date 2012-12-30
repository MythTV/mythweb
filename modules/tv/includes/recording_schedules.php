<?php
/**
 * A couple of related subroutines.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Include our dependencies -- these are probably called elsewhere, but require_once will handle it
    require_once 'includes/programs.php';
    require_once 'includes/css.php';

// Constants for the recording types
    define('rectype_once',        1);
    define('rectype_daily',       2);
    define('rectype_always',      4);
    define('rectype_weekly',      5);
    define('rectype_findone',     6);
    define('rectype_override',    7);
    define('rectype_dontrec',     8);
    define('rectype_template',   11);

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

// Recording types -- enum at the top of libs/libmythtv/recordingtypes.h
    $RecTypes = array(
                      rectype_once       => t('rectype: once'),
                      rectype_daily      => t('rectype: daily'),
                      rectype_always     => t('rectype: always'),
                      rectype_weekly     => t('rectype: weekly'),
                      rectype_findone    => t('rectype: findone'),
                      rectype_override   => t('rectype: override'),
                      rectype_dontrec    => t('rectype: dontrec'),
                     );

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
