<?php
/**
 * Configure MythTV Channels
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Settings
 *
/**/

// Save?
    if ($_POST['save']) {
    // Parse the post variables and save each group of channel info
        foreach (array_keys($_POST) as $key) {
        // Figure out the chanid, or leave
            if (!preg_match('/^channum_(\\d+)$/', $key, $match)) continue;
            list($match, $chanid) = $match;
        // First, delete any unwanted channels
            $query_params = array();
            if ($_POST['delete_'.$chanid] == "true") {
                $query = 'DELETE FROM channel';
            }
            else {
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
                $query_params[] = $_POST['xmltvid_'.$chanid];
                $query_params[] = $_POST['freqid_'.$chanid];
                $query_params[] = $_POST['finetune_'.$chanid];
                $query_params[] = $_POST['videofilters_'.$chanid];
                $query_params[] = $_POST['brightness_'.$chanid];
                $query_params[] = $_POST['contrast_'.$chanid];
                $query_params[] = $_POST['colour_'.$chanid];
                $query_params[] = $_POST['hue_'.$chanid];
                $query_params[] = $_POST['recpriority_'.$chanid];
                $query_params[] = empty($_POST['commfree_'.$chanid])      ? -1 : -2;
                $query_params[] = empty($_POST['useonairguide_'.$chanid]) ? 0 : 1;
                $query_params[] = empty($_POST['visible_'.$chanid])       ? 0 : 1;
            // next, the fields that need to have a value, so we won't change them if they were emptied
                if ($_POST['channum_'.$chanid]) {
                    $query         .= ',channum=?';
                    $query_params[] = $_POST['channum_'.$chanid];
                }
                if ($_POST['callsign_'.$chanid]) {
                    $query         .= ',callsign=?';
                    $query_params[] = $_POST['callsign_'.$chanid];
                }
                if ($_POST['name_'.$chanid]) {
                    $query         .= ',name=?';
                    $query_params[] = $_POST['name_'.$chanid];
                }
            }
        // Submit the query
            $db->query($query.' WHERE chanid=?',
                       $query_params,
                       $chanid
                      );
        }
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
    $Channels = array();
    $sh = $db->query('SELECT * FROM channel ORDER BY '.$sortby);
    while ($row = $sh->fetch_assoc()) {
        $Channels[] = $row;
    }
    $sh->finish();

// These settings affect all of mythtv
    $Settings_Hosts = t('All Hosts');

