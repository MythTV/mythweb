<?php
/**
 * Jobqueue-related constants, routines, etc.
 *
 *
 * @package     MythWeb
/**/

// Job status
    define('JOB_UNKNOWN',      0x0000);
    define('JOB_QUEUED',       0x0001);
    define('JOB_PENDING',      0x0002);
    define('JOB_STARTING',     0x0003);
    define('JOB_RUNNING',      0x0004);
    define('JOB_STOPPING',     0x0005);
    define('JOB_PAUSED',       0x0006);
    define('JOB_RETRY',        0x0007);
    define('JOB_ERRORING',     0x0008);
    define('JOB_ABORTING',     0x0009);
    define('JOB_DONE',         0x0100); // mask to indicate the job is done, no matter what the status
    define('JOB_FINISHED',     0x0110);
    define('JOB_ABORTED',      0x0120);
    define('JOB_ERRORED',      0x0130);
    define('JOB_CANCELLED',    0x0140);

/**
 * @global  array   $GLOBALS['Job_Status']
 * @name    $Job_Status
/**/
    global $Job_Status;
    $Job_Status = array(JOB_UNKNOWN   => t('Unknown'),
                        JOB_QUEUED    => t('Queued'),
                        JOB_PENDING   => t('Pending'),
                        JOB_STARTING  => t('Starting'),
                        JOB_RUNNING   => t('Running'),
                        JOB_STOPPING  => t('Stopping'),
                        JOB_PAUSED    => t('Paused'),
                        JOB_RETRY     => t('Retry'),
                        JOB_ERRORING  => t('Erroring'),
                        JOB_ABORTING  => t('Aborting'),
                        JOB_DONE      => t('Done, Unknown Status'),
                        JOB_FINISHED  => t('Finished'),
                        JOB_ABORTED   => t('Aborted'),
                        JOB_ERRORED   => t('Errored'),
                        JOB_CANCELLED => t('Cancelled')
                       );

// Job commands
    define('JOB_RUN',           0x0000);
    define('JOB_PAUSE',         0x0001);
    define('JOB_RESUME',        0x0002);
    define('JOB_STOP',          0x0004);
    define('JOB_RESTART',       0x0008);

// Job flags
    define('JOB_NO_FLAGS',      0x0000);
    define('JOB_USE_CUTLIST',   0x0001);
    define('JOB_LIVE_REC',      0x0002);
    define('JOB_EXTERNAL',      0x0004);

// Job lists
    define('JOB_LIST_ALL',      0x0001);
    define('JOB_LIST_DONE',     0x0002);
    define('JOB_LIST_NOT_DONE', 0x0004);
    define('JOB_LIST_ERROR',    0x0008);
    define('JOB_LIST_RECENT',   0x0010);

// Job types
    define('JOB_NONE',          0x0000);
    define('JOB_SYSTEMJOB',     0x00ff);
    define('JOB_TRANSCODE',     0x0001);
    define('JOB_COMMFLAG',      0x0002);
    define('JOB_METADATA',      0x0004);
    define('JOB_USERJOB',       0xff00);
    define('JOB_USERJOB1',      0x0100);
    define('JOB_USERJOB2',      0x0200);
    define('JOB_USERJOB3',      0x0400);
    define('JOB_USERJOB4',      0x0800);

/**
 * @global  array   $GLOBALS['Jobs']
 * @name    $Jobs
/**/
    global $Jobs;
    $Jobs = array(JOB_TRANSCODE => t('Transcode'),
                  JOB_COMMFLAG  => t('Flag Commercials'),
                  JOB_METADATA  => t('Look up Metadata')
                 );

// Load up any defined user jobs
    $sh = $db->query('SELECT SUBSTRING(j.value, 8,1) AS jnum,
                             d.data               AS name
                        FROM settings AS j,
                             settings AS d
                       WHERE d.value = CONCAT("UserJobDesc", SUBSTRING(j.value, 8,1))
                             AND LENGTH(IFNULL(j.data, "")) > 0
                             AND j.value LIKE "UserJob_"
                    ORDER BY jnum');
    while ($row = $sh->fetch_assoc()) {
        $Jobs[constant('JOB_USERJOB'.$row['jnum'])] = $row['name'];
    }
    $sh->finish();

