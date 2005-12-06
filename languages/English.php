<?php
/***                                                                        ***\
    languages/English.php

    Translation hash for English.  This also doubles as the template for
    other translations, since it's mostly just blank (default) entries.
\***                                                                        ***/

// Set the locale to English UTF-8
setlocale(LC_ALL, 'en_US.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    ' at '                                                => '',
    '$1 Rating'                                           => '',
    '$1 episode'                                          => '',
    '$1 episodes'                                         => '',
    '$1 hr'                                               => '',
    '$1 hrs'                                              => '',
    '$1 min'                                              => '',
    '$1 mins'                                             => '',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'     => '',
    '$1 recording'                                        => '',
    '$1 recordings'                                       => '',
    '$1 to $2'                                            => '',
    'Activate'                                            => '',
    'Advanced Options'                                    => '',
    'Airtime'                                             => '',
    'All recordings'                                      => '',
    'Are you sure you want to delete the following show?' => '',
    'Auto-expire recordings'                              => '',
    'Auto-flag commercials'                               => '',
    'Auto-transcode'                                      => '',
    'Back to the program listing'                         => '',
    'Back to the recording schedules'                     => '',
    'Backend Status'                                      => '',
    'Cancel this schedule.'                               => '',
    'Cast'                                                => '',
    'Category'                                            => '',
    'Category Legend'                                     => '',
    'Category Type'                                       => '',
    'Check for duplicates in'                             => '',
    'Commands'                                            => '',
    'Conflicts'                                           => '',
    'Current Conditions'                                  => '',
    'Current recordings'                                  => '',
    'Currently Browsing:  $1'                             => '',
    'Date'                                                => '',
    'Deactivated'                                         => '',
    'Default'                                             => '',
    'Delete'                                              => '',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => '',
    'Delete and rerecord $1'                              => '',
    'Description'                                         => '',
    'Details for'                                         => '',
    'Directed by'                                         => '',
    'Display'                                             => '',
    'Don\'t Record'                                       => '',
    'Don\'t record this program.'                         => '',
    'Duplicate Check method'                              => '',
    'Duplicates'                                          => '',
    'Edit MythWeb and some MythTV settings.'              => '',
    'End Late'                                            => '',
    'Episode'                                             => '',
    'Exact Match'                                         => '',
    'Exec. Producer'                                      => '',
    'Find other showings of this program'                 => '',
    'Find showings of this program'                       => '',
    'Forecast'                                            => '',
    'Forget Old'                                          => '',
    'Friday'                                              => '',
    'Go'                                                  => '',
    'Google'                                              => '',
    'Guest Starring'                                      => '',
    'Guide rating'                                        => '',
    'HD Only'                                             => '',
    'High'                                                => '',
    'Hosted by'                                           => '',
    'Hour'                                                => '',
    'Humidity'                                            => '',
    'IMDB'                                                => '',
    'Inactive'                                            => '',
    'Jump'                                                => '',
    'Jump To'                                             => '',
    'Jump to'                                             => '',
    'Last Updated'                                        => '',
    'Listings'                                            => '',
    'Low'                                                 => '',
    'Manually Schedule'                                   => '',
    'Monday'                                              => '',
    'Music'                                               => '',
    'MythMusic on the web.'                               => '',
    'MythVideo on the web.'                               => '',
    'MythWeb Weather.'                                    => '',
    'Never Record'                                        => '',
    'No'                                                  => '',
    'No. of recordings to keep'                           => '',
    'None'                                                => '',
    'Notes'                                               => '',
    'Only New Episodes'                                   => '',
    'Original Airdate'                                    => '',
    'Please search for something.'                        => '',
    'Presented by'                                        => '',
    'Pressure'                                            => '',
    'Previous recordings'                                 => '',
    'Produced by'                                         => '',
    'Program Detail'                                      => '',
    'Program Listing'                                     => '',
    'Radar'                                               => '',
    'Rating'                                              => '',
    'Record This'                                         => '',
    'Record new and expire old'                           => '',
    'Recorded Programs'                                   => '',
    'Recording Group'                                     => '',
    'Recording Options'                                   => '',
    'Recording Priority'                                  => '',
    'Recording Profile'                                   => '',
    'Recording Schedules'                                 => '',
    'Rerun'                                               => '',
    'Saturday'                                            => '',
    'Save'                                                => '',
    'Schedule'                                            => '',
    'Schedule Options'                                    => '',
    'Schedule Override'                                   => '',
    'Schedule normally.'                                  => '',
    'Scheduled'                                           => '',
    'Scheduled Recordings'                                => '',
    'Search'                                              => '',
    'Search Results'                                      => '',
    'Search fields'                                       => '',
    'Search help'                                         => '',
    'Search help: movie example'                          => '*** 1/2 Adventure',
    'Search help: movie search'                           => 'movie search',
    'Search help: regex example'                          => '/^Good Eats/',
    'Search help: regex search'                           => 'regex search',
    'Search options'                                      => '',
    'Searches'                                            => '',
    'Settings'                                            => '',
    'Show group'                                          => '',
    'Show recordings'                                     => '',
    'Start Early'                                         => '',
    'Subtitle'                                            => '',
    'Subtitle and Description'                            => '',
    'Sunday'                                              => '',
    'TV functions, including recorded programs.'          => '',
    'TV.com'                                              => '',
    'The requested recording schedule has been deleted.'  => '',
    'Thursday'                                            => '',
    'Time Stretch Default'                                => '',
    'Title'                                               => '',
    'Today'                                               => '',
    'Tomorrow'                                            => '',
    'Transcoder'                                          => '',
    'Tuesday'                                             => '',
    'UV Extreme'                                          => '',
    'UV High'                                             => '',
    'UV Index'                                            => '',
    'UV Minimal'                                          => '',
    'UV Moderate'                                         => '',
    'Unknown'                                             => '',
    'Unknown Program.'                                    => '',
    'Unknown Recording Schedule.'                         => '',
    'Upcoming Recordings'                                 => '',
    'Update'                                              => '',
    'Update Recording Settings'                           => '',
    'Visibility'                                          => '',
    'Weather'                                             => '',
    'Wednesday'                                           => '',
    'What else is on at this time?'                       => '',
    'Wind'                                                => '',
    'Wind Chill'                                          => '',
    'Written by'                                          => '',
    'Yes'                                                 => '',
    'airdate'                                             => '',
    'auto-expire'                                         => '',
    'channum'                                             => '',
    'description'                                         => '',
    'file size'                                           => '',
    'generic_date'                                        => '%a %b %e, %Y',
    'generic_time'                                        => '%I:%M %p',
    'has bookmark'                                        => '',
    'has commflag'                                        => '',
    'has cutlist'                                         => '',
    'is editing'                                          => '',
    'length'                                              => '',
    'minutes'                                             => '',
    'preview'                                             => '',
    'recgroup'                                            => '',
    'recpriority'                                         => '',
    'rectype-long: always'                                => 'Record at any time on any channel.',
    'rectype-long: channel'                               => 'Record at any time on channel $1.',
    'rectype-long: daily'                                 => 'Record this program in this timeslot every day.',
    'rectype-long: dontrec'                               => 'Do not record this specific showing.',
    'rectype-long: finddaily'                             => 'Find and record one showing of this title each day.',
    'rectype-long: findone'                               => 'Find and record one showing of this title.',
    'rectype-long: findweekly'                            => 'Find and record one showing of this title each week.',
    'rectype-long: once'                                  => 'Record only this showing.',
    'rectype-long: override'                              => 'Record this specific showing.',
    'rectype-long: weekly'                                => 'Record this program in this timeslot every week.',
    'rectype: always'                                     => 'Always',
    'rectype: channel'                                    => 'Channel',
    'rectype: daily'                                      => 'Daily',
    'rectype: dontrec'                                    => 'Don\'t Record',
    'rectype: findone'                                    => 'Find Once',
    'rectype: once'                                       => 'Once',
    'rectype: override'                                   => 'Override (record)',
    'rectype: weekly'                                     => 'Weekly',
    'subtitle'                                            => '',
    'title'                                               => '',
// includes/programs.php
    'recstatus: cancelled'         => 'This was scheduled to be recorded but was manually canceled.',
    'recstatus: conflict'          => 'Another program with a higher recording priority will be recorded.',
    'recstatus: currentrecording'  => 'This episode was previously recorded and is still available in the list of recordings.',
    'recstatus: deleted'           => 'This showing was recorded but was deleted before recording was completed.',
    'recstatus: earliershowing'    => 'This episode will be recorded at an earlier time instead.',
    'recstatus: force_record'      => 'This show was manually set to record this specific instance.',
    'recstatus: inactive'          => 'This recording schedule is inactive.',
    'recstatus: latershowing'      => 'This episode will be recorded at a later time instead.',
    'recstatus: lowdiskspace'      => 'There wasn\'t enough disk space available to record this program.',
    'recstatus: manualoverride'    => 'This showing was manually set to not record',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => 'This episode was previously recorded according to the duplicate policy chosen for this title.',
    'recstatus: recorded'          => 'This showing was recorded.',
    'recstatus: recording'         => 'This showing is being recorded.',
    'recstatus: repeat'            => 'This showing is a repeat and will not be recorded.',
    'recstatus: stopped'           => 'This showing was recorded but was stopped before recording was completed.',
    'recstatus: toomanyrecordings' => 'Too many recordings of this program have already been recorded.',
    'recstatus: tunerbusy'         => 'The tuner card was already being used when this program was scheduled to be recorded.',
    'recstatus: unknown'           => 'The status of this showing is unknown.',
    'recstatus: willrecord'        => 'This showing will be recorded.',
// includes/recording_schedules.php
    'Dup Method'                   => '',
    'Profile'                      => '',
    'Sub and Desc (Empty matches)' => '',
    'Type'                         => '',
    'rectype: finddaily'           => 'Find One Daily',
    'rectype: findweekly'          => 'Find One Weekly',
// includes/utils.php
    '$1 B'  => '',
    '$1 GB' => '',
    '$1 KB' => '',
    '$1 MB' => '',
    '$1 TB' => '',
// modules/backend_log/init.php
    'Logs' => '',
// modules/movietimes/init.php
    'Movie Times' => '',
// modules/settings/init.php
    'settings' => '',
// modules/status/init.php
    'Status' => '',
// modules/tv/init.php
    'Search TV'        => '',
    'Special Searches' => '',
    'TV'               => '',
// modules/video/init.php
    'Video' => '',
// themes/.../canned_searches.php
    'handy: overview' => 'This page contains pre-prepared complex searches of the program listings.',
// themes/.../channel_detail.php
    'Length' => '',
    'Show'   => '',
    'Time'   => '',
// themes/.../music.php
    'Album'               => '',
    'Album (filtered)'    => '',
    'All Music'           => '',
    'Artist'              => '',
    'Artist (filtered)'   => '',
    'Displaying'          => '',
    'Duration'            => '',
    'End'                 => '',
    'Filtered'            => '',
    'Genre'               => '',
    'Genre (filtered)'    => '',
    'Next'                => '',
    'No Tracks Available' => '',
    'Previous'            => '',
    'Top'                 => '',
    'Track Name'          => '',
    'Unfiltered'          => '',
// themes/.../recording_profiles.php
    'Profile Groups'     => '',
    'Recording profiles' => '',
// themes/.../recording_schedules.php
    'Any'                                       => '',
    'No recording schedules have been defined.' => '',
    'channel'                                   => '',
    'profile'                                   => '',
    'transcoder'                                => '',
    'type'                                      => '',
// themes/.../schedule_manually.php
    'Channel'           => '',
    'Create Schedule'   => '',
    'Length (min)'      => '',
    'Save Schedule'     => '',
    'Schedule Manually' => '',
    'Start Date'        => '',
    'Start Time'        => '',
// themes/.../search.php
    'No matches found' => '',
    'Search for:  $1'  => '',
// themes/.../settings.php
    'Channels'           => '',
    'Configure'          => '',
    'Key Bindings'       => '',
    'MythWeb Settings'   => '',
    'settings: overview' => 'This is the index page for the configuration settings...<p>It\'s incomplete, and will eventually get some nicer formatting.  For now, you can choose from the following:',
// themes/.../settings_channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => '',
    'brightness'                                                                                                                         => '',
    'callsign'                                                                                                                           => '',
    'colour'                                                                                                                             => '',
    'commfree'                                                                                                                           => '',
    'contrast'                                                                                                                           => '',
    'delete'                                                                                                                             => '',
    'finetune'                                                                                                                           => '',
    'freqid'                                                                                                                             => '',
    'hue'                                                                                                                                => '',
    'name'                                                                                                                               => '',
    'sourceid'                                                                                                                           => '',
    'useonairguide'                                                                                                                      => '',
    'videofilters'                                                                                                                       => '',
    'visible'                                                                                                                            => '',
// themes/.../settings_keys.php
    'Action'                => '',
    'Configure Keybindings' => '',
    'Context'               => '',
    'Destination'           => '',
    'Edit keybindings on'   => '',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
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
    'Scheduled Popup'                 => '',
    'Show descriptions on new line'   => '',
    'Status Bar'                      => '',
    'Weather Icons'                   => '',
    'format help'                     => '',
// themes/.../video.php
    'Edit'          => '',
    'Reverse Order' => '',
    'Videos'        => '',
    'category'      => '',
    'cover'         => '',
    'director'      => '',
    'imdb rating'   => '',
    'plot'          => '',
    'rating'        => '',
    'year'          => '',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => '',
// themes/default/backend_log/welcome.php
    'Show the server logs.' => '',
// themes/default/movietimes/welcome.php
    'Get listings for movies playing at local theatres.' => '',
// themes/default/music/welcome.php
    'Browse your music collection.' => '',
// themes/default/settings/welcome.php
    'Configure MythWeb.' => '',
// themes/default/status/welcome.php
    'Show the backend status page.' => '',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/welcome.php
    'See what\'s on tv, schedule recordings and manage shows that you\'ve already recorded.  Please see the following choices:' => '',
// themes/default/video/welcome.php
    'Browse your video collection.' => '',
// themes/default/weather/welcome.php
    'Get the local weather forecast.' => ''
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
$Categories['Action']         = array('Action',           '\\b(?:action|adven)');
$Categories['Adult']          = array('Adult',            '\\b(?:adult|erot)');
$Categories['Animals']        = array('Animals',          '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Art_Music',        '\\b(?:art|dance|music|cultur)');
$Categories['Business']       = array('Business',         '\\b(?:biz|busine)');
$Categories['Children']       = array('Children',         '\\b(?:child|infan|animation)');
$Categories['Comedy']         = array('Comedy',           '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Crime / Mystery',  '\\b(?:crim|myster)');
$Categories['Documentary']    = array('Documentary',      '\\b(?:doc)');
$Categories['Drama']          = array('Drama',            '\\b(?:drama)');
$Categories['Educational']    = array('Educational',      '\\b(?:edu|interests)');
$Categories['Food']           = array('Food',             '\\b(?:food|cook|drink)');
$Categories['Game']           = array('Game',             '\\b(?:game)');
$Categories['Health_Medical'] = array('Health / Medical', '\\b(?:health|medic)');
$Categories['History']        = array('History',          '\\b(?:hist)');
$Categories['Horror']         = array('Horror',           '\\b(?:horror)');
$Categories['HowTo']          = array('HowTo',            '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Misc',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('News',             '\\b(?:news|current)');
$Categories['Reality']        = array('Reality',          '\\b(?:reality)');
$Categories['Romance']        = array('Romance',          '\\b(?:romance)');
$Categories['SciFi_Fantasy']  = array('SciFi / Fantasy',  '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Science_Nature'] = array('Science / Nature', '\\b(?:science|nature|environment)');
$Categories['Shopping']       = array('Shopping',         '\\b(?:shop)');
$Categories['Soaps']          = array('Soaps',            '\\b(?:soaps)');
$Categories['Spiritual']      = array('Spiritual',        '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sports',           '\\b(?:sport)');
$Categories['Talk']           = array('Talk',             '\\b(?:talk)');
$Categories['Travel']         = array('Travel',           '\\b(?:travel)');
$Categories['War']            = array('War',              '\\b(?:war)');
$Categories['Western']        = array('Western',          '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Unknown');
$Categories['movie']          = array('Movie'  );

