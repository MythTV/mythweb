<?php
/***                                                                        ***\
    languages/Japanese.php

    Translation hash for Japanese.
\***                                                                        ***/

// Set the locale to Japanese UTF-8
setlocale(LC_ALL, 'ja_JP.utf-8');

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
    'generic_date' => '%e %b, %Y',
    'generic_time' => '%I:%M %p',
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
$Categories['Action']         = array('アクション',          'アクション');
$Categories['Adult']          = array('アダルト',             'アダルト');
$Categories['Animals']        = array('動物',                   '動物');
$Categories['Art_Music']      = array('芸術 音楽',            '(芸術|音楽)');
$Categories['Business']       = array('ビジネス',             'ビジネス');
$Categories['Children']       = array('子供',                   'アニメ');
$Categories['Comedy']         = array('コメディー',          'コメディー');
$Categories['Crime_Mystery']  = array('犯罪　ミステリー', '(犯罪|ミステリー)');
$Categories['Documentary']    = array('ドキュメンタリー', 'ドキュメンタリー');
$Categories['Drama']          = array('ドラマ',                'ドラマ');
$Categories['Educational']    = array('教育',                   '教養');
$Categories['Food']           = array('食事',                   '食事');
$Categories['Game']           = array('',                         'ゲーム');
$Categories['Health_Medical'] = array('健康　医療',          '(健康|医療)');
$Categories['History']        = array('歴史',                   '歴史');
$Categories['Horror']         = array('ホラー',                'ホラー');
$Categories['HowTo']          = array('ハウツー',             'ハウツー');
$Categories['Misc']           = array('バラエティー',       'バラエティー');
$Categories['News']           = array('ニュース',             '映画');
$Categories['Reality']        = array('リアリティー',       '報道');
$Categories['Romance']        = array('ロマンス',             'リアリティー');
$Categories['SciFi_Fantasy']  = array('科学　自然',          'ロマンス');
$Categories['Science_Nature'] = array('SF ファンタジー',    '科学　自然');
$Categories['Shopping']       = array('ショッピング',       'SF ファンタジー');
$Categories['Soaps']          = array('メロドラマ',          'ショッピング');
$Categories['Spiritual']      = array('趣味',                   'メロドラマ');
$Categories['Sports']         = array('スポーツ',             '趣味');
$Categories['Talk']           = array('トーク',                'スポーツ');
$Categories['Travel']         = array('旅行',                   'トーク');
$Categories['War']            = array('戦争',                   '旅行');
$Categories['Western']        = array('ウェスタン',          '戦争');
                                                                  'ウェスタン');
// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('不明');
$Categories['movie']          = array('映画');

?>
