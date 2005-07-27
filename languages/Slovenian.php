<?php
/***                                                                        ***\
    language/Slovenian.php

    Translation hash for Slovenian.
\***                                                                        ***/

// Set the locale to Slovenian
setlocale(LC_ALL, 'si_SI');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 hr'                                              => '$1 ura',
    '$1 hrs'                                             => '$1 ure',
    '$1 min'                                             => '$1 Min',
    '$1 mins'                                            => '$1 Min',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 programi, uporabljeno $2 ($3) od ($4)',
    '$1 to $2'                                           => '$1 do $2',
    'Advanced Options'                                   => 'Dodatne možnosti',
    'Airtime'                                            => 'Čas predvajanja',
    'All recordings'                                     => 'Vsa snemanja',
    'Auto-expire recordings'                             => 'Snemanja avto-preteka',
    'Auto-flag commercials'                              => 'Avto-označi reklame',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'Status Backenda',
    'Cancel this schedule.'                              => 'Prekliči ta plan',
    'Category'                                           => 'Kategorija',
    'Channel'                                            => 'Kanal',
    'Check for duplicates in'                            => 'Preveri za duplikati v',
    'Create Schedule'                                    => 'Ustvari plan snemanja',
    'Current recordings'                                 => 'Trenutna snemanja',
    'Date'                                               => 'Datum',
    'Description'                                        => 'Opis',
    'Details for'                                        => '',
    'Display'                                            => 'Prikaz',
    'Duplicate Check method'                             => 'Metoda preverjanja duplikatov',
    'End Late'                                           => 'Končaj kasneje',
    'Episode'                                            => 'Oddaja',
    'Go'                                                 => 'Pojdi',
    'Hour'                                               => 'Ura',
    'IMDB'                                               => 'IMBD',
    'Inactive'                                           => '',
    'Jump'                                               => 'Skoči',
    'Jump to'                                            => 'Skoči na',
    'Length (min)'                                       => 'Dolžina (min)',
    'Listings'                                           => 'Seznam',
    'No'                                                 => 'Ne',
    'No. of recordings to keep'                          => 'Št. ohranjenih snemanj',
    'None'                                               => 'Nobeno',
    'Notes'                                              => 'Opombe',
    'Only New Episodes'                                  => 'Samo eno oddajo',
    'Original Airdate'                                   => 'Izvirni datum predvajanja',
    'Previous recordings'                                => 'Že posneto',
    'Rating'                                             => 'Ocena',
    'Record new and expire old'                          => 'Snemaj novo in briši staro',
    'Recorded Programs'                                  => 'Posneti programi',
    'Recording Group'                                    => 'Snemalne skupine',
    'Recording Options'                                  => 'Snemalne možnosti',
    'Recording Priority'                                 => 'Snemalne prioritete',
    'Recording Profile'                                  => 'Snemalni profili',
    'Rerun'                                              => 'Ponovno zaženi',
    'Save'                                               => 'Shrani',
    'Schedule'                                           => 'Nastavi snemanje',
    'Schedule Options'                                   => 'Možnosti planiranja',
    'Schedule Override'                                  => 'Prepiši planiranje',
    'Schedule normally.'                                 => 'Normalno planiranje',
    'Scheduled Recordings'                               => 'Snemalni plan',
    'Search'                                             => 'Iskanje',
    'Search Results'                                     => 'Rezultati iskanja',
    'Start Date'                                         => 'Datum začetka',
    'Start Early'                                        => 'Začni prej',
    'Start Time'                                         => 'Čas začetka',
    'Subtitle'                                           => 'Podnaslov',
    'Subtitle and Description'                           => 'Podnaslov in opis',
    'The requested recording schedule has been deleted.' => 'Zahtevani snemalni plan je bil izbrisan',
    'Title'                                              => 'Naslov',
    'Transcoder'                                         => '',
    'Unknown'                                            => 'Neznano',
    'Update'                                             => 'Posodobi',
    'Update Recording Settings'                          => 'Posodobi snemalne nastavitve',
    'Yes'                                                => 'Da',
    'airdate'                                            => 'datum oddajanja',
    'channum'                                            => 'številka kanala',
    'description'                                        => 'opis',
    'generic_date'                                       => '%e.%m.%Y',
    'generic_time'                                       => '%H:%M',
    'length'                                             => 'dolžina',
    'minutes'                                            => 'minute',
    'recgroup'                                           => 'snemalna skupina',
    'rectype-long: always'                               => '',
    'rectype-long: channel'                              => 'Snemaj kadarkoli na kanalu $1.',
    'rectype-long: daily'                                => 'Snemaj ta program v tem času vsak dan.',
    'rectype-long: dontrec'                              => 'Ne snemaj te oddaje.',
    'rectype-long: finddaily'                            => 'Najdi in snemaj to oddajo vsak dan.',
    'rectype-long: findone'                              => 'Najdi in snemaj to oddajo.',
    'rectype-long: findweekly'                           => 'Najdi in snemaj to oddajo vsak teden.',
    'rectype-long: once'                                 => 'Snemaj samo to oddajo.',
    'rectype-long: override'                             => 'Snemaj to posebno oddajo.',
    'rectype-long: weekly'                               => 'Snemaj ta program v tem času vsak teden.',
    'rectype: always'                                    => 'Vedno',
    'rectype: channel'                                   => 'Kanal',
    'rectype: daily'                                     => 'Dnevno',
    'rectype: dontrec'                                   => 'Ne snemaj',
    'rectype: findone'                                   => 'Najdi enkrat',
    'rectype: once'                                      => 'Enkrat',
    'rectype: override'                                  => 'Prepiši (snemanje)',
    'rectype: weekly'                                    => 'tedensko',
    'subtitle'                                           => 'Podnaslov',
    'title'                                              => 'Naslov',
// includes/programs.php
    'recstatus: cancelled'         => 'Bilo je planirano za snemanje, ampak je bilo ročno preklicano.',
    'recstatus: conflict'          => 'Sneman bo drugi program z višjo prioriteto.',
    'recstatus: currentrecording'  => 'Ta oddaja je že bila posneta in je še vedno na voljo v seznamu snemanj.',
    'recstatus: deleted'           => 'Ta oddaja je že bila posneta, ampak je bila izbrisana pred koncem snemanja.',
    'recstatus: earliershowing'    => 'Ta oddaja se bo posnela prej (koliko je nastavljeno).',
    'recstatus: force_record'      => 'Ta oddaja je bila ta trenutek ročno nastavljena za snemanje.',
    'recstatus: latershowing'      => 'Ta oddaja se bo posnela prej (koliko je nastavljeno).',
    'recstatus: lowdiskspace'      => 'Za snemanje te oddaje ni bilo na voljo zadostne količine prostega diska.',
    'recstatus: manualoverride'    => 'Ta oddaja je bila ročno nastavljena, naj se ne posname.',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: overlap'           => 'Prišlo je do konflikta z drugim planom snemanja istega programa.',
    'recstatus: previousrecording' => 'Glede na rezultate duplikatov, je bila ta oddaja že posneta.',
    'recstatus: recorded'          => 'Ta oddaja se je posnela.',
    'recstatus: recording'         => 'Ta oddaja se snema.',
    'recstatus: repeat'            => 'Ta oddaja je posnetek in se ne bo posnela.',
    'recstatus: stopped'           => 'Ta oddaja je že bila posneta, ampak je bil snemanje preklicano.',
    'recstatus: toomanyrecordings' => 'Posnelo se je že preveč posnetkov tega progama.',
    'recstatus: tunerbusy'         => 'Kartica za zajem je že bila v uporabi, kadar bi se naj izvedel ta snemalni plan.',
    'recstatus: unknown'           => 'Status te oddaje je neznan.',
    'recstatus: willrecord'        => 'Ta oddaja se bo posnela.',
// includes/recording_schedules.php
    'Dup Method'                   => 'Metoda duplikatov',
    'Profile'                      => 'Profil',
    'Sub and Desc (Empty matches)' => 'Podnaslov in opis (prazni zadetki)',
    'Type'                         => 'Tip',
    'rectype: finddaily'           => 'Najdi dnevno',
    'rectype: findweekly'          => 'Najdi tedensko',
// includes/utils.php
    '$1 B'  => '',
    '$1 GB' => '',
    '$1 KB' => '',
    '$1 MB' => '',
    '$1 TB' => '',
// program_detail.php
    'Unknown Program.'            => 'Neznani program',
    'Unknown Recording Schedule.' => 'Neznani plan snemanja',
// search.php
    'Please search for something.' => 'Prosim poiščite kaj',
// themes/.../canned_searches.php
    'handy: overview' => 'Ta stran vsebuje v naprej pripravljena kompleksna iskanja seznamov programov.',
// themes/.../channel_detail.php
    'Length' => 'Trajanje',
    'Show'   => 'Oddaja',
    'Time'   => 'Čas',
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
    '$1 Rating'                           => '$1 Ocena',
    'Back to the program listing'         => 'Nazaj na seznam programov',
    'Back to the recording schedules'     => 'Nazaj na planiranje snemanj',
    'Cast'                                => 'Zasedba',
    'Directed by'                         => 'Režiser',
    'Don\'t record this program.'         => 'Ne snemaj tega programa.',
    'Exec. Producer'                      => 'Scenarist',
    'Find other showings of this program' => 'Najdi drugo predvajanje tega programa',
    'Find showings of this program'       => 'Najdi predvajanje tega programa',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Igra še',
    'Hosted by'                           => 'Gostitelj',
    'Presented by'                        => 'Predstavlja',
    'Produced by'                         => 'Producent',
    'Program Detail'                      => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'Kaj je še ob tem času?',
    'Written by'                          => 'Napisal',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => 'Trenutno brskanje:  $1',
    'Jump To'                 => 'Skoči na',
    'Program Listing'         => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1 serija',
    '$1 episodes'                                         => '$1 serije',
    '$1 recording'                                        => '$1 snemanje',
    '$1 recordings'                                       => '$1 snemanja',
    'Are you sure you want to delete the following show?' => 'Ste prepričani, da želite izbrisati to oddajo?',
    'Delete'                                              => 'Briši',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => '',
    'Delete and rerecord $1'                              => '',
    'Show group'                                          => 'Pokaži skupino',
    'Show recordings'                                     => 'Pokaži snemanja',
    'auto-expire'                                         => 'avto-brisanje',
    'file size'                                           => 'velikost datoteke',
    'has bookmark'                                        => 'ima zaznamek',
    'has commflag'                                        => 'ima označene reklame',
    'has cutlist'                                         => 'ima seznam rezov',
    'is editing'                                          => 'se ureja',
    'preview'                                             => 'predogled',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profilne skupine',
    'Recording profiles' => 'Snemalne skupine',
// themes/.../recording_schedules.php
    'Any'                                       => 'Katera koli',
    'No recording schedules have been defined.' => 'Definiran ni bil noben snemalni plan.',
    'channel'                                   => 'kanal',
    'profile'                                   => 'profil',
    'transcoder'                                => '',
    'type'                                      => 'tip',
// themes/.../schedule_manually.php
    'Save Schedule'     => 'Shrani snemalni plan',
    'Schedule Manually' => '',
// themes/.../scheduled_recordings.php
    'Activate'      => 'Aktiviraj',
    'Commands'      => 'Ukazi',
    'Conflicts'     => 'Konflikti',
    'Deactivated'   => 'Deaktiviran',
    'Default'       => 'Privzet',
    'Don\'t Record' => 'Ne snemaj',
    'Duplicates'    => 'Duplikati',
    'Forget Old'    => 'Pozabi stare',
    'Never Record'  => 'Nikoli ne snemaj',
    'Record This'   => 'Posnami to',
    'Scheduled'     => 'Splanirano',
// themes/.../search.php
    'No matches found' => 'Ni zadetkov',
    'Search for:  $1'  => 'Iskanje:  $1',
// themes/.../settings.php
    'Channels'           => 'Kanali',
    'Configure'          => 'Konfiguracija',
    'Key Bindings'       => 'Bližnjice',
    'MythWeb Settings'   => 'MythWeb nastavitve',
    'settings: overview' => 'To je index stran nastavitev...<p>Ni še končana, eventuelno pa bo tudi lepše zgledala.  Trenutno si lahko izberete naslednje:',
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
    'recpriority'                                                                                                                        => '',
    'sourceid'                                                                                                                           => '',
    'videofilters'                                                                                                                       => '',
    'visible'                                                                                                                            => '',
// themes/.../settings_keys.php
    'Action'                => '',
    'Configure Keybindings' => '',
    'Context'               => '',
    'Destination'           => '',
    'Edit keybindings on'   => 'Zamenjaj bližnjico za',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'Kanal &quot;Skoči na&quot;',
    'Date Formats'                    => 'Format datuma',
    'Guide Settings'                  => 'Nastavitve vodiča',
    'Hour Format'                     => 'Format ure',
    'Language'                        => 'Jezik',
    'Listing &quot;Jump to&quot;'     => 'Seznam &quot;Skoči na&quot;',
    'Listing Time Key'                => 'Seznam',
    'MythWeb Theme'                   => 'MythWeb tema',
    'Only display favourite channels' => 'Prikaži samo priljubljene kanale',
    'Reset'                           => 'Resetiraj',
    'SI Units?'                       => 'SI enote',
    'Scheduled Popup'                 => 'Nastavljeni pop-up',
    'Show descriptions on new line'   => 'Opis prikaži v novi vrstici',
    'Status Bar'                      => 'Statusna vrstica',
    'Weather Icons'                   => 'Ikone za vreme',
    'format help'                     => 'format pomoči',
// themes/.../theme.php
    'Category Legend'                            => 'Legenda kategorij',
    'Category Type'                              => 'Tip kategorij',
    'Edit MythWeb and some MythTV settings.'     => 'Uredi MythWeb in nekaj MythTV nastavitev.',
    'Exact Match'                                => 'Točen zadetek',
    'HD Only'                                    => 'Samo HD',
    'Manually Schedule'                          => 'Ročno planiranje',
    'MythMusic on the web.'                      => 'MythMusic na spletu',
    'MythVideo on the web.'                      => 'MythVideo na spletu',
    'MythWeb Weather.'                           => 'MythWeb vreme',
    'Recording Schedules'                        => 'Snemalni plani',
    'Search fields'                              => 'Iskalna polja',
    'Search help'                                => 'Pomoč iskanja',
    'Search help: movie example'                 => '*** 1/2 Adventure',
    'Search help: movie search'                  => 'movie search',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'regex search',
    'Search options'                             => 'Možnosti iskanja',
    'Searches'                                   => 'Iskanja',
    'Settings'                                   => 'Nastavitve',
    'TV functions, including recorded programs.' => 'Funkcije TV, vključno z posnetimi programi.',
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
    ' at '               => ' ob ',
    'Current Conditions' => 'Trenutni pogoji',
    'Forecast'           => 'Napoved',
    'Friday'             => 'Petek',
    'High'               => 'Visoka',
    'Humidity'           => 'Vlažnost',
    'Last Updated'       => 'Zadnjič posodobljeno',
    'Low'                => 'Nizka',
    'Monday'             => 'Ponedeljek',
    'Pressure'           => 'Tlak',
    'Radar'              => 'Radar',
    'Saturday'           => 'Sobota',
    'Sunday'             => 'Nedelja',
    'Thursday'           => 'Četrtek',
    'Today'              => 'Danes',
    'Tomorrow'           => 'Jutri',
    'Tuesday'            => 'Torek',
    'UV Extreme'         => 'UV ektremen',
    'UV High'            => 'UV visok',
    'UV Index'           => 'UV index',
    'UV Minimal'         => 'UV minimalni',
    'UV Moderate'        => 'UV srednji',
    'Visibility'         => 'Vidljivost',
    'Weather'            => '',
    'Wednesday'          => 'Sreda',
    'Wind'               => 'Veter',
    'Wind Chill'         => 'Temperatura zraka'
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
$Categories['Action']         = array('Akcija',           '\\b(?:akcija|adven)');
$Categories['Adult']          = array('Odrasli',            '\\b(?:adult|erotika)');
$Categories['Animals']        = array('Živali',          '\\b(?:živali|tiere)');
$Categories['Art_Music']      = array('Umetnost_Glasba',        '\\b(?:art|dance|music|cultur|glasba|kultura|ples|umetnost)');
$Categories['Business']       = array('Poslovno',         '\\b(?:biz|busine|poslo)');
$Categories['Children']       = array('Otroška',         '\\b(?:child|infan|animation|otrok)');
$Categories['Comedy']         = array('Komedja',           '\\b(?:comed|entertain|sitcom|komedija)');
$Categories['Crime_Mystery']  = array('Kriminalka/Grozljivka',  '\\b(?:crim|myster|krimi|grozl)');
$Categories['Documentary']    = array('Dokumentarec',      '\\b(?:doc|dok)');
$Categories['Drama']          = array('Drama',            '\\b(?:drama)');
$Categories['Educational']    = array('Izobraževanje',      '\\b(?:edu|interests|izobraž)');
$Categories['Food']           = array('Hrana',             '\\b(?:food|cook|drink|pijača|hrana)');
$Categories['Game']           = array('Igre',             '\\b(?:game|igr)');
$Categories['Health_Medical'] = array('Zdravje/Medicina', '\\b(?:health|medic|medicina)');
$Categories['History']        = array('Zgodovina',          '\\b(?:hist|zgodovin)');
$Categories['Horror']         = array('Grozljivka',           '\\b(?:horror|grozlj)');
$Categories['HowTo']          = array('Kako',            '\\b(?:how|home|house|garden|kako|hiša|vrt|dom)');
$Categories['Misc']           = array('Drugo',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Poročila',             '\\b(?:news|current|trenutno|poročila)');
$Categories['Reality']        = array('Realno',          '\\b(?:realit)');
$Categories['Romance']        = array('Romanca',          '\\b(?:romanc)');
$Categories['SciFi_Fantasy']  = array('ZnanFant/Fantastika',  '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Science_Nature'] = array('Znanost/Narava', '\\b(?:science|nature|environment|narava|okolje|znanost)');
$Categories['Shopping']       = array('Prodaja',         '\\b(?:shop|prodaja)');
$Categories['Soaps']          = array('Telenovela',            '\\b(?:soaps|španske|tele)');
$Categories['Spiritual']      = array('Duhovno',        '\\b(?:spirit|relig|religija)');
$Categories['Sports']         = array('Šport',           '\\b(?:sport)');
$Categories['Talk']           = array('Debate',             '\\b(?:talk|govor|debat)');
$Categories['Travel']         = array('Potovanja',           '\\b(?:travel|potovanja)');
$Categories['War']            = array('Vojna',              '\\b(?:war|vojna)');
$Categories['Western']        = array('Vestern',          '\\b(?:west|zahod)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Neznano');
$Categories['movie']          = array('Film'  );

?>
