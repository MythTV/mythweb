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
    'airdate'                   => 'visningsdatum',
    'channum'                   => 'kanalnummer',
    'description'               => 'beskrivning',
    'length'                    => 'längd',
    'recgroup'                  => 'inspelningsgrupp',
    'rectype-long: always'      => 'Spela in vilken tid som helst på alla kanaler',
    'rectype-long: channel'     => 'Spela in vilken tid som helst på denna kanal',
    'rectype-long: daily'       => 'Spela in denna tid varje dag',
    'rectype-long: findone'     => 'Spela in en visning av detta program',
    'rectype-long: once'        => 'Spela endast in denna visning',
    'rectype-long: weekly'      => 'Spela in denna tid varje vecka',
    'subtitle'                  => 'undertitel',
    'title'                     => 'titel',
// includes/init.php
    'generic_date' => '%Y-%m-%d',
    'generic_time' => '%H:%M',
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
    'recstatus: repeat'            => '',
    'recstatus: stopped'           => 'Denna visning spelades in men stoppades innan den var färdiginspelad.',
    'recstatus: toomanyrecordings' => 'För många inspelningar av detta program redan gjorts.',
    'recstatus: tunerbusy'         => 'Denna visning spelades inte in därför att TV-kortet redan användes.',
    'recstatus: unknown'           => 'Statusen för denna visning är okänd.',
    'recstatus: willrecord'        => 'Denna visning kommer att spelas in.',
// includes/recordings.php
    'rectype: always'   => 'Alltid',
    'rectype: channel'  => 'Kanal',
    'rectype: daily'    => 'Daglig',
    'rectype: dontrec'  => 'Spela ej in',
    'rectype: findone'  => 'Hitta en',
    'rectype: once'     => 'Enstaka',
    'rectype: override' => 'Överskugga',
    'rectype: weekly'   => 'Veckovis',
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
    'Only New Episodes'                   => '',
    'TVTome'                              => 'TVTime',
    'What else is on at this time?'       => 'Vad visas mer vid denna tid?',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => 'Just nu visas:  $1',
    'Hour'                    => 'Timme',
    'Jump'                    => 'Gå',
    'Jump To'                 => 'Gå till',
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
    'file size'                                           => 'filstorlek',
    'has bookmark'                                        => 'bokmärke',
    'has commflag'                                        => 'markerad reklam',
    'has cutlist'                                         => 'klipplista',
    'is editing'                                          => 'editeras',
    'preview'                                             => 'förhandsvisning',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profilgrupper',
    'Recording profiles' => 'Inspelningsprofiler',
// themes/.../recording_schedules.php
    'Any'                          => 'Alla',
    'Dup Method'                   => 'Dublettmetod',
    'Sub and Desc (Empty matches)' => 'Undertitel & beskrivning',
    'Type'                         => 'Typ',
    'profile'                      => 'Profil',
    'type'                         => 'Typ',
// themes/.../schedule_manually.php
    'Channel'      => 'Kanal',
    'Length (min)' => 'Längd (min)',
    'Start Date'   => 'Startdatum',
    'Start Time'   => 'Starttid',
// themes/.../scheduled_recordings.php
    'Activate'      => 'Aktivera',
    'Commands'      => 'Kommando',
    'Conflicts'     => 'Konflikter',
    'Deactivated'   => 'Avaktiverad',
    'Default'       => 'Standard',
    'Display'       => 'Visning',
    'Don\'t Record' => 'Spela ej in',
    'Duplicates'    => 'Dubletter',
    'Forget Old'    => 'Glöm gammal',
    'Never Record'  => 'Spela aldrig in',
    'Record This'   => 'Spela in',
    'Scheduled'     => 'Schemalagd',
// themes/.../search.php
    'Category Type'    => 'Kategorityp',
    'Exact Match'      => 'Exakt matchning',
    'No matches found' => 'Inga matchningar funna',
// themes/.../settings.php
    'Channels'           => 'Kanaler',
    'Configure'          => 'Konfigurera',
    'Key Bindings'       => 'Knappar',
    'MythWeb Settings'   => 'MythWeb-inställningar',
    'settings: overview' => 'Detta är startsidan för inställningarna. Inte helt komplett, men följande finns för närvarande att välja på: ',
// themes/.../settings_channels.php
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'OBS! Genom att ändra dessa inställningar utan att veta vad du gör kan du allvarligt störa MythTVs funktionalitet.',
// themes/.../settings_keys.php
    'Edit keybindings on' => 'Editera knappar på',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'   => 'Kanal &quot;Gå till&quot;',
    'Date Formats'                  => 'Datumformat',
    'Hour Format'                   => 'Timformat',
    'Language'                      => 'Språk',
    'Listing &quot;Jump to&quot;'   => 'TV-tablå &quot;Gå till&quot;',
    'Listing Time Key'              => 'TV-tablå tid',
    'MythWeb Theme'                 => 'MythWeb-tema',
    'Reset'                         => 'Återställ',
    'Save'                          => 'Spara',
    'Scheduled Popup'               => 'Schemalagd popup',
    'Search Results'                => 'Sökresultat',
    'Show descriptions on new line' => 'Visa beskrivning på ny rad',
    'Status Bar'                    => 'Statusrad',
    'format help'                   => 'formathjälp',
// themes/.../theme.php
    'Backend Status'      => 'Systemstatus',
    'Category Legend'     => 'Kategoriförklaring',
    'Favorites'           => 'Favoriter',
    'Go To'               => 'Gå till',
    'Listings'            => 'TV-tablåer',
    'Manually Schedule'   => 'Manuell schemaläggning',
    'Movies'              => 'Filmer',
    'Recording Schedules' => 'Inspelningsscheman',
    'Settings'            => 'Inställningar',
    'advanced'            => 'avancerad',
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
$Categories['Animals']        = array('Djur',            '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Konst/musik',     '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)');
$Categories['Business']       = array('Affärer/ekonomi', '\\b(?:biz|busine)');
$Categories['Children']       = array('Barnprogram',     '\\b(?:child|kin?d|infan|animation)');
$Categories['Comedy']         = array('Komedi',          '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Brott/mysterier', '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Dokumentär',      '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',           '\\b(?:drama)');
$Categories['Educational']    = array('Utbildning',      '\\b(?:edu|bildung|interests)');
$Categories['Food']           = array('Mat',             '\\b(?:food|cook|essen|[dt]rink)');
$Categories['Game']           = array('Lek/spel',        '\\b(?:game|spiele)');
$Categories['Health_Medical'] = array('Medicin/hÃ€lsa',  '\\b(?:health|medic|gesundheit)');
$Categories['History']        = array('Historia',        '\\b(?:hist|geschichte)');
$Categories['Horror']         = array('Rysare',          '\\b(?:horror)');
$Categories['HowTo']          = array('Gör-det-själv',   '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Blandat',         '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nyheter',         '\\b(?:news|nyheter|aktuellt|rapport|(VÃ€|Ã)stnytt)');
$Categories['Reality']        = array('Dokusåpa',        '\\b(?:reality)');
$Categories['Romance']        = array('Romantik',        '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Natur/vetenskap', '\\b(?:science|nature|environment|wissenschaft)');
$Categories['Science_Nature'] = array('SciFi/fantasy',   '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Shopping']       = array('Shopping',        '\\b(?:shop)');
$Categories['Soaps']          = array('Såpopera',        '\\b(?:soaps)');
$Categories['Spiritual']      = array('Andligt',         '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',           '\\b(?:sport|deportes|futbol)');
$Categories['Talk']           = array('Talkshow',        '\\b(?:talk)');
$Categories['Travel']         = array('Resor',           '\\b(?:travel|reisen)');
$Categories['War']            = array('Krig',            '\\b(?:war|krieg)');
$Categories['Western']        = array('Western',         '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Okänd');
$Categories['movie']          = array('Film');

?>
