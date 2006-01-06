<?php
/***                                                                        ***\
    languages/Australian.php

    Translation hash for Australian.  This also doubles as the template for
    other translations, since it's mostly just blank (default) entries.
\***                                                                        ***/

// Set the locale to Australian English UTF-8
setlocale(LC_ALL, 'en_AU.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 hr'                                              => '$1 beer',
    '$1 hrs'                                             => '$1 beers',
    '$1 min'                                             => '$1 beer',
    '$1 mins'                                            => '$1 beers',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 beers, using $1 ($3) out of $4 ($5 free).',
    '$1 to $2'                                           => '',
    'Activate'                                           => 'Not Bad Beer',
    'Advanced Options'                                   => '',
    'Airtime'                                            => 'Beertime',
    'All recordings'                                     => 'All Beers',
    'Auto-expire recordings'                             => 'Auto-beer beers',
    'Auto-flag commercials'                              => '',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => '',
    'Cancel this schedule.'                              => 'Cancel this drinking',
    'Category'                                           => 'Beer',
    'Check for duplicates in'                            => 'Check for old beers in',
    'Create Schedule'                                    => '',
    'Current recordings'                                 => 'Cold beers',
    'Custom Schedule'                                    => '',
    'Date'                                               => '',
    'Default'                                            => '',
    'Description'                                        => 'Beer type',
    'Details for'                                        => '',
    'Display'                                            => 'Show Beer',
    'Don\'t Record'                                      => 'Don\'t Drink',
    'Duplicate Check method'                             => 'Old beer location method',
    'End Late'                                           => 'Drink another beer',
    'Episode'                                            => '',
    'Forget Old'                                         => 'Forget Warm',
    'Hour'                                               => '',
    'IMDB'                                               => '',
    'Inactive'                                           => '',
    'Jump'                                               => '',
    'Jump to'                                            => '',
    'Listings'                                           => '',
    'Music'                                              => '',
    'Never Record'                                       => 'Never Drink',
    'No'                                                 => '',
    'No. of recordings to keep'                          => 'No. of beers to keep',
    'None'                                               => 'No Beer?',
    'Only New Episodes'                                  => 'Only Cold Beers',
    'Original Airdate'                                   => 'Original Beer Date',
    'Previous recordings'                                => 'Previous Beers',
    'Program Listing'                                    => '',
    'Rating'                                             => 'Brew Rating',
    'Record This'                                        => 'Drink This',
    'Record new and expire old'                          => 'Get coldies, discard warmies',
    'Recorded Programs'                                  => 'Empty Beers',
    'Recording Group'                                    => 'Beer Group',
    'Recording Options'                                  => 'Beer Options',
    'Recording Priority'                                 => 'Beerority',
    'Recording Profile'                                  => 'Beer Beerofile',
    'Recording Schedules'                                => '',
    'Repeat'                                             => 'Beererun',
    'Save'                                               => '',
    'Save Schedule'                                      => '',
    'Schedule'                                           => 'Beerdule',
    'Schedule Manually'                                  => '',
    'Schedule Options'                                   => '',
    'Schedule Override'                                  => '',
    'Schedule normally.'                                 => '',
    'Search'                                             => 'Find a beer',
    'Search Results'                                     => 'Located Beers',
    'Settings'                                           => '',
    'Start Early'                                        => 'AM Beer',
    'Subtitle'                                           => 'Beertitle',
    'Subtitle and Description'                           => 'Beertitle and beer info',
    'The requested recording schedule has been deleted.' => '',
    'Title'                                              => '',
    'Transcoder'                                         => '',
    'Type'                                               => '',
    'Unknown'                                            => 'imported beer',
    'Upcoming Recordings'                                => '',
    'Update'                                             => '',
    'Update Recording Settings'                          => 'Update beer settings',
    'Weather'                                            => '',
    'Yes'                                                => '',
    'airdate'                                            => '',
    'channum'                                            => '',
    'description'                                        => '',
    'generic_date'                                       => '%a %b %e, %Y',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => '',
    'minutes'                                            => '',
    'recgroup'                                           => '',
    'recpriority'                                        => '',
    'rectype-long: always'                               => 'Always drink this beer on any sixpack.',
    'rectype-long: channel'                              => 'Always drink this beer on this sixpack.',
    'rectype-long: daily'                                => 'Drink this beer in this happy hour every day.',
    'rectype-long: dontrec'                              => '',
    'rectype-long: finddaily'                            => 'Find this beer daily',
    'rectype-long: findone'                              => 'Find this beer once.',
    'rectype-long: findweekly'                           => 'Find this beer weekly',
    'rectype-long: once'                                 => 'Drink only this beer.',
    'rectype-long: override'                             => '',
    'rectype-long: weekly'                               => 'Drink this beer weekly.',
    'rectype: always'                                    => 'Always',
    'rectype: channel'                                   => 'Sixpack',
    'rectype: daily'                                     => 'Happy Hour',
    'rectype: dontrec'                                   => 'Don\'t Drink',
    'rectype: findone'                                   => 'FindOne',
    'rectype: once'                                      => 'Once',
    'rectype: override'                                  => 'Override (record)',
    'rectype: weekly'                                    => 'Weekly',
    'subtitle'                                           => '',
    'title'                                              => '',
// includes/programs.php
    'CC'                           => '',
    'HDTV'                         => '',
    'Notes'                        => 'Beers Details',
    'Part $1 of $2'                => '',
    'Stereo'                       => '',
    'Subtitled'                    => '',
    'recstatus: cancelled'         => 'This beer was scheduled to be drunk but was too warm.',
    'recstatus: conflict'          => 'Another beer with a colder temperature will be drank.',
    'recstatus: currentrecording'  => 'This beer was previously tasted and is still in the fridge.',
    'recstatus: deleted'           => 'This beer was drank but was thrown away because it was not good.',
    'recstatus: earliershowing'    => 'This beer will be drank at an earlier time instead.',
    'recstatus: force_record'      => 'This beer was manually set to be drank at this specific time.',
    'recstatus: inactive'          => '',
    'recstatus: latershowing'      => 'Some wanker shook this beer.  Will drink later.',
    'recstatus: lowdiskspace'      => 'There wasn\'t enough blood available to drink this beer.',
    'recstatus: manualoverride'    => 'This was manually set to not be drank',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => 'This beer was previously drank, according to the duplicate policy chosen for this beer.',
    'recstatus: recorded'          => 'This beer was drank.',
    'recstatus: recording'         => 'This beer is being consumed now.',
    'recstatus: repeat'            => '',
    'recstatus: stopped'           => 'This beer was being drank but was stopped before drinking was completed.',
    'recstatus: toomanyrecordings' => 'Too many bottles of this beer have already been drank.',
    'recstatus: tunerbusy'         => 'The bottle opener was already being used when this beer was scheduled to be drank.',
    'recstatus: unknown'           => 'The status of this beer is unknown.',
    'recstatus: willrecord'        => 'This beer will be drank.',
// includes/recording_schedules.php
    'Dup Method'                   => 'Old Beer Method',
    'Profile'                      => 'Beerofile',
    'Sub and Desc (Empty matches)' => '',
    'rectype: finddaily'           => '',
    'rectype: findweekly'          => '',
// includes/utils.php
    '$1 B'  => '$1 shotglass',
    '$1 GB' => '$1 stein',
    '$1 KB' => '$1 halfpint',
    '$1 MB' => '$1 pint',
    '$1 TB' => '$1 yard',
// modules/backend_log/init.php
    'Logs' => '',
// modules/movietimes/init.php
    'Movie Times' => '',
// modules/settings/init.php
    'MythTV channel info'      => '',
    'MythTV key bindings'      => '',
    'MythWeb session settings' => '',
    'settings'                 => '',
// modules/status/init.php
    'Status' => '',
// modules/stream/init.php
    'Streaming' => '',
// modules/tv/detail.php
    'This program is already scheduled to be recorded via a $1custom search$2.' => '',
    'Unknown Program.'                                                          => '',
    'Unknown Recording Schedule.'                                               => '',
// modules/tv/init.php
    'Special Searches' => '',
    'TV'               => '',
// modules/tv/schedules_custom.php
    'Any Category'     => '',
    'Any Channel'      => '',
    'Any Program Type' => '',
// modules/tv/search.php
    'Please search for something.' => '',
// modules/video/init.php
    'Video' => '',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => '',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => '',
// themes/default/header.php
    'Category Legend'                            => '',
    'Category Type'                              => '',
    'Custom'                                     => '',
    'Edit MythWeb and some MythTV settings.'     => 'Warning: Do not do while drunk!',
    'Exact Match'                                => '',
    'HD Only'                                    => '',
    'Manual'                                     => '',
    'MythMusic on the web.'                      => '',
    'MythVideo on the web.'                      => '',
    'MythWeb Weather.'                           => '',
    'Search fields'                              => '',
    'Search help'                                => '',
    'Search help: movie example'                 => '*** 1/2 Adventure',
    'Search help: movie search'                  => 'movie search',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'regex search',
    'Search options'                             => '',
    'Searches'                                   => '',
    'TV functions, including recorded programs.' => '',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => '',
// themes/default/music/music.php
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
// themes/default/music/welcome.php
    'welcome: music' => '',
// themes/default/settings/channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'If you edit this table while drunk (and you are), then you can really beer things up.',
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
    'xmltvid'                                                                                                                            => '',
// themes/default/settings/keys.php
    'Action'                => '',
    'Configure Keybindings' => '',
    'Context'               => '',
    'Destination'           => '',
    'Edit keybindings on'   => '',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => '',
    'Date Formats'                    => '',
    'Guide Settings'                  => '',
    'Hour Format'                     => '',
    'Language'                        => 'You are WAY too drunk!',
    'Listing &quot;Jump to&quot;'     => '',
    'Listing Time Key'                => '',
    'MythWeb Session Settings'        => '',
    'MythWeb Theme'                   => '',
    'Only display favourite channels' => '',
    'Reset'                           => '',
    'SI Units?'                       => '',
    'Scheduled Popup'                 => '',
    'Show descriptions on new line'   => '',
    'Status Bar'                      => '',
    'Weather Icons'                   => '',
    'format help'                     => '',
// themes/default/settings/settings.php
    'settings: overview' => 'This is the index page for the configuration settings...<p>It\'s incomplete, and will eventually get some nicer formatting.  For now, you can choose from the following:',
// themes/default/settings/welcome.php
    'welcome: settings' => '',
// themes/default/status/welcome.php
    'welcome: status' => '',
// themes/default/tv/channel.php
    'Channel Detail' => '',
    'Length'         => '',
    'Show'           => '',
    'Time'           => '',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Back to the refrigerator',
    'Back to the recording schedules'     => 'Back to the temperatures',
    'Cast'                                => 'Ingredients',
    'Directed by'                         => 'Brewed by',
    'Don\'t record this program.'         => 'Don\'t drink this beer.',
    'Episode Number'                      => '',
    'Exec. Producer'                      => 'Co-Brewer',
    'Find other showings of this program' => 'Find other bottles of this beer',
    'Find showings of this program'       => 'Find more of this beer',
    'Google'                              => 'Liquorland',
    'Guest Starring'                      => '',
    'Guide rating'                        => '',
    'Hosted by'                           => 'Brewery at',
    'MythTV Status'                       => '',
    'Possible conflicts with this show'   => '',
    'Presented by'                        => '',
    'Produced by'                         => '',
    'Program Detail'                      => '',
    'Program ID'                          => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'What else is drinkable at this time?',
    'Written by'                          => 'Ingredient list by',
// themes/default/tv/list.php
    'Currently Browsing:  $1' => 'Currently Drinking: $1',
    'Jump To'                 => '',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 beer',
    '$1 episodes'                                         => '$1 beers',
    '$1 recording'                                        => '$1 beer',
    '$1 recordings'                                       => '$1 beers',
    'Are you sure you want to delete the following show?' => 'Are you sure you want to discard the following bottle?',
    'Delete'                                              => 'Discard',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => '',
    'Delete and rerecord $1'                              => '',
    'Go'                                                  => 'Beer!',
    'Show group'                                          => 'Show sixpack',
    'Show recordings'                                     => 'Show beers',
    'auto-expire'                                         => '',
    'file size'                                           => '',
    'has bookmark'                                        => '',
    'has commflag'                                        => '',
    'has cutlist'                                         => '',
    'is editing'                                          => '',
    'preview'                                             => '',
// themes/default/tv/schedules.php
    'Any'                                       => '',
    'No recording schedules have been defined.' => '',
    'channel'                                   => '',
    'profile'                                   => '',
    'transcoder'                                => '',
    'type'                                      => '',
// themes/default/tv/schedules_custom.php
    'Additional Tables' => '',
    'Keyword Search'    => '',
    'People Search'     => '',
    'Power Search'      => '',
    'Search Phrase'     => '',
    'Search Type'       => '',
    'Title Search'      => '',
// themes/default/tv/schedules_manual.php
    'Channel'      => '',
    'Length (min)' => '',
    'Start Date'   => '',
    'Start Time'   => '',
// themes/default/tv/search.php
    'No matches found'                 => '',
    'No matching programs were found.' => '',
    'Search for:  $1'                  => '',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => '',
    'handy: overview'           => '',
// themes/default/tv/upcoming.php
    'Commands'    => '',
    'Conflicts'   => 'Bad Beer',
    'Deactivated' => 'Not Drinking',
    'Duplicates'  => 'Warm Beers',
    'Scheduled'   => '',
// themes/default/tv/welcome.php
    'welcome: tv' => '',
// themes/default/video/video.php
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
// themes/default/video/welcome.php
    'welcome: video' => '',
// themes/default/weather/weather.php
    ' at '               => '',
    'Current Conditions' => '',
    'Forecast'           => '',
    'Friday'             => 'Beerday',
    'High'               => '',
    'Humidity'           => '',
    'Last Updated'       => '',
    'Low'                => '',
    'Monday'             => 'Beerday',
    'Pressure'           => '',
    'Radar'              => 'Beerdar',
    'Saturday'           => 'Saturbeer',
    'Sunday'             => 'Sunbeer',
    'Thursday'           => 'Thursbeer',
    'Today'              => 'ToBeerday',
    'Tomorrow'           => 'Buy More Beer Day',
    'Tuesday'            => 'Tuesbeer',
    'UV Extreme'         => '',
    'UV High'            => '',
    'UV Index'           => '',
    'UV Minimal'         => '',
    'UV Moderate'        => '',
    'Visibility'         => 'Grogginess',
    'Wednesday'          => 'Wednesbeer',
    'Wind'               => '',
    'Wind Chill'         => '',
// themes/default/weather/welcome.php
    'welcome: weather' => ''
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
$Categories['Adult']          = array('Rooting',          '\\b(?:adult|erot)'); // changed
$Categories['Animals']        = array('Furries',          '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Art_Music',        '\\b(?:art|dance|music|cultur)');
$Categories['Business']       = array('Business',         '\\b(?:biz|busine)');
$Categories['Children']       = array('Anklebiters',      '\\b(?:child|infan|animation)');
$Categories['Comedy']         = array('Comedy',           '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Crime / Mystery',  '\\b(?:crim|myster)');
$Categories['Documentary']    = array('Boring',           '\\b(?:doc)');
$Categories['Drama']          = array('Drama',            '\\b(?:drama)');
$Categories['Educational']    = array('Educational',      '\\b(?:edu|interests)');
$Categories['Food']           = array('Grub',             '\\b(?:food|cook|drink)');
$Categories['Game']           = array('Game',             '\\b(?:game)');
$Categories['Health_Medical'] = array('Health / Medical', '\\b(?:health|medic)');
$Categories['History']        = array('History',          '\\b(?:hist)');
$Categories['Horror']         = array('Horror',           '\\b(?:horror)');
$Categories['HowTo']          = array('HowTo',            '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Misc',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('News',             '\\b(?:news|current)');
$Categories['Reality']        = array('Reality',          '\\b(?:reality)');
$Categories['Romance']        = array('Sheila Stuff',     '\\b(?:romance)');
$Categories['SciFi_Fantasy']  = array('SciFi / Fantasy',  '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Science_Nature'] = array('Science / Nature', '\\b(?:science|nature|environment)');
$Categories['Shopping']       = array('Sheila Stuff',     '\\b(?:shop)');
$Categories['Soaps']          = array('Sheila Stuff',     '\\b(?:soaps)');
$Categories['Spiritual']      = array('Spiritual',        '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Footie',           '\\b(?:sport)');
$Categories['Talk']           = array('Talk',             '\\b(?:talk)');
$Categories['Travel']         = array('Travel',           '\\b(?:travel)');
$Categories['War']            = array('War',              '\\b(?:war)');
$Categories['Western']        = array('Western',          '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Unknown');
$Categories['movie']          = array('Movie'  );

