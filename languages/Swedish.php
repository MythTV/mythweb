<?php
/***                                                                        ***\
    languages/Swedish.php

    Translation hash for Swedish.
\***                                                                        ***/

// Set the locale to Swedish UTF-8
setlocale(LC_ALL, 'sv_SE.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 min'                    => '$1 min',
    '$1 mins'                   => '$1 min',
    'Airtime'                   => 'Sändningstid',
    'All recordings'            => 'Alla inspelningar',
    'Auto-expire recordings'    => 'Autoradera inspelningar',
    'Category'                  => 'Kategori',
    'Check for duplicates in'   => 'Sök dubletter i',
    'Current recordings'        => 'Nuvarande inspelningar',
    'Date'                      => 'Datum',
    'Description'               => 'Beskrivning',
    'Duplicate Check method'    => 'Dublettmetod',
    'End Late'                  => 'Sluta senare',
    'Go'                        => 'Gå',
    'No. of recordings to keep' => 'Antal inspelningar att behålla',
    'None'                      => 'Ingen',
    'Notes'                     => 'Anteckningar',
    'Original Airdate'          => 'Ursprungligt visningsdatum',
    'Previous recordings'       => 'Tidigare inspelningar',
    'Profile'                   => 'Profil',
    'Rating'                    => 'Betyg',
    'Record new and expire old' => 'Spela in nya och radera gamla',
    'Recorded Programs'         => 'Inspelade program',
    'Recording Group'           => 'Inspelningsgrupp',
    'Recording Options'         => 'Inspelningsinställningar',
    'Recording Priority'        => 'Inspelningsprioritet',
    'Recording Profile'         => 'Inspelningsprofil',
    'Rerun'                     => 'Repris',
    'Schedule'                  => 'Schema',
    'Scheduled Recordings'      => 'Schemalagda inspelningar',
    'Search'                    => 'Sök',
    'Start Early'               => 'Börja tidigare',
    'Subtitle'                  => 'Undertitel',
    'Subtitle and Description'  => 'Undertitel och beskrivning',
    'Title'                     => 'Titel',
    'Unknown'                   => 'Okänd',
    'Update Recording Settings' => 'Uppdatera inspelningsinställningar',
    'rectype-long: always'      => 'rectype-long: alltid',
    'rectype-long: channel'     => 'rectype-long: kanal',
    'rectype-long: daily'       => 'rectype-long: daglig',
    'rectype-long: findone'     => 'rectype-long: hitta en',
    'rectype-long: once'        => 'rectype-long: enstaka',
    'rectype-long: weekly'      => 'rectype-long: veckovis',
// includes/init.php
    'generic_date' => '%Y-%m-%d',
    'generic_time' => '%H:%i',
// includes/programs.php
    'recstatus: cancelled'         => 'recstatus: avbruten',
    'recstatus: conflict'          => 'recstatus: konflikt',
    'recstatus: currentrecording'  => 'recstatus: nuvarande inspelning',
    'recstatus: deleted'           => 'recstatus: borttagen',
    'recstatus: earliershowing'    => 'recstatus: tidigare visning',
    'recstatus: force_record'      => 'recstatus: tvinga inspelning',
    'recstatus: latershowing'      => 'recstatus: senare visning',
    'recstatus: lowdiskspace'      => 'recstatus: lågt diskutrymme',
    'recstatus: manualoverride'    => 'recstatus: manuell överskuggning',
    'recstatus: overlap'           => 'recstatus: överlappa',
    'recstatus: previousrecording' => 'recstatus: föregående inspelning',
    'recstatus: recorded'          => 'recstatus: inspelad',
    'recstatus: recording'         => 'recstatus: spelar in',
    'recstatus: stopped'           => 'recstatus: stoppad',
    'recstatus: toomanyrecordings' => 'recstatus: för många inspelningar',
    'recstatus: tunerbusy'         => 'recstatus: TV-mottagare upptagen',
    'recstatus: unknown'           => 'recstatus: okänd',
    'recstatus: willrecord'        => 'recstatus: ska spelas in',
// includes/recordings.php
    'rectype: always'   => 'rectype: alltid',
    'rectype: channel'  => 'rectype: kanal',
    'rectype: daily'    => 'rectype: daglig',
    'rectype: dontrec'  => 'rectype: spela ej in',
    'rectype: findone'  => 'rectype: hitta en',
    'rectype: once'     => 'rectype: enstaka',
    'rectype: override' => 'rectype: överskugga',
    'rectype: weekly'   => 'rectype: veckovis',
// includes/utils.php
    '$1 B'   => '$1 B',
    '$1 GB'  => '$1 GB',
    '$1 KB'  => '$1 KB',
    '$1 MB'  => '$1 MB',
    '$1 TB'  => '$1 TB',
    '$1 hr'  => '$1h',
    '$1 hrs' => '$1h',
// themes/.../channel_detail.php
    'Episode' => 'Avsnitt',
    'Jump to' => 'Gå till',
    'Length'  => 'Längd',
    'Show'    => 'Program',
    'Time'    => 'Tid',
// themes/.../program_detail.php
    '$1 to $2'                            => '$1 till $2',
    'Back to the program listing'         => 'Tillbaka till programlistan',
    'Back to the recording schedules'     => 'Tillbaka till inspelningsschemat',
    'Cancel this schedule'                => 'Avbryt denna schemaläggning',
    'Don\'t record this program'          => 'Spela inte in detta program',
    'Find other showings of this program' => 'Hitta andra visningar av detta program',
    'Google'                              => 'Google',
    'IMDB'                                => 'IMDB',
    'TVTome'                              => 'TVTime',
    'What else is on at this time?'       => 'Vad visas mer vid denna tid?',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => 'Just nu visas:  $1',
    'Hour'                    => 'Timme',
    'Jump'                    => 'Hoppa',
    'Jump To'                 => 'Hoppa till',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1 avsnitt',
    '$1 episodes'                                         => '$1 avsnitt',
    '$1 programs, using $2 ($3) out of $4.'               => '$1 program ($3), som använder $2 av $4',
    '$1 recording'                                        => '$1 inspelning',
    '$1 recordings'                                       => '$1 inspelningar',
    'Are you sure you want to delete the following show?' => 'Är du säker på att du vill da bort följande inspelning?',
    'Delete'                                              => 'Radera',
    'No'                                                  => 'Nej',
    'Show group'                                          => 'Visa grupp',
    'Show recordings'                                     => 'Visa inspelningar',
    'Yes'                                                 => 'Ja',
    'auto-expire'                                         => 'autoradera',
    'has bookmark'                                        => 'bokmärke',
    'has commflag'                                        => 'markerad reklam',
    'has cutlist'                                         => 'klipplista',
    'is editing'                                          => 'editeras',
    'preview'                                             => 'förhandsvisning',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profilgrupper',
    'Recording profiles' => 'Inspelningsprofiler',
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
$Categories['Action']         = array('Action',          '\\b(?:action|adven)');
$Categories['Adult']          = array('Adult',           '\\b(?:adult|erot)');
$Categories['Animals']        = array('Djur',            '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Konst/musik',     '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)');
$Categories['Business']       = array('Affärer/ekonomi', '\\b(?:biz|busine)');
$Categories['Children']       = array('Barnprogram',     '\\b(?:child|kin?d|infan|animation)');
$Categories['Comedy']         = array('Komedi',          '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Brott/mysterier', '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('DokumentÃ¤r',     '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',           '\\b(?:drama)');
$Categories['Educational']    = array('Utbildning',      '\\b(?:edu|bildung|interests)');
$Categories['Food']           = array('Mat',             '\\b(?:food|cook|essen|[dt]rink)');
$Categories['Game']           = array('Lek/spel',        '\\b(?:game|spiele)');
$Categories['Health_Medical'] = array('Medicin/hÃ¤lsa',  '\\b(?:health|medic|gesundheit)');
$Categories['History']        = array('Historia',        '\\b(?:hist|geschichte)');
$Categories['Horror']         = array('Rysare',          '\\b(?:horror)');
$Categories['HowTo']          = array('GÃ¶r-det-sjÃ¤lv', '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Blandat',         '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nyheter',         '\\b(?:news|nyheter|aktuellt|rapport|(VÃ¤|Ã)stnytt)');
$Categories['Reality']        = array('DokusÃ¥pa',       '\\b(?:reality)');
$Categories['Romance']        = array('Romantik',        '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Natur/vetenskap', '\\b(?:science|nature|environment|wissenschaft)');
$Categories['Science_Nature'] = array('SciFi/fantasy',   '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Shopping']       = array('Shopping',        '\\b(?:shop)');
$Categories['Soaps']          = array('SÃ¥popera',       '\\b(?:soaps)');
$Categories['Spiritual']      = array('Andligt',         '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',           '\\b(?:sport|deportes|futbol)');
$Categories['Talk']           = array('Talkshow',        '\\b(?:talk)');
$Categories['Travel']         = array('Resor',           '\\b(?:travel|reisen)');
$Categories['War']            = array('Krig',            '\\b(?:war|krieg)');
$Categories['Western']        = array('Western',         '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('OkÃ¤nd');
$Categories['movie']          = array('Film'  );

?>
