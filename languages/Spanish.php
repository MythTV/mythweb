<?php
/***                                                                        ***\
    languages/Spanish.php

    Translation hash for Spanish.
\***                                                                        ***/

// Set the locale to Spanish UTF-8
setlocale(LC_ALL, 'es_ES.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 min'                                             => '',
    '$1 mins'                                            => '',
    '$1 programs, using $2 ($3) out of $4.'              => '',
    '$1 to $2'                                           => '',
    'Advanced Options'                                   => '',
    'Airtime'                                            => '',
    'All recordings'                                     => '',
    'Auto-expire recordings'                             => '',
    'Auto-flag commercials'                              => '',
    'Backend Status'                                     => '',
    'Cancel this schedule.'                              => '',
    'Category'                                           => '',
    'Channel'                                            => '',
    'Check for duplicates in'                            => '',
    'Create Schedule'                                    => '',
    'Current recordings'                                 => '',
    'Date'                                               => '',
    'Description'                                        => '',
    'Duplicate Check method'                             => '',
    'End Late'                                           => '',
    'Episode'                                            => '',
    'Go'                                                 => '',
    'Hour'                                               => '',
    'Jump'                                               => '',
    'Jump to'                                            => '',
    'Length (min)'                                       => '',
    'Listings'                                           => '',
    'No'                                                 => '',
    'No. of recordings to keep'                          => '',
    'None'                                               => '',
    'Notes'                                              => '',
    'Only New Episodes'                                  => '',
    'Original Airdate'                                   => '',
    'Previous recordings'                                => '',
    'Rating'                                             => '',
    'Record new and expire old'                          => '',
    'Recorded Programs'                                  => '',
    'Recording Group'                                    => '',
    'Recording Options'                                  => '',
    'Recording Priority'                                 => '',
    'Recording Profile'                                  => '',
    'Rerun'                                              => '',
    'Schedule'                                           => '',
    'Schedule Options'                                   => '',
    'Schedule Override'                                  => '',
    'Schedule normally.'                                 => '',
    'Scheduled Recordings'                               => '',
    'Search'                                             => '',
    'Search Results'                                     => '',
    'Start Date'                                         => '',
    'Start Early'                                        => '',
    'Start Time'                                         => '',
    'Subtitle'                                           => '',
    'Subtitle and Description'                           => '',
    'The requested recording schedule has been deleted.' => '',
    'Title'                                              => '',
    'Unknown'                                            => '',
    'Update Recording Settings'                          => '',
    'Yes'                                                => '',
    'airdate'                                            => '',
    'channum'                                            => '',
    'description'                                        => '',
    'generic_date'                                       => '%b %e, %Y',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => '',
    'minutes'                                            => 'minutos',
    'recgroup'                                           => '',
    'rectype-long: always'                               => '',
    'rectype-long: channel'                              => '',
    'rectype-long: daily'                                => '',
    'rectype-long: dontrec'                              => '',
    'rectype-long: finddaily'                            => '',
    'rectype-long: findone'                              => '',
    'rectype-long: findweekly'                           => '',
    'rectype-long: once'                                 => '',
    'rectype-long: override'                             => '',
    'rectype-long: weekly'                               => '',
    'rectype: always'                                    => '',
    'rectype: channel'                                   => '',
    'rectype: daily'                                     => '',
    'rectype: dontrec'                                   => '',
    'rectype: findone'                                   => '',
    'rectype: once'                                      => '',
    'rectype: override'                                  => '',
    'rectype: weekly'                                    => '',
    'subtitle'                                           => '',
    'title'                                              => '',
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
    'recstatus: repeat'            => '',
    'recstatus: stopped'           => '',
    'recstatus: toomanyrecordings' => '',
    'recstatus: tunerbusy'         => '',
    'recstatus: unknown'           => '',
    'recstatus: willrecord'        => '',
// includes/recording_schedules.php
    'Dup Method'                   => '',
    'Profile'                      => '',
    'Sub and Desc (Empty matches)' => '',
    'Type'                         => '',
    'rectype: finddaily'           => '',
    'rectype: findweekly'          => '',
// includes/utils.php
    '$1 B'   => '',
    '$1 GB'  => '',
    '$1 KB'  => '',
    '$1 MB'  => '',
    '$1 TB'  => '',
    '$1 hr'  => '',
    '$1 hrs' => '',
// program_detail.php
    'Unknown Program.'            => '',
    'Unknown Recording Schedule.' => '',
// search.php
    'Please search for something.' => '',
// themes/.../canned_searches.php
    'handy: overview' => '',
// themes/.../channel_detail.php
    'Length' => '',
    'Show'   => '',
    'Time'   => '',
// themes/.../program_detail.php
    '$1 Rating'                           => '',
    'Back to the program listing'         => '',
    'Back to the recording schedules'     => '',
    'Cast'                                => '',
    'Directed by'                         => '',
    'Don\'t record this program.'         => '',
    'Exec. Producer'                      => '',
    'Find other showings of this program' => '',
    'Find showings of this program'       => '',
    'Google'                              => '',
    'Guest Starring'                      => '',
    'Hosted by'                           => '',
    'IMDB'                                => '',
    'Inactive'                            => '',
    'Presented by'                        => '',
    'Produced by'                         => '',
    'TVTome'                              => '',
    'What else is on at this time?'       => '',
    'Written by'                          => '',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => '',
    'Jump To'                 => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '',
    '$1 episodes'                                         => '',
    '$1 recording'                                        => '',
    '$1 recordings'                                       => '',
    'Are you sure you want to delete the following show?' => '',
    'Delete'                                              => '',
    'Delete and Record Again'                             => '',
    'Show group'                                          => '',
    'Show recordings'                                     => '',
    'auto-expire'                                         => '',
    'file size'                                           => '',
    'has bookmark'                                        => '',
    'has commflag'                                        => '',
    'has cutlist'                                         => '',
    'is editing'                                          => '',
    'preview'                                             => '',
// themes/.../recording_profiles.php
    'Profile Groups'     => '',
    'Recording profiles' => '',
// themes/.../recording_schedules.php
    'Any'                                       => '',
    'No recording schedules have been defined.' => '',
    'channel'                                   => '',
    'profile'                                   => '',
    'type'                                      => '',
// themes/.../schedule_manually.php
    'Save Schedule' => '',
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
    'Update'        => '',
// themes/.../search.php
    'No matches found' => '',
    'Search for:  $1'  => '',
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
    'Channel &quot;Jump to&quot;'     => '',
    'Date Formats'                    => '',
    'Guide Settings'                  => '',
    'Hour Format'                     => '',
    'Language'                        => '',
    'Listing &quot;Jump to&quot;'     => '',
    'Listing Time Key'                => '',
    'MythWeb Theme'                   => '',
    'Only display favourite channels' => '',
    'Reset'                           => '',
    'SI Units?'                       => '',
    'Save'                            => '',
    'Scheduled Popup'                 => '',
    'Show descriptions on new line'   => '',
    'Status Bar'                      => '',
    'Weather Icons'                   => '',
    'format help'                     => '',
// themes/.../theme.php
    'Category Legend'                            => '',
    'Category Type'                              => '',
    'Edit MythWeb and some MythTV settings.'     => '',
    'Exact Match'                                => '',
    'HD Only'                                    => '',
    'Manually Schedule'                          => '',
    'MythMusic on the web.'                      => '',
    'MythVideo on the web.'                      => '',
    'MythWeb Weather.'                           => '',
    'Recording Schedules'                        => '',
    'Search fields'                              => '',
    'Search help'                                => '',
    'Search help: movie example'                 => '*** 1/2 Adventure',
    'Search help: movie search'                  => 'movie search',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'regex search',
    'Search options'                             => '',
    'Searches'                                   => '',
    'Settings'                                   => '',
    'TV functions, including recorded programs.' => '',
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
$Categories['Action']         = array('Acci&oacute;n',            '\\b(?:action|adven)');
$Categories['Adult']          = array('Adultos',                  '\\b(?:adult|erot)');
$Categories['Animals']        = array('Animales',                 '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Arte / M&uacute;sica',     '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)');
$Categories['Business']       = array('Profesional',              '\\b(?:biz|busine)');
$Categories['Children']       = array('Infantil',                 '\\b(?:child|kin?d|infan|animation)');
$Categories['Comedy']         = array('Comedia',                  '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Misterio / Cr&iacute;men', '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Documental',               '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',                    '\\b(?:drama)');
$Categories['Educational']    = array('Educativo',                '\\b(?:edu|interests)');
$Categories['Food']           = array('Alimentaci&oacute;n',      '\\b(?:food|cook|comida)');
$Categories['Game']           = array('Juegos',                   '\\b(?:game|spiele)');
$Categories['Health_Medical'] = array('Salud / Medicina',         '\\b(?:health|medic)');
$Categories['History']        = array('Historia',                 '\\b(?:hist)');
$Categories['Horror']         = array('Terror',                   '\\b(?:horror)');
$Categories['HowTo']          = array('C&oacute;mo...',           '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Varios',                   '\\b(?:special|variedad|info|collect)');
$Categories['News']           = array('Noticias',                 '\\b(?:news|noticias)');
$Categories['Reality']        = array('Reality Shows',            '\\b(?:reality)');
$Categories['Romance']        = array('Romance',                  '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Ciencias Naturales',       '\\b(?:sciencia|natur)');
$Categories['Science_Nature'] = array('Ciencia Ficci&oacute;n',   '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Shopping']       = array('Compras',                  '\\b(?:shop)');
$Categories['Soaps']          = array('Soaps?',                   '\\b(?:soaps)');
$Categories['Spiritual']      = array('Espiritual',               '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Deportes',                 '\\b(?:sport|deportes|futbol)');
$Categories['Talk']           = array('Debates',                  '\\b(?:talk)');
$Categories['Travel']         = array('Viajar',                   '\\b(?:travel|reisen)');
$Categories['War']            = array('Guerras',                  '\\b(?:war|guerra)');
$Categories['Western']        = array('Western',                  '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Desconocido');
$Categories['movie']          = array('Pel&iacute;culas'  );

?>
