<?php
/***                                                                        ***\
    languages/English.php

    Translation hash for Danish.
\***                                                                        ***/

// Set the locale to Danish UTF-8
setlocale(LC_ALL, 'da_DK.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    ' at '                                               => ' ved ',
    '$1 hr'                                              => '$1 t',
    '$1 hrs'                                             => '$1 t',
    '$1 min'                                             => '$1 minut',
    '$1 mins'                                            => '$1 minutter',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 programmer, bruger $2 ($3) ud af $4',
    '$1 to $2'                                           => '$1 til $2',
    'Activate'                                           => 'Aktiver',
    'Advanced Options'                                   => 'Avancerede indstillinger',
    'Airtime'                                            => 'Visningsdato',
    'All recordings'                                     => 'Alle optagelser',
    'Auto-expire recordings'                             => 'Auto-udløb optagelser',
    'Auto-flag commercials'                              => 'Marker automatisk reklamer',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'System status',
    'Cancel this schedule.'                              => 'Annuller denne optagelse',
    'Category'                                           => 'Kategori',
    'Category Legend'                                    => 'Kategoriforklaring',
    'Category Type'                                      => 'Kategori Type',
    'Channel'                                            => 'Kanal',
    'Check for duplicates in'                            => 'Kontroller for dubletter i',
    'Create Schedule'                                    => 'Planlæg',
    'Current Conditions'                                 => 'Nuværende forhold',
    'Current recordings'                                 => 'Nuværende optagelser',
    'Currently Browsing:  $1'                            => 'Lige nu vises: $1',
    'Date'                                               => 'Dato',
    'Default'                                            => 'Standard',
    'Description'                                        => 'Beskrivelse',
    'Details for'                                        => '',
    'Display'                                            => 'Vis',
    'Don\'t Record'                                      => 'Optag ikke',
    'Duplicate Check method'                             => 'dubletkontrol metode',
    'Edit MythWeb and some MythTV settings.'             => 'Rediger MythWeb- og nogle MythTV-indstillinger',
    'End Late'                                           => 'Slut senere (min)',
    'Episode'                                            => 'Afsnit',
    'Exact Match'                                        => 'Præcis match',
    'Forecast'                                           => 'Prognose',
    'Forget Old'                                         => 'Glem gamle',
    'Friday'                                             => 'Fredag',
    'Go'                                                 => 'Gå',
    'HD Only'                                            => '',
    'High'                                               => 'Høj',
    'Hour'                                               => 'Time',
    'Humidity'                                           => 'Luftfugtighed',
    'IMDB'                                               => '',
    'Inactive'                                           => '',
    'Jump'                                               => 'Gå',
    'Jump To'                                            => 'Gå Til',
    'Jump to'                                            => 'Gå til',
    'Last Updated'                                       => 'Sidst opdateret',
    'Length (min)'                                       => 'Længde (min)',
    'Listings'                                           => 'Programoversigt',
    'Low'                                                => 'Lav',
    'Manually Schedule'                                  => 'Planlæg manuelt',
    'Monday'                                             => 'Mandag',
    'Music'                                              => '',
    'MythMusic on the web.'                              => 'MythMusic på www',
    'MythVideo on the web.'                              => 'MythVideo på www',
    'MythWeb Weather.'                                   => 'MythWeb Vejrudsigt',
    'Never Record'                                       => 'Optag aldrig',
    'No'                                                 => 'Nej',
    'No. of recordings to keep'                          => 'Gem antal optagelser',
    'None'                                               => 'Ingen',
    'Notes'                                              => 'Bemærkninger',
    'Only New Episodes'                                  => 'Kun Nye Afsnit',
    'Original Airdate'                                   => 'Oprindelig visningsdato',
    'Please search for something.'                       => '',
    'Pressure'                                           => 'Lufttryk',
    'Previous recordings'                                => 'Tidligere optagelser',
    'Program Listing'                                    => '',
    'Radar'                                              => '',
    'Rating'                                             => 'Karakterer',
    'Record This'                                        => 'Optag dette',
    'Record new and expire old'                          => 'Optag nye og udløb gamle',
    'Recorded Programs'                                  => 'Optagede programmer',
    'Recording Group'                                    => 'Optagelsesgruppe',
    'Recording Options'                                  => 'Optageindstillinger',
    'Recording Priority'                                 => 'Optageprioritet',
    'Recording Profile'                                  => 'Optageprofil',
    'Recording Schedules'                                => 'Optagelsesplanlægning',
    'Rerun'                                              => 'Genudsendelse',
    'Saturday'                                           => 'Lørdag',
    'Save'                                               => 'Gem',
    'Schedule'                                           => 'Planlæg',
    'Schedule Options'                                   => 'Planlægningsindstillinger',
    'Schedule Override'                                  => 'Planlæg manuelt',
    'Schedule normally.'                                 => 'Planlæg normalt',
    'Scheduled Recordings'                               => 'Planlagte optagelser',
    'Search'                                             => 'Søg',
    'Search Results'                                     => 'Søgeresultater',
    'Search fields'                                      => '',
    'Search help'                                        => '',
    'Search help: movie example'                         => '*** 1/2 Adventure',
    'Search help: movie search'                          => 'movie search',
    'Search help: regex example'                         => '/^Good Eats/',
    'Search help: regex search'                          => 'regex search',
    'Search options'                                     => '',
    'Searches'                                           => '',
    'Settings'                                           => 'Indstillinger',
    'Start Date'                                         => 'Startdato',
    'Start Early'                                        => 'Start tidligere (min)',
    'Start Time'                                         => 'Starttidspunkt',
    'Subtitle'                                           => 'Undertitel',
    'Subtitle and Description'                           => 'Undertitel og beskrivelse',
    'Sunday'                                             => 'Søndag',
    'TV functions, including recorded programs.'         => 'TV funktioner inkl. optagede programmer',
    'The requested recording schedule has been deleted.' => 'Den planlagte optagelse er blevet slettet',
    'Thursday'                                           => 'Torsdag',
    'Title'                                              => 'Titel',
    'Today'                                              => 'I dag',
    'Tomorrow'                                           => 'I morgen',
    'Transcoder'                                         => '',
    'Tuesday'                                            => 'Tirsdag',
    'UV Extreme'                                         => 'UV-stråling ekstrem',
    'UV High'                                            => 'UV-stråling høj',
    'UV Index'                                           => 'UV-stråling indeks',
    'UV Minimal'                                         => 'UV-stråling minimal',
    'UV Moderate'                                        => 'UV-stråling middel',
    'Unknown'                                            => 'Ukendt',
    'Update'                                             => '',
    'Update Recording Settings'                          => 'Opdater optagelsesindstillinger',
    'Visibility'                                         => 'Sigtbarhed',
    'Weather'                                            => '',
    'Wednesday'                                          => 'Onsdag',
    'Wind'                                               => 'Vind',
    'Wind Chill'                                         => 'Vindafkølningseffekt',
    'Yes'                                                => 'Ja',
    'airdate'                                            => 'visningsdato',
    'channum'                                            => 'kanalnummer',
    'description'                                        => 'beskrivelse',
    'generic_date'                                       => '%a %e %b %Y',
    'generic_time'                                       => '%H:%M',
    'length'                                             => 'længde',
    'minutes'                                            => 'minutter',
    'recgroup'                                           => 'Optagelsesgrupper',
    'recpriority'                                        => '',
    'rectype-long: always'                               => 'Optag når som helst på alle kanaler.',
    'rectype-long: channel'                              => 'Optag når som helst på kanalen $1.',
    'rectype-long: daily'                                => 'Optag dette program på dette tidspunkt hver dag.',
    'rectype-long: dontrec'                              => 'Optag ikke denne specifikke visning.',
    'rectype-long: finddaily'                            => 'Find og optag en visning af dette program hver dag.',
    'rectype-long: findone'                              => 'Find og optag en visning af dette program.',
    'rectype-long: findweekly'                           => 'Find og optag en visning af dette program hver uge.',
    'rectype-long: once'                                 => 'Optag kun denne visning.',
    'rectype-long: override'                             => 'Optag denne specifikke visning.',
    'rectype-long: weekly'                               => 'Optag dette program på dette tidspunkt hver uge.',
    'rectype: always'                                    => 'Altid',
    'rectype: channel'                                   => 'Kanal',
    'rectype: daily'                                     => 'Dagligt',
    'rectype: dontrec'                                   => 'Optag ikke',
    'rectype: findone'                                   => 'Find en',
    'rectype: once'                                      => 'en enkelt gang',
    'rectype: override'                                  => 'Override (record)',
    'rectype: weekly'                                    => 'Ugentligt',
    'subtitle'                                           => 'undertitel',
    'title'                                              => 'titel',
// includes/programs.php
    'recstatus: cancelled'         => 'Dette var planlagt til at skulle optages, men blev aflyst manuelt.',
    'recstatus: conflict'          => 'Et andet program med højere optageprioritet bliver optaget.',
    'recstatus: currentrecording'  => 'Dette afsnit er optaget tidligere og er stadig tilgængeligt i listen af optagede programmer.',
    'recstatus: deleted'           => 'Denne visning blev optaget, men blev slettet inden optagelsen var færdig.',
    'recstatus: earliershowing'    => 'Dette afsnit vil blive optaget på et tidligere tidspunkt.',
    'recstatus: force_record'      => 'Dette program er manuelt sat til at blive optaget.',
    'recstatus: inactive'          => '',
    'recstatus: latershowing'      => 'Dette afsnit vil blive optaget på et senere tidspunkt.',
    'recstatus: lowdiskspace'      => 'Der var ikke nok diskplads til at optage dette program.',
    'recstatus: manualoverride'    => 'Denne visning er manuelt sat til ikke at blive optaget.',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => 'Dette afsnit er tidligere optaget jævnfør den duplikeringsindstilling der er valgt for dette program.',
    'recstatus: recorded'          => 'Denne visning er optaget.',
    'recstatus: recording'         => 'Optagelse af denne visning er i gang.',
    'recstatus: repeat'            => 'Denne visning er en gentagelse og vil ikke blive optaget.',
    'recstatus: stopped'           => 'Denne visning blev optaget, men blev stoppet inden optagelsen var færdig.',
    'recstatus: toomanyrecordings' => 'Der findes for mange optagelser af dette program.',
    'recstatus: tunerbusy'         => 'Tuner-kortet var i brug, da dette program skulle have været optaget.',
    'recstatus: unknown'           => 'Status for denne visning er ukendt.',
    'recstatus: willrecord'        => 'Denne visning vil blive optaget.',
// includes/recording_schedules.php
    'Dup Method'                   => 'dubletkontrol metode',
    'Profile'                      => 'Profil',
    'Sub and Desc (Empty matches)' => 'Undertitel og beskrivelse',
    'Type'                         => 'Type',
    'rectype: finddaily'           => 'find 1 dagligt',
    'rectype: findweekly'          => 'find 1 ugentligt',
// includes/utils.php
    '$1 B'  => '',
    '$1 GB' => '',
    '$1 KB' => '',
    '$1 MB' => '',
    '$1 TB' => '',
// modules/movietimes/init.php
    'Movie Times' => '',
// modules/settings/init.php
    'settings' => '',
// modules/status/init.php
    'Status' => '',
// modules/tv/init.php
    'Search TV'           => '',
    'Special Searches'    => '',
    'TV'                  => '',
    'Upcoming Recordings' => '',
// modules/video/init.php
    'Video' => '',
// program_detail.php
    'Unknown Program.'            => 'Ukendt program',
    'Unknown Recording Schedule.' => 'Ukendt planlagt optagelse',
// themes/.../canned_searches.php
    'handy: overview' => '',
// themes/.../channel_detail.php
    'Length' => 'Længde',
    'Show'   => 'Program',
    'Time'   => 'Tidspunkt',
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
// themes/.../program_detail.php
    '$1 Rating'                           => '$1 Karakterer',
    'Back to the program listing'         => 'Tilbage til programoversigten',
    'Back to the recording schedules'     => 'Tilbage til planlagte optagelser',
    'Cast'                                => 'Rolleliste',
    'Directed by'                         => 'Instrueret af',
    'Don\'t record this program.'         => '',
    'Exec. Producer'                      => 'Producer',
    'Find other showings of this program' => 'Find andre visninger af dette program',
    'Find showings of this program'       => 'Find visninger af dette program',
    'Google'                              => '',
    'Guest Starring'                      => 'Gæstestjerner',
    'Guide rating'                        => '',
    'Hosted by'                           => '',
    'Presented by'                        => 'Præsenteret af',
    'Produced by'                         => 'Produceret af',
    'Program Detail'                      => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'Hvad er der ellers i fjernsynet på dette tidspunkt?',
    'Written by'                          => 'Skrevet af',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1 afsnit',
    '$1 episodes'                                         => '$1 afsnit',
    '$1 recording'                                        => '$1 optagelse',
    '$1 recordings'                                       => '$1 optagelser',
    'Are you sure you want to delete the following show?' => 'Er du sikker på at du vil slette programmet?',
    'Delete'                                              => 'Slet',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => '',
    'Delete and rerecord $1'                              => '',
    'Show group'                                          => 'Vis gruppe',
    'Show recordings'                                     => 'Vis optagelser',
    'auto-expire'                                         => 'auto-udløb',
    'file size'                                           => 'filstørrelse',
    'has bookmark'                                        => 'har bookmark(s)',
    'has commflag'                                        => 'har markeret reklameblokke',
    'has cutlist'                                         => 'har klippeliste',
    'is editing'                                          => 'er ved at blive redigeret',
    'preview'                                             => 'forhåndsvisning',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profilgrupper',
    'Recording profiles' => 'Optagelsesprofiler',
// themes/.../recording_schedules.php
    'Any'                                       => 'Alle',
    'No recording schedules have been defined.' => '',
    'channel'                                   => '',
    'profile'                                   => 'profil',
    'transcoder'                                => '',
    'type'                                      => 'type',
// themes/.../schedule_manually.php
    'Save Schedule'     => '',
    'Schedule Manually' => '',
// themes/.../scheduled_recordings.php
    'Commands'    => 'Kommandoer',
    'Conflicts'   => 'Konflikter',
    'Deactivated' => 'Deaktiveret',
    'Duplicates'  => 'Dubletter',
    'Scheduled'   => 'Planlagt',
// themes/.../search.php
    'No matches found' => 'Ingen resultater',
    'Search for:  $1'  => '',
// themes/.../settings.php
    'Channels'           => 'Kanaler',
    'Configure'          => 'Konfigurer',
    'Key Bindings'       => 'Tastaturgenveje',
    'MythWeb Settings'   => 'MythWeb indstillinger',
    'settings: overview' => 'Dette er hovedsiden til indstillinger...<p>Den er ikke komplet, og vil senere komme til at se noget pænere ud. Lige nu kan du vælge imellem:',
// themes/.../settings_channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Bemærk at ved at ændre i denne tabel uden at vide hvad du laver, kan du ødelægge mythtvs funktioner.',
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
    'Edit keybindings on'   => 'Rediger tastaturgenveje for',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'Kanal &quot;Gå Til&quot;',
    'Date Formats'                    => 'Datoformater',
    'Guide Settings'                  => '',
    'Hour Format'                     => 'Timeformattering',
    'Language'                        => 'Sprog',
    'Listing &quot;Jump to&quot;'     => 'Programoversigt &quot;Gå til&quot;',
    'Listing Time Key'                => 'Programoversigt tid',
    'MythWeb Theme'                   => 'MythWeb Tema',
    'Only display favourite channels' => '',
    'Reset'                           => 'Nulstil',
    'SI Units?'                       => '',
    'Scheduled Popup'                 => 'Planlagt popup',
    'Show descriptions on new line'   => 'Vis beskrivelser på ny linie',
    'Status Bar'                      => '',
    'Weather Icons'                   => '',
    'format help'                     => 'Formatteringshjælp',
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


//Translate chars to utf8
foreach($L as $key => $val){
    $L[$key] = utf8_encode($val);
}

/*
    Show Categories:
    $Categories is a hash of keys corresponding to the css style used for each
    show category.  Each entry is an array containing the name of that category
    in the language this file defines (it will not be translated separately),
    and a regular expression pattern used to match the category against those
    provided in the listings.
*/
$Categories = array();
$Categories['Action']         = array('Action',           '\\b(?:action|even)');
$Categories['Adult']          = array('Erotik',            '\\b(?:adult|eroti|porno)');
$Categories['Animals']        = array('Dyr',          '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Kunst/Musik',        '\\b(?:art|kunst|dan(s|ce)|musi[ck]|[ck]ultur)');
$Categories['Business']       = array('Business',         '\\b(?:biz|busine|økon)');
$Categories['Children']       = array('Børneprogram',         '\\b(?:child|børn|tegnef|animation)');
$Categories['Comedy']         = array('Komedie',           '\\b(?:[ck]omed|entertain|sitcom|underh|stand)');
$Categories['Crime_Mystery']  = array('Krimi/Mysterier',  '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Dokumentar',      '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',            '\\b(?:drama)');
$Categories['Educational']    = array('Undervisning',      '\\b(?:edu|interests|undervis)');
$Categories['Food']           = array('Mad',             '\\b(?:food|cook|essen|drink|mad|vin)');
$Categories['Game']           = array('Spil',             '\\b(?:game|spil)');
$Categories['Health_Medical'] = array('Helse/Medicin', '\\b(?:health|medic|sundhe)');
$Categories['History']        = array('Historie',          '\\b(?:hist)');
$Categories['Horror']         = array('Horror',           '\\b(?:horror)');
$Categories['HowTo']          = array('Gør-det-selv',            '\\b(?:how|home|house|garden|gør|bolig)');
$Categories['Misc']           = array('Diverse',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nyheder',             '\\b(?:news|current|verdensn|nyheder|nyheter|aktuell?t|rapport)');
$Categories['Reality']        = array('Reality',          '\\b(?:reality)');
$Categories['Romance']        = array('Romantik',          '\\b(?:romance|romanti)');
$Categories['SciFi_Fantasy']  = array('SciFi/Fantasy',  '\\b(?:fantasy|sci\\w*\\W*fi|rum)');
$Categories['Science_Nature'] = array('Naturvidenskab', '\\b(?:science|nature?|environment|vidensk)');
$Categories['Shopping']       = array('Shopping',         '\\b(?:shop)');
$Categories['Soaps']          = array('Sæbeopera',            '\\b(?:soaps?|sæbeop)');
$Categories['Spiritual']      = array('Åndeligt/Religion',        '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',           '\\b(?:sport|fodbold|håndbold|badmin|tennis|golf)');
$Categories['Talk']           = array('Talkshow',             '\\b(?:talk)');
$Categories['Travel']         = array('Rejseprogram',           '\\b(?:travel|rejse)');
$Categories['War']            = array('Krig',              '\\b(?:war|krig)');
$Categories['Western']        = array('Western',          '\\b(?:west|cowb)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Ukendt');
$Categories['movie']          = array('Film'  );

//Encode localized category names into utf8
foreach($Categories as $category => $definition){
    $Categories[$category][0] = utf8_encode($definition[0]);
}

