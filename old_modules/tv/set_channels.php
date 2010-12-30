<?php
/**
 * Configure MythTV Channels
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
    // Parse the post variables and save each group of channel info
        foreach ($_POST['channel'] as $chanid => $data) {

            if ($data['delete'] == 'true')
                $db->query('DELETE FROM channel WHERE chanid=?', $chanid);
            else {
                $query_params = array();
            // Not deleting so grab values that can be empty
                $query = 'UPDATE channel SET xmltvid       = ?,
                                             freqid        = ?,
                                             finetune      = ?,
                                             videofilters  = ?,
                                             brightness    = ?,
                                             contrast      = ?,
                                             colour        = ?,
                                             hue           = ?,
                                             recpriority   = ?,
                                             commmethod    = ?,
                                             useonairguide = ?,
                                             visible       = ?';
                $query_params[] = $data['xmltvid'];
                $query_params[] = $data['freqid'];
                $query_params[] = $data['finetune'];
                $query_params[] = $data['videofilters'];
                $query_params[] = $data['brightness'];
                $query_params[] = $data['contrast'];
                $query_params[] = $data['colour'];
                $query_params[] = $data['hue'];
                $query_params[] = $data['recpriority'];
                $query_params[] = empty($data['commfree'])      ? -1 : -2;
                $query_params[] = empty($data['useonairguide']) ? 0 : 1;
                $query_params[] = empty($data['visible'])       ? 0 : 1;
            // next, the fields that need to have a value, so we won't change them if they were emptied
                if ($data['channum']) {
                    $query         .= ',channum=?';
                    $query_params[] = $data['channum'];
                }
                if ($data['callsign']) {
                    $query         .= ',callsign=?';
                    $query_params[] = $data['callsign'];
                }
                if ($data['name']) {
                    $query         .= ',name=?';
                    $query_params[] = $data['name'];
                }
                $db->query($query.' WHERE chanid=?',
                           $query_params,
                           $chanid
                           );
            }
        }
    // Do a reschedule to refresh scheduled recordings;
        MythBackend::find()->rescheduleRecording();
    }

// Sortby
    if ($_GET['sortby'])
        $_SESSION['tv']['set']['chan_sort'] = $_GET['sortby'];
    switch ($_SESSION['tv']['set']['chan_sort']) {
        case 'callsign':
        case 'name':
            $sortby = $_SESSION['tv']['set']['chan_sort'];
            break;
        case 'channum':
        case 'xmltvid':
        case 'freqid':
            $sortby = $_SESSION['tv']['set']['chan_sort'].' + 0, '.$_SESSION['tv']['set']['chan_sort'];
            break;
        case 'sourceid':
            $sortby = $_SESSION['tv']['set']['chan_sort'].', channum';
            break;
        default:
            $sortby = 'channum + 0, channum';
    }

// Load all of the channel data from the database
    $channels = array();
    $sh = $db->query('SELECT chanid FROM channel ORDER BY '.$sortby);
    while ($row = $sh->fetch_col())
        $channels[] = $row;
    $sh->finish();

// These settings affect all of mythtv
    $Settings_Hosts = t('All Hosts');
