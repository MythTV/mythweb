<?php
/***                                                                        ***\
    settings_channels.php                    Last Updated: 2003.11.22 (xris)

    mythtv channels settings
\***                                                                        ***/

// Initialize the script, database, etc.
    require_once "includes/init.php";

// Save?
    if ($_POST['save']) {
    // Parse the post variables and save each group of channel info
        foreach (array_keys($_POST) as $key) {
        // Figure out the chanid, or leave
            if (!preg_match('/^channum_(\\d+)$/', $key, $match)) continue;
            list($match, $chanid) = $match;
        // First, grab values that can be empty
            $query = 'UPDATE channel SET freqid='.escape($_POST['freqid_'.$chanid])      .','
                                     .'finetune='.escape($_POST['finetune_'.$chanid])    .','
                                 .'videofilters='.escape($_POST['videofilters_'.$chanid]).','
                                   .'brightness='.escape($_POST['brightness_'.$chanid])  .','
                                     .'contrast='.escape($_POST['contrast_'.$chanid])    .','
                                       .'colour='.escape($_POST['colour_'.$chanid])      .','
                                          .'hue='.escape($_POST['hue_'.$chanid])         .','
                                  .'recpriority='.escape($_POST['recpriority_'.$chanid]) .','
                                  .'commfree='.escape((isset($_POST['commfree_'.$chanid]) && $_POST['commfree_'.$chanid] == "on") ? 1 : 0);
        // next, the fields that need to have a value, so we won't change them if they were emptied
            if ($_POST['channum_'.$chanid])
                $query .= ',channum='.escape($_POST['channum_'.$chanid]);
            if ($_POST['callsign_'.$chanid])
                $query .= ',callsign='.escape($_POST['callsign_'.$chanid]);
            if ($_POST['name_'.$chanid])
                $query .= ',name='.escape($_POST['name_'.$chanid]);
        // Submit the query
            $result = mysql_query($query.' WHERE chanid='.escape($chanid))
                or trigger_error('SQL Error: '.mysql_error(), FATAL);
        }
    }

// Load all of the channel data from the database
    $result = mysql_query('SELECT * FROM channel ORDER BY chanid')
        or trigger_error('SQL Error: '.mysql_error(), FATAL);
    $Channels = array();
    while ($row = mysql_fetch_assoc($result))
        $Channels[] = $row;
    mysql_free_result($result);

// Load the class for this page
    require_once theme_dir.'settings_channels.php';

// Create an instance of this page from its theme object
    $Page = new Theme_settings_channels();

// Display the page
    $Page->print_page();

// Exit
    exit;

?>
