<?php
/***                                                                        ***\
    languages/Nederlands.php

    Translation hash for Dutch.
\***                                                                        ***/

// Set the locale to Dutch
setlocale(LC_ALL, 'nl_NL');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 min'                    => '',
    '$1 mins'                   => '',
    'Airtime'                   => '',
    'All recordings'            => '',
    'Auto-expire recordings'    => '',
    'Category'                  => '',
    'Check for duplicates in'   => '',
    'Current recordings'        => '',
    'Date'                      => '',
    'Description'               => '',
    'Duplicate Check method'    => '',
    'End Late'                  => '',
    'Go'                        => '',
    'No. of recordings to keep' => '',
    'None'                      => '',
    'Notes'                     => '',
    'Original Airdate'          => '',
    'Previous recordings'       => '',
    'Profile'                   => '',
    'Rating'                    => '',
    'Record new and expire old' => '',
    'Recorded Programs'         => '',
    'Recording Group'           => '',
    'Recording Options'         => '',
    'Recording Priority'        => '',
    'Recording Profile'         => '',
    'Rerun'                     => '',
    'Schedule'                  => '',
    'Scheduled Recordings'      => '',
    'Search'                    => '',
    'Start Early'               => '',
    'Subtitle'                  => '',
    'Subtitle and Description'  => '',
    'Title'                     => '',
    'Unknown'                   => '',
    'Update Recording Settings' => '',
    'rectype-long: always'      => '',
    'rectype-long: channel'     => '',
    'rectype-long: daily'       => '',
    'rectype-long: findone'     => '',
    'rectype-long: once'        => '',
    'rectype-long: weekly'      => '',
// includes/init.php
    'generic_date' => '%b %e, %Y',
    'generic_time' => '%H:%M',
// includes/programs.php
    'recstatus: cancelled'         => '',
    'recstatus: conflict'          => '',
    'recstatus: currentrecording'  => '',
    'recstatus: deleted'           => '',
    'recstatus: earliershowing'    => '',
    'recstatus: force_record'      => '',
    'recstatus: latershowing'      => '',
    'recstatus: lowdiskspace'      => '',
    'recstatus: manualoverride'    => '',
    'recstatus: overlap'           => '',
    'recstatus: previousrecording' => '',
    'recstatus: recorded'          => '',
    'recstatus: recording'         => '',
    'recstatus: stopped'           => '',
    'recstatus: toomanyrecordings' => '',
    'recstatus: tunerbusy'         => '',
    'recstatus: unknown'           => '',
    'recstatus: willrecord'        => '',
// includes/recordings.php
    'rectype: always'   => '',
    'rectype: channel'  => '',
    'rectype: daily'    => '',
    'rectype: dontrec'  => '',
    'rectype: findone'  => '',
    'rectype: once'     => '',
    'rectype: override' => '',
    'rectype: weekly'   => '',
// includes/utils.php
    '$1 B'   => '',
    '$1 GB'  => '',
    '$1 KB'  => '',
    '$1 MB'  => '',
    '$1 TB'  => '',
    '$1 hr'  => '',
    '$1 hrs' => '',
// themes/.../channel_detail.php
    'Episode' => '',
    'Jump to' => '',
    'Length'  => '',
    'Show'    => '',
    'Time'    => '',
// themes/.../program_detail.php
    '$1 to $2'                            => '',
    'Back to the program listing'         => '',
    'Back to the recording schedules'     => '',
    'Cancel this schedule'                => '',
    'Don\'t record this program'          => '',
    'Find other showings of this program' => '',
    'Google'                              => '',
    'IMDB'                                => '',
    'TVTome'                              => '',
    'What else is on at this time?'       => '',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => '',
    'Hour'                    => '',
    'Jump'                    => '',
    'Jump To'                 => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '',
    '$1 episodes'                                         => '',
    '$1 programs, using $2 ($3) out of $4.'               => '',
    '$1 recording'                                        => '',
    '$1 recordings'                                       => '',
    'Are you sure you want to delete the following show?' => '',
    'Delete'                                              => '',
    'No'                                                  => '',
    'Show group'                                          => '',
    'Show recordings'                                     => '',
    'Yes'                                                 => '',
    'auto-expire'                                         => '',
    'has bookmark'                                        => '',
    'has commflag'                                        => '',
    'has cutlist'                                         => '',
    'is editing'                                          => '',
    'preview'                                             => '',
// themes/.../recording_profiles.php
    'Profile Groups'     => '',
    'Recording profiles' => '',
// themes/.../recording_schedules.php
    'Any'                          => '',
    'Dup Method'                   => '',
    'Sub and Desc (Empty matches)' => '',
    'Type'                         => '',
// themes/.../schedule_manually.php
    'Channel'      => '',
    'Length (min)' => '',
    'Start Date'   => '',
    'Start Time'   => '',
// themes/.../scheduled_recordings.php
    'Activate'      => '',
    'Commands'      => '',
    'Conflicts'     => '',
    'Deactivated'   => '',
    'Default'       => '',
    'Display'       => '',
    'Don\'t Record' => '',
    'Duplicates'    => '',
    'Forget Old'    => '',
    'Never Record'  => '',
    'Record This'   => '',
    'Scheduled'     => '',
// themes/.../search.php
    'Category Type'    => '',
    'Exact Match'      => '',
    'No matches found' => '',
// themes/.../settings.php
    'Channels'           => '',
    'Configure'          => '',
    'Key Bindings'       => '',
    'MythWeb Settings'   => '',
    'settings: overview' => '',
// themes/.../settings_channels.php
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => '',
// themes/.../settings_keys.php
    'Edit keybindings on' => '',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'   => '',
    'Date Formats'                  => '',
    'Hour Format'                   => '',
    'Language'                      => '',
    'Listing &quot;Jump to&quot;'   => '',
    'Listing Time Key'              => '',
    'MythWeb Theme'                 => '',
    'Reset'                         => '',
    'Save'                          => '',
    'Scheduled Popup'               => '',
    'Search Results'                => '',
    'Show descriptions on new line' => '',
    'Status Bar'                    => '',
    'format help'                   => '',
// themes/.../theme.php
    'Backend Status'      => '',
    'Category Legend'     => '',
    'Favorites'           => '',
    'Go To'               => '',
    'Listings'            => '',
    'Manually Schedule'   => '',
    'Movies'              => '',
    'Recording Schedules' => '',
    'Settings'            => '',
    'advanced'            => '',
// themes/.../weather.php
    ' at '               => '',
    'Current Conditions' => '',
    'Forecast'           => '',
    'Friday'             => '',
    'High'               => '',
    'Humidity'           => '',
    'Last Updated'       => '',
    'Low'                => '',
    'Monday'             => '',
    'Pressure'           => '',
    'Radar'              => '',
    'Saturday'           => '',
    'Sunday'             => '',
    'Thursday'           => '',
    'Today'              => '',
    'Tomorrow'           => '',
    'Tuesday'            => '',
    'UV Extreme'         => '',
    'UV High'            => '',
    'UV Index'           => '',
    'UV Minimal'         => '',
    'UV Moderate'        => '',
    'Visibility'         => '',
    'Wednesday'          => '',
    'Wind'               => '',
    'Wind Chill'         => ''
// End of the translation hash ** Do not touch the next line
          );


/*
    Show Categories:
    $Categories is a hash of keys corresponding to the css style used for each
    show category.  Each entry is an array containing the name of that category
    in the language this file defines (it will not be translated separately),
    and a regular expression pattern used to match the category against those
    provided in the listings.
*/
$Categories = array();
$Categories['Action']         = array('Actie',              '\\b(?:action|avon|actie)');
$Categories['Adult']          = array('Erotisch',           '\\b(?:adult|erot|sex)');
$Categories['Animals']        = array('Dieren',             '\\b(?:animal|dier)');
$Categories['Art_Music']      = array('Kunst_Muziek',       '\\b(?:art|kunst|dans|musi[ck]|muziek|kunst|[ck]ultur)');
$Categories['Business']       = array('Zakelijk',           '\\b(?:biz|busine|zake)');
$Categories['Children']       = array('Kinderen',           '\\b(?:child|jeugd|animatie|kin?d|infan)');
$Categories['Comedy']         = array('Komisch',            '\\b(?:comed|entertain|sitcom|serie)');
$Categories['Crime_Mystery']  = array('Misdaad_Crimi',      '\\b(?:[ck]rim|myster|misdaad)');
$Categories['Documentary']    = array('Documentaire',       '\\b(?:informatief|docu)');
$Categories['Drama']          = array('Drama',              '\\b(?:drama)');
$Categories['Educational']    = array('Educatie',           '\\b(?:edu|interes)');
$Categories['Food']           = array('Eten',               '\\b(?:food|cook|[dt]rink|kook|eten|kok)');
$Categories['Game']           = array('Spel',               '\\b(?:game|spel|quiz)');
$Categories['Health_Medical'] = array('Gezondheid_Medisch', '\\b(?:medisch|gezond)');
$Categories['History']        = array('Geschiedenis',       '\\b(?:hist|geschied)');
$Categories['Horror']         = array('Horror',             '\\b(?:horror)');
$Categories['HowTo']          = array('Hulp',               '\\b(?:how|home|house|garden|huis|tuin|woning)');
$Categories['Misc']           = array('Divers',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nieuws',             '\\b(?:news|current|nieuws|duiding|actua)');
$Categories['Reality']        = array('Reality',            '\\b(?:reality|leven)');
$Categories['Romance']        = array('Romantiek',          '\\b(?:romance|lief)');
$Categories['SciFi_Fantasy']  = array('Wetenschap_Natuur',  '\\b(?:fantasy|sci\\w*\\W*fi|natuur|wetenschap)');
$Categories['Science_Nature'] = array('SciFi_Fantasy',      '\\b(?:science|natuur|environment|wetenschap)');
$Categories['Shopping']       = array('Shopping',           '\\b(?:shop|koop)');
$Categories['Soaps']          = array('Soaps',              '\\b(?:soap)');
$Categories['Spiritual']      = array('Religie',            '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',              '\\b(?:sport|deportes|voetbal|tennis)');
$Categories['Talk']           = array('Praat',              '\\b(?:talk|praat)');
$Categories['Travel']         = array('Reis',               '\\b(?:travel|reis)');
$Categories['War']            = array('Oorlog',             '\\b(?:war|oorlog)');
$Categories['Western']        = array('Films',              '\\b(?:west|film)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Onbekend');
$Categories['movie']          = array('Films'  );

?>
