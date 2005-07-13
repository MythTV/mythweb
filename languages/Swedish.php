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
    '$1 min'                                             => '$1 min',
    '$1 mins'                                            => '$1 min',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 program ($3), som använder $2 av $4',
    '$1 to $2'                                           => '$1 till $2',
    'Advanced Options'                                   => 'Avancerade inställningar',
    'Airtime'                                            => 'Sändningstid',
    'All recordings'                                     => 'Alla inspelningar',
    'Auto-expire recordings'                             => 'Autoradera inspelningar',
    'Auto-flag commercials'                              => 'Markera reklam automatiskt',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'Systemstatus',
    'Cancel this schedule.'                              => 'Avbryt denna schemaläggning',
    'Category'                                           => 'Kategori',
    'Channel'                                            => 'Kanal',
    'Check for duplicates in'                            => 'Sök dubbletter i',
    'Create Schedule'                                    => 'Schemalägg',
    'Current recordings'                                 => 'Nuvarande inspelningar',
    'Date'                                               => 'Datum',
    'Description'                                        => 'Beskrivning',
    'Details for'                                        => '',
    'Display'                                            => 'Visning',
    'Duplicate Check method'                             => 'Dubblettmetod',
    'End Late'                                           => 'Sluta senare',
    'Episode'                                            => 'Avsnitt',
    'Go'                                                 => 'Gå',
    'Hour'                                               => 'Timme',
    'IMDB'                                               => 'IMDB',
    'Jump'                                               => 'Gå',
    'Jump to'                                            => 'Gå till',
    'Length (min)'                                       => 'Längd (min)',
    'Listings'                                           => 'TV-tablåer',
    'No'                                                 => 'Nej',
    'No. of recordings to keep'                          => 'Antal inspelningar att behålla',
    'None'                                               => 'Ingen',
    'Notes'                                              => 'Anteckningar',
    'Only New Episodes'                                  => 'Endast nya avsnitt',
    'Original Airdate'                                   => 'Sändningsdatum',
    'Previous recordings'                                => 'Tidigare inspelningar',
    'Rating'                                             => 'Betyg',
    'Record new and expire old'                          => 'Spela in nya och radera gamla',
    'Recorded Programs'                                  => 'Inspelade program',
    'Recording Group'                                    => 'Inspelningsgrupp',
    'Recording Options'                                  => 'Inspelningsinställningar',
    'Recording Priority'                                 => 'Inspelningsprioritet',
    'Recording Profile'                                  => 'Inspelningsprofil',
    'Rerun'                                              => 'Repris',
    'Save'                                               => 'Spara',
    'Schedule'                                           => 'Schema',
    'Schedule Options'                                   => 'Schemaläggningsval',
    'Schedule Override'                                  => 'Åsidosätt schemaläggning',
    'Schedule normally.'                                 => 'Schemalägg normalt',
    'Scheduled Recordings'                               => 'Schemalagda inspelningar',
    'Search'                                             => 'Sök',
    'Search Results'                                     => 'Sökresultat',
    'Start Date'                                         => 'Startdatum',
    'Start Early'                                        => 'Börja tidigare',
    'Start Time'                                         => 'Starttid',
    'Subtitle'                                           => 'Undertitel',
    'Subtitle and Description'                           => 'Undertitel och beskrivning',
    'The requested recording schedule has been deleted.' => 'Det begärda inspelningsschemat har tagits bort.',
    'Title'                                              => 'Titel',
    'Transcoder'                                         => '',
    'Unknown'                                            => 'Okänd',
    'Update'                                             => 'Uppdatera',
    'Update Recording Settings'                          => 'Uppdatera inspelningsinställningar',
    'Yes'                                                => 'Ja',
    'airdate'                                            => 'visningsdatum',
    'channum'                                            => 'kanalnummer',
    'description'                                        => 'beskrivning',
    'generic_date'                                       => '%Y-%m-%d',
    'generic_time'                                       => '%H:%M',
    'length'                                             => 'längd',
    'minutes'                                            => 'minuter',
    'recgroup'                                           => 'inspelningsgrupp',
    'rectype-long: always'                               => 'Spela in vilken tid som helst på alla kanaler.',
    'rectype-long: channel'                              => 'Spela in vilken tid som helst på kanal $1.',
    'rectype-long: daily'                                => 'Spela in denna tid varje dag.',
    'rectype-long: dontrec'                              => 'Spela inte in denna specifika visning.',
    'rectype-long: finddaily'                            => 'Spela in en visning av detta program varje dag.',
    'rectype-long: findone'                              => 'Spela in en visning av detta program.',
    'rectype-long: findweekly'                           => 'Spela in en visning av detta program varje vecka.',
    'rectype-long: once'                                 => 'Spela endast in denna visning.',
    'rectype-long: override'                             => 'Spela in denna specifika visning.',
    'rectype-long: weekly'                               => 'Spela in denna tid varje vecka.',
    'rectype: always'                                    => 'Alltid',
    'rectype: channel'                                   => 'Kanal',
    'rectype: daily'                                     => 'Daglig',
    'rectype: dontrec'                                   => 'Spela ej in',
    'rectype: findone'                                   => 'Hitta en',
    'rectype: once'                                      => 'Enstaka',
    'rectype: override'                                  => 'Överskugga',
    'rectype: weekly'                                    => 'Veckovis',
    'subtitle'                                           => 'undertitel',
    'title'                                              => 'titel',
// includes/programs.php
    'recstatus: cancelled'         => 'Denna visning spelades inte in därför att den avbröts manuellt.',
    'recstatus: conflict'          => 'Ett annat program med en högre prioritet kommer att spelas in.',
    'recstatus: currentrecording'  => 'Denna visning kommer inte att spelas in därför att detta avsnitt redan spelats in och fortfarande är tillgängligt i listan över inspelningar.',
    'recstatus: deleted'           => 'Denna visning spelades in men togs bort innan inspelningen var slutförd.',
    'recstatus: earliershowing'    => 'Detta avsnitt kommer att spelas in vid en tidigare tidpunkt istället.',
    'recstatus: force_record'      => 'Denna visning sattes manuellt att spela in.',
    'recstatus: latershowing'      => 'Detta avsnitt kommer att spelas in vid en senare tidpunkt istället.',
    'recstatus: lowdiskspace'      => 'Denna visning spelades inte in därför att det inte fanns tillräckligt med ledigt diskutrymme.',
    'recstatus: manualoverride'    => 'Denna visning sattes manuellt till att inte spela in.',
    'recstatus: overlap'           => 'Denna visning täcks av ett annat inspelningsschema för samma program.',
    'recstatus: previousrecording' => 'Detta avsnitt redan spelats in enligt dubblettkontrollen vald för detta program.',
    'recstatus: recorded'          => 'Denna visning spelades in.',
    'recstatus: recording'         => 'Denna visning spelas in.',
    'recstatus: repeat'            => 'Denna visning är en repris och kommer inte att spelas in.',
    'recstatus: stopped'           => 'Denna visning spelades in men stoppades innan den var färdiginspelad.',
    'recstatus: toomanyrecordings' => 'För många inspelningar av detta program redan gjorts.',
    'recstatus: tunerbusy'         => 'Denna visning spelades inte in därför att TV-kortet redan användes.',
    'recstatus: unknown'           => 'Statusen för denna visning är okänd.',
    'recstatus: willrecord'        => 'Denna visning kommer att spelas in.',
// includes/recording_schedules.php
    'Dup Method'                   => 'Dubblettmetod',
    'Profile'                      => 'Profil',
    'Sub and Desc (Empty matches)' => 'Undertitel & beskrivning',
    'Type'                         => 'Typ',
    'rectype: finddaily'           => 'En per dag',
    'rectype: findweekly'          => 'En per vecka',
// includes/utils.php
    '$1 B'   => '$1 B',
    '$1 GB'  => '$1 GB',
    '$1 KB'  => '$1 KB',
    '$1 MB'  => '$1 MB',
    '$1 TB'  => '$1 TB',
    '$1 hr'  => '$1h',
    '$1 hrs' => '$1h',
// program_detail.php
    'Unknown Program.'            => 'Okänt program.',
    'Unknown Recording Schedule.' => 'Okänt inspelningsschema.',
// search.php
    'Please search for something.' => 'Välj något att söka efter.',
// themes/.../canned_searches.php
    'handy: overview' => 'Denna sida innehåller förberedda komplexa sökningar av programlistorna.',
// themes/.../channel_detail.php
    'Length' => 'Längd',
    'Show'   => 'Program',
    'Time'   => 'Tid',
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
    'Music'               => '',
    'Next'                => '',
    'No Tracks Available' => '',
    'Previous'            => '',
    'Top'                 => '',
    'Track Name'          => '',
    'Unfiltered'          => '',
// themes/.../program_detail.php
    '$1 Rating'                           => 'Rangordning $1',
    'Back to the program listing'         => 'Tillbaka till programlistan',
    'Back to the recording schedules'     => 'Tillbaka till inspelningsschemat',
    'Cast'                                => 'Rollbesättning',
    'Directed by'                         => 'Regi',
    'Don\'t record this program.'         => 'Spela inte in detta program.',
    'Exec. Producer'                      => 'Producent',
    'Find other showings of this program' => 'Hitta andra visningar av detta program',
    'Find showings of this program'       => 'Hitta visningar av detta program',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Gästspel',
    'Hosted by'                           => 'Värd',
    'Inactive'                            => 'Inaktiv',
    'Presented by'                        => 'Presenteras av',
    'Produced by'                         => 'Producerad av',
    'Program Detail'                      => '',
    'TVTome'                              => 'TVTome',
    'What else is on at this time?'       => 'Vad visas mer vid denna tid?',
    'Written by'                          => 'Skriven av',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => 'Just nu visas:  $1',
    'Jump To'                 => 'Gå till',
    'Program Listing'         => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1 avsnitt',
    '$1 episodes'                                         => '$1 avsnitt',
    '$1 recording'                                        => '$1 inspelning',
    '$1 recordings'                                       => '$1 inspelningar',
    'Are you sure you want to delete the following show?' => 'Är du säker på att du vill da bort följande inspelning?',
    'Delete'                                              => 'Radera',
    'Delete + Rerecord'                                   => 'Radera + �terinspela',
    'Show group'                                          => 'Visa grupp',
    'Show recordings'                                     => 'Visa inspelningar',
    'auto-expire'                                         => 'autoradera',
    'file size'                                           => 'filstorlek',
    'has bookmark'                                        => 'bokmärke',
    'has commflag'                                        => 'markerad reklam',
    'has cutlist'                                         => 'klipplista',
    'is editing'                                          => 'redigeras',
    'preview'                                             => 'förhandsvisning',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profilgrupper',
    'Recording profiles' => 'Inspelningsprofiler',
// themes/.../recording_schedules.php
    'Any'                                       => 'Alla',
    'No recording schedules have been defined.' => 'Inga schemalagda inspelningar',
    'channel'                                   => 'kanal',
    'profile'                                   => 'profil',
    'transcoder'                                => '',
    'type'                                      => 'typ',
// themes/.../schedule_manually.php
    'Save Schedule'     => 'Spara schema',
    'Schedule Manually' => '',
// themes/.../scheduled_recordings.php
    'Activate'      => 'Aktivera',
    'Commands'      => 'Kommando',
    'Conflicts'     => 'Konflikter',
    'Deactivated'   => 'Avaktiverad',
    'Default'       => 'Standard',
    'Don\'t Record' => 'Spela ej in',
    'Duplicates'    => 'Dubbletter',
    'Forget Old'    => 'Glöm gammal',
    'Never Record'  => 'Spela aldrig in',
    'Record This'   => 'Spela in',
    'Scheduled'     => 'Schemalagd',
// themes/.../search.php
    'No matches found' => 'Inga matchningar funna',
    'Search for:  $1'  => 'Sök efter:  $1',
// themes/.../settings.php
    'Channels'           => 'Kanaler',
    'Configure'          => 'Konfigurera',
    'Key Bindings'       => 'Knappar',
    'MythWeb Settings'   => 'MythWeb-inställningar',
    'settings: overview' => 'Detta är startsidan för inställningarna. Inte helt komplett, men följande finns för närvarande att välja på: ',
// themes/.../settings_channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'OBS! Genom att ändra dessa inställningar utan att veta vad du gör kan du allvarligt störa MythTVs funktionalitet.',
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
    'recpriority'                                                                                                                        => '',
    'sourceid'                                                                                                                           => '',
    'videofilters'                                                                                                                       => '',
    'visible'                                                                                                                            => '',
// themes/.../settings_keys.php
    'Action'                => '',
    'Configure Keybindings' => '',
    'Context'               => '',
    'Destination'           => '',
    'Edit keybindings on'   => 'Editera knappar på',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'Kanal &quot;Gå till&quot;',
    'Date Formats'                    => 'Datumformat',
    'Guide Settings'                  => 'Guideinställningar',
    'Hour Format'                     => 'Timformat',
    'Language'                        => 'Språk',
    'Listing &quot;Jump to&quot;'     => 'TV-tablå &quot;Gå till&quot;',
    'Listing Time Key'                => 'TV-tablå tid',
    'MythWeb Theme'                   => 'MythWeb-tema',
    'Only display favourite channels' => 'Visa endast favoritkanaler',
    'Reset'                           => 'Återställ',
    'SI Units?'                       => 'SI-enheter?',
    'Scheduled Popup'                 => 'Schemalagd popup',
    'Show descriptions on new line'   => 'Visa beskrivning på ny rad',
    'Status Bar'                      => 'Statusrad',
    'Weather Icons'                   => 'Väderikoner',
    'format help'                     => 'formathjälp',
// themes/.../theme.php
    'Category Legend'                            => 'Kategoriförklaring',
    'Category Type'                              => 'Kategorityp',
    'Edit MythWeb and some MythTV settings.'     => 'Ändra MythWeb och några MythTV-inställningar',
    'Exact Match'                                => 'Exakt matchning',
    'HD Only'                                    => 'Endast HD',
    'Manually Schedule'                          => 'Manuell schemaläggning',
    'MythMusic on the web.'                      => 'MythMusic på webben',
    'MythVideo on the web.'                      => 'MythVideo på webben',
    'MythWeb Weather.'                           => 'MythWeb väder.',
    'Recording Schedules'                        => 'Inspelningsscheman',
    'Search fields'                              => 'Sökfält',
    'Search help'                                => 'Sökhjälp',
    'Search help: movie example'                 => '*** Äventyr',
    'Search help: movie search'                  => 'Filmsökning',
    'Search help: regex example'                 => '/^Alpint/',
    'Search help: regex search'                  => 'Reguljärt uttryck',
    'Search options'                             => 'Sökval',
    'Searches'                                   => 'Sökningar',
    'Settings'                                   => 'Inställningar',
    'TV functions, including recorded programs.' => 'Tv-funktioner, inkl. inspelade program.',
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
// themes/.../weather.php
    ' at '               => ' vid ',
    'Current Conditions' => 'Nuvarande förhållanden',
    'Forecast'           => 'Prognos',
    'Friday'             => 'Fredag',
    'High'               => 'Hög',
    'Humidity'           => 'Luftfuktighet',
    'Last Updated'       => 'Senast uppdaterad',
    'Low'                => 'Låg',
    'Monday'             => 'Måndag',
    'Pressure'           => 'Lufttryck',
    'Radar'              => 'Radar',
    'Saturday'           => 'Lördag',
    'Sunday'             => 'Söndag',
    'Thursday'           => 'Torsdag',
    'Today'              => 'Idag',
    'Tomorrow'           => 'Imorgon',
    'Tuesday'            => 'Tisdag',
    'UV Extreme'         => 'UV-strålning extrem',
    'UV High'            => 'UV-strålning hög',
    'UV Index'           => 'UV-strålning',
    'UV Minimal'         => 'UV-strålning minimal',
    'UV Moderate'        => 'UV-strålning måttlig',
    'Visibility'         => 'Sikt',
    'Weather'            => '',
    'Wednesday'          => 'Onsdag',
    'Wind'               => 'Vind',
    'Wind Chill'         => 'Vindkyleffekt'
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
/* I'll update this when we've got the new Swedish guide-data in a more mature state. */
$Categories = array();
$Categories['Action']         = array('Action',          '\\b(?:action|adven)');
$Categories['Adult']          = array('Adult',           '\\b(?:adult|erot)');
$Categories['Animals']        = array('Djur',            '\\b(?:animal|djur)');
$Categories['Art_Music']      = array('Konst/musik',     '\\b(?:art|dance|musi[ck]|[ck]ultur)');
$Categories['Business']       = array('Affärer/ekonomi','\\b(?:biz|busine|ekonomi|affärer)');
$Categories['Children']       = array('Barnprogram',     '\\b(?:child|animation|kid|tecknat|barn)');
$Categories['Comedy']         = array('Komedi',          '\\b(?:comed|entertain|sitcom|komedi)');
$Categories['Crime_Mystery']  = array('Brott/mysterier', '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Dokumentär',     '\\b(?:documentary|dokumentär)');
$Categories['Drama']          = array('Drama',           '\\b(?:drama)');
$Categories['Educational']    = array('Utbildning',      '\\b(?:edu|interests|utbildning)');
$Categories['Food']           = array('Mat',             '\\b(?:food|cook|matlag|dryck)');
$Categories['Game']           = array('Lek/spel',        '\\b(?:game|spel)');
$Categories['Health_Medical'] = array('Medicin/hälsa',  '\\b(?:health|medic)');
$Categories['History']        = array('Historia',        '\\b(?:histor)');
$Categories['Horror']         = array('Rysare',          '\\b(?:horror|rysare)');
$Categories['HowTo']          = array('Gör-det-själv', '\\b(?:how|home|house|garden|hus|hem|trädgård)');
$Categories['Misc']           = array('Blandat',         '\\b(?:special|variety|info|collect|blandat|nöje)');
$Categories['News']           = array('Nyheter',         '\\b(?:news|nyheter)');
$Categories['Reality']        = array('Dokusåpa',       '\\b(?:reality|dokusåpa)');
$Categories['Romance']        = array('Romantik',        '\\b(?:romance|romantik|kärlek)');
$Categories['SciFi_Fantasy']  = array('Natur/vetenskap', '\\b(?:science|nature|environment|natur|vetenskap)');
$Categories['Science_Nature'] = array('SciFi/fantasy',   '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Shopping']       = array('Shopping',        '\\b(?:shop)');
$Categories['Soaps']          = array('Såpopera',       '\\b(?:soaps|såpopera)');
$Categories['Spiritual']      = array('Andligt',         '\\b(?:spirit|andlig)');
$Categories['Sports']         = array('Sport',           '\\b(?:sport)');
$Categories['Talk']           = array('Talkshow',        '\\b(?:talk)');
$Categories['Travel']         = array('Resor',           '\\b(?:travel|resor)');
$Categories['War']            = array('Krig',            '\\b(?:war|krig)');
$Categories['Western']        = array('Western',         '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Okänd');
$Categories['movie']          = array('Film',            '\\b(?:movie|film)');

?>
