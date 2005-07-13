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
    ' at '                                                                                                                               => ' ob ',
    '$1 B'                                                                                                                               => '',
    '$1 GB'                                                                                                                              => '',
    '$1 KB'                                                                                                                              => '',
    '$1 MB'                                                                                                                              => '',
    '$1 Rating'                                                                                                                          => '$1 Ocena',
    '$1 TB'                                                                                                                              => '',
    '$1 episode'                                                                                                                         => '$1 serija',
    '$1 episodes'                                                                                                                        => '$1 serije',
    '$1 hr'                                                                                                                              => '$1 ura',
    '$1 hrs'                                                                                                                             => '$1 ure',
    '$1 min'                                                                                                                             => '$1 Min',
    '$1 mins'                                                                                                                            => '$1 Min',
    '$1 programs, using $2 ($3) out of $4.'                                                                                              => '$1 programi, uporabljeno $2 ($3) od ($4)',
    '$1 recording'                                                                                                                       => '$1 snemanje',
    '$1 recordings'                                                                                                                      => '$1 snemanja',
    '$1 to $2'                                                                                                                           => '$1 do $2',
    'Activate'                                                                                                                           => 'Aktiviraj',
    'Advanced Options'                                                                                                                   => 'Dodatne možnosti',
    'Airtime'                                                                                                                            => 'Čas predvajanja',
    'All recordings'                                                                                                                     => 'Vsa snemanja',
    'Any'                                                                                                                                => 'Katera koli',
    'Are you sure you want to delete the following show?'                                                                                => 'Ste prepričani, da želite izbrisati to oddajo?',
    'Auto-expire recordings'                                                                                                             => 'Snemanja avto-preteka',
    'Auto-flag commercials'                                                                                                              => 'Avto-označi reklame',
    'Auto-transcode'                                                                                                                     => '',
    'Back to the program listing'                                                                                                        => 'Nazaj na seznam programov',
    'Back to the recording schedules'                                                                                                    => 'Nazaj na planiranje snemanj',
    'Backend Status'                                                                                                                     => 'Status Backenda',
    'Cancel this schedule.'                                                                                                              => 'Prekliči ta plan',
    'Cast'                                                                                                                               => 'Zasedba',
    'Category'                                                                                                                           => 'Kategorija',
    'Category Legend'                                                                                                                    => 'Legenda kategorij',
    'Category Type'                                                                                                                      => 'Tip kategorij',
    'Channel'                                                                                                                            => 'Kanal',
    'Channel &quot;Jump to&quot;'                                                                                                        => 'Kanal &quot;Skoči na&quot;',
    'Channels'                                                                                                                           => 'Kanali',
    'Check for duplicates in'                                                                                                            => 'Preveri za duplikati v',
    'Commands'                                                                                                                           => 'Ukazi',
    'Configure'                                                                                                                          => 'Konfiguracija',
    'Conflicts'                                                                                                                          => 'Konflikti',
    'Create Schedule'                                                                                                                    => 'Ustvari plan snemanja',
    'Current Conditions'                                                                                                                 => 'Trenutni pogoji',
    'Current recordings'                                                                                                                 => 'Trenutna snemanja',
    'Currently Browsing:  $1'                                                                                                            => 'Trenutno brskanje:  $1',
    'Date'                                                                                                                               => 'Datum',
    'Date Formats'                                                                                                                       => 'Format datuma',
    'Deactivated'                                                                                                                        => 'Deaktiviran',
    'Default'                                                                                                                            => 'Privzet',
    'Delete'                                                                                                                             => 'Briši',
    'Delete + Rerecord'                                                                                                                  => '',
    'Description'                                                                                                                        => 'Opis',
    'Directed by'                                                                                                                        => 'Režiser',
    'Display'                                                                                                                            => 'Prikaz',
    'Don\'t Record'                                                                                                                      => 'Ne snemaj',
    'Don\'t record this program.'                                                                                                        => 'Ne snemaj tega programa.',
    'Dup Method'                                                                                                                         => 'Metoda duplikatov',
    'Duplicate Check method'                                                                                                             => 'Metoda preverjanja duplikatov',
    'Duplicates'                                                                                                                         => 'Duplikati',
    'Edit MythWeb and some MythTV settings.'                                                                                             => 'Uredi MythWeb in nekaj MythTV nastavitev.',
    'Edit keybindings on'                                                                                                                => 'Zamenjaj bližnjico za',
    'End Late'                                                                                                                           => 'Končaj kasneje',
    'Episode'                                                                                                                            => 'Oddaja',
    'Exact Match'                                                                                                                        => 'Točen zadetek',
    'Exec. Producer'                                                                                                                     => 'Scenarist',
    'Find other showings of this program'                                                                                                => 'Najdi drugo predvajanje tega programa',
    'Find showings of this program'                                                                                                      => 'Najdi predvajanje tega programa',
    'Forecast'                                                                                                                           => 'Napoved',
    'Forget Old'                                                                                                                         => 'Pozabi stare',
    'Friday'                                                                                                                             => 'Petek',
    'Go'                                                                                                                                 => 'Pojdi',
    'Google'                                                                                                                             => 'Google',
    'Guest Starring'                                                                                                                     => 'Igra še',
    'Guide Settings'                                                                                                                     => 'Nastavitve vodiča',
    'HD Only'                                                                                                                            => 'Samo HD',
    'High'                                                                                                                               => 'Visoka',
    'Hosted by'                                                                                                                          => 'Gostitelj',
    'Hour'                                                                                                                               => 'Ura',
    'Hour Format'                                                                                                                        => 'Format ure',
    'Humidity'                                                                                                                           => 'Vlažnost',
    'IMDB'                                                                                                                               => 'IMBD',
    'Inactive'                                                                                                                           => '',
    'Jump'                                                                                                                               => 'Skoči',
    'Jump To'                                                                                                                            => 'Skoči na',
    'Jump to'                                                                                                                            => 'Skoči na',
    'Key Bindings'                                                                                                                       => 'Bližnjice',
    'Language'                                                                                                                           => 'Jezik',
    'Last Updated'                                                                                                                       => 'Zadnjič posodobljeno',
    'Length'                                                                                                                             => 'Trajanje',
    'Length (min)'                                                                                                                       => 'Dolžina (min)',
    'Listing &quot;Jump to&quot;'                                                                                                        => 'Seznam &quot;Skoči na&quot;',
    'Listing Time Key'                                                                                                                   => 'Seznam',
    'Listings'                                                                                                                           => 'Seznam',
    'Low'                                                                                                                                => 'Nizka',
    'Manually Schedule'                                                                                                                  => 'Ročno planiranje',
    'Monday'                                                                                                                             => 'Ponedeljek',
    'MythMusic on the web.'                                                                                                              => 'MythMusic na spletu',
    'MythVideo on the web.'                                                                                                              => 'MythVideo na spletu',
    'MythWeb Settings'                                                                                                                   => 'MythWeb nastavitve',
    'MythWeb Theme'                                                                                                                      => 'MythWeb tema',
    'MythWeb Weather.'                                                                                                                   => 'MythWeb vreme',
    'Never Record'                                                                                                                       => 'Nikoli ne snemaj',
    'No'                                                                                                                                 => 'Ne',
    'No matches found'                                                                                                                   => 'Ni zadetkov',
    'No recording schedules have been defined.'                                                                                          => 'Definiran ni bil noben snemalni plan.',
    'No. of recordings to keep'                                                                                                          => 'Št. ohranjenih snemanj',
    'None'                                                                                                                               => 'Nobeno',
    'Notes'                                                                                                                              => 'Opombe',
    'Only New Episodes'                                                                                                                  => 'Samo eno oddajo',
    'Only display favourite channels'                                                                                                    => 'Prikaži samo priljubljene kanale',
    'Original Airdate'                                                                                                                   => 'Izvirni datum predvajanja',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => '',
    'Please search for something.'                                                                                                       => 'Prosim poiščite kaj',
    'Presented by'                                                                                                                       => 'Predstavlja',
    'Pressure'                                                                                                                           => 'Tlak',
    'Previous recordings'                                                                                                                => 'Že posneto',
    'Produced by'                                                                                                                        => 'Producent',
    'Profile'                                                                                                                            => 'Profil',
    'Profile Groups'                                                                                                                     => 'Profilne skupine',
    'Radar'                                                                                                                              => 'Radar',
    'Rating'                                                                                                                             => 'Ocena',
    'Record This'                                                                                                                        => 'Posnami to',
    'Record new and expire old'                                                                                                          => 'Snemaj novo in briši staro',
    'Recorded Programs'                                                                                                                  => 'Posneti programi',
    'Recording Group'                                                                                                                    => 'Snemalne skupine',
    'Recording Options'                                                                                                                  => 'Snemalne možnosti',
    'Recording Priority'                                                                                                                 => 'Snemalne prioritete',
    'Recording Profile'                                                                                                                  => 'Snemalni profili',
    'Recording Schedules'                                                                                                                => 'Snemalni plani',
    'Recording profiles'                                                                                                                 => 'Snemalne skupine',
    'Rerun'                                                                                                                              => 'Ponovno zaženi',
    'Reset'                                                                                                                              => 'Resetiraj',
    'SI Units?'                                                                                                                          => 'SI enote',
    'Saturday'                                                                                                                           => 'Sobota',
    'Save'                                                                                                                               => 'Shrani',
    'Save Schedule'                                                                                                                      => 'Shrani snemalni plan',
    'Schedule'                                                                                                                           => 'Nastavi snemanje',
    'Schedule Options'                                                                                                                   => 'Možnosti planiranja',
    'Schedule Override'                                                                                                                  => 'Prepiši planiranje',
    'Schedule normally.'                                                                                                                 => 'Normalno planiranje',
    'Scheduled'                                                                                                                          => 'Splanirano',
    'Scheduled Popup'                                                                                                                    => 'Nastavljeni pop-up',
    'Scheduled Recordings'                                                                                                               => 'Snemalni plan',
    'Search'                                                                                                                             => 'Iskanje',
    'Search Results'                                                                                                                     => 'Rezultati iskanja',
    'Search fields'                                                                                                                      => 'Iskalna polja',
    'Search for:  $1'                                                                                                                    => 'Iskanje:  $1',
    'Search help'                                                                                                                        => 'Pomoč iskanja',
    'Search help: movie example'                                                                                                         => '*** 1/2 Adventure',
    'Search help: movie search'                                                                                                          => 'movie search',
    'Search help: regex example'                                                                                                         => '/^Good Eats/',
    'Search help: regex search'                                                                                                          => 'regex search',
    'Search options'                                                                                                                     => 'Možnosti iskanja',
    'Searches'                                                                                                                           => 'Iskanja',
    'Settings'                                                                                                                           => 'Nastavitve',
    'Show'                                                                                                                               => 'Oddaja',
    'Show descriptions on new line'                                                                                                      => 'Opis prikaži v novi vrstici',
    'Show group'                                                                                                                         => 'Pokaži skupino',
    'Show recordings'                                                                                                                    => 'Pokaži snemanja',
    'Start Date'                                                                                                                         => 'Datum začetka',
    'Start Early'                                                                                                                        => 'Začni prej',
    'Start Time'                                                                                                                         => 'Čas začetka',
    'Status Bar'                                                                                                                         => 'Statusna vrstica',
    'Sub and Desc (Empty matches)'                                                                                                       => 'Podnaslov in opis (prazni zadetki)',
    'Subtitle'                                                                                                                           => 'Podnaslov',
    'Subtitle and Description'                                                                                                           => 'Podnaslov in opis',
    'Sunday'                                                                                                                             => 'Nedelja',
    'TV functions, including recorded programs.'                                                                                         => 'Funkcije TV, vključno z posnetimi programi.',
    'TVTome'                                                                                                                             => '',
    'The requested recording schedule has been deleted.'                                                                                 => 'Zahtevani snemalni plan je bil izbrisan',
    'Thursday'                                                                                                                           => 'Četrtek',
    'Time'                                                                                                                               => 'Čas',
    'Title'                                                                                                                              => 'Naslov',
    'Today'                                                                                                                              => 'Danes',
    'Tomorrow'                                                                                                                           => 'Jutri',
    'Transcoder'                                                                                                                         => '',
    'Tuesday'                                                                                                                            => 'Torek',
    'Type'                                                                                                                               => 'Tip',
    'UV Extreme'                                                                                                                         => 'UV ektremen',
    'UV High'                                                                                                                            => 'UV visok',
    'UV Index'                                                                                                                           => 'UV index',
    'UV Minimal'                                                                                                                         => 'UV minimalni',
    'UV Moderate'                                                                                                                        => 'UV srednji',
    'Unknown'                                                                                                                            => 'Neznano',
    'Unknown Program.'                                                                                                                   => 'Neznani program',
    'Unknown Recording Schedule.'                                                                                                        => 'Neznani plan snemanja',
    'Update'                                                                                                                             => 'Posodobi',
    'Update Recording Settings'                                                                                                          => 'Posodobi snemalne nastavitve',
    'Visibility'                                                                                                                         => 'Vidljivost',
    'Weather Icons'                                                                                                                      => 'Ikone za vreme',
    'Wednesday'                                                                                                                          => 'Sreda',
    'What else is on at this time?'                                                                                                      => 'Kaj je še ob tem času?',
    'Wind'                                                                                                                               => 'Veter',
    'Wind Chill'                                                                                                                         => 'Temperatura zraka',
    'Written by'                                                                                                                         => 'Napisal',
    'Yes'                                                                                                                                => 'Da',
    'airdate'                                                                                                                            => 'datum oddajanja',
    'auto-expire'                                                                                                                        => 'avto-brisanje',
    'channel'                                                                                                                            => 'kanal',
    'channum'                                                                                                                            => 'številka kanala',
    'description'                                                                                                                        => 'opis',
    'file size'                                                                                                                          => 'velikost datoteke',
    'format help'                                                                                                                        => 'format pomoči',
    'generic_date'                                                                                                                       => '%e.%m.%Y',
    'generic_time'                                                                                                                       => '%H:%M',
    'handy: overview'                                                                                                                    => 'Ta stran vsebuje v naprej pripravljena kompleksna iskanja seznamov programov.',
    'has bookmark'                                                                                                                       => 'ima zaznamek',
    'has commflag'                                                                                                                       => 'ima označene reklame',
    'has cutlist'                                                                                                                        => 'ima seznam rezov',
    'is editing'                                                                                                                         => 'se ureja',
    'length'                                                                                                                             => 'dolžina',
    'minutes'                                                                                                                            => 'minute',
    'preview'                                                                                                                            => 'predogled',
    'profile'                                                                                                                            => 'profil',
    'recgroup'                                                                                                                           => 'snemalna skupina',
    'recstatus: cancelled'                                                                                                               => 'Bilo je planirano za snemanje, ampak je bilo ročno preklicano.',
    'recstatus: conflict'                                                                                                                => 'Sneman bo drugi program z višjo prioriteto.',
    'recstatus: currentrecording'                                                                                                        => 'Ta oddaja je že bila posneta in je še vedno na voljo v seznamu snemanj.',
    'recstatus: deleted'                                                                                                                 => 'Ta oddaja je že bila posneta, ampak je bila izbrisana pred koncem snemanja.',
    'recstatus: earliershowing'                                                                                                          => 'Ta oddaja se bo posnela prej (koliko je nastavljeno).',
    'recstatus: force_record'                                                                                                            => 'Ta oddaja je bila ta trenutek ročno nastavljena za snemanje.',
    'recstatus: latershowing'                                                                                                            => 'Ta oddaja se bo posnela prej (koliko je nastavljeno).',
    'recstatus: lowdiskspace'                                                                                                            => 'Za snemanje te oddaje ni bilo na voljo zadostne količine prostega diska.',
    'recstatus: manualoverride'                                                                                                          => 'Ta oddaja je bila ročno nastavljena, naj se ne posname.',
    'recstatus: overlap'                                                                                                                 => 'Prišlo je do konflikta z drugim planom snemanja istega programa.',
    'recstatus: previousrecording'                                                                                                       => 'Glede na rezultate duplikatov, je bila ta oddaja že posneta.',
    'recstatus: recorded'                                                                                                                => 'Ta oddaja se je posnela.',
    'recstatus: recording'                                                                                                               => 'Ta oddaja se snema.',
    'recstatus: repeat'                                                                                                                  => 'Ta oddaja je posnetek in se ne bo posnela.',
    'recstatus: stopped'                                                                                                                 => 'Ta oddaja je že bila posneta, ampak je bil snemanje preklicano.',
    'recstatus: toomanyrecordings'                                                                                                       => 'Posnelo se je že preveč posnetkov tega progama.',
    'recstatus: tunerbusy'                                                                                                               => 'Kartica za zajem je že bila v uporabi, kadar bi se naj izvedel ta snemalni plan.',
    'recstatus: unknown'                                                                                                                 => 'Status te oddaje je neznan.',
    'recstatus: willrecord'                                                                                                              => 'Ta oddaja se bo posnela.',
    'rectype-long: always'                                                                                                               => '',
    'rectype-long: channel'                                                                                                              => 'Snemaj kadarkoli na kanalu $1.',
    'rectype-long: daily'                                                                                                                => 'Snemaj ta program v tem času vsak dan.',
    'rectype-long: dontrec'                                                                                                              => 'Ne snemaj te oddaje.',
    'rectype-long: finddaily'                                                                                                            => 'Najdi in snemaj to oddajo vsak dan.',
    'rectype-long: findone'                                                                                                              => 'Najdi in snemaj to oddajo.',
    'rectype-long: findweekly'                                                                                                           => 'Najdi in snemaj to oddajo vsak teden.',
    'rectype-long: once'                                                                                                                 => 'Snemaj samo to oddajo.',
    'rectype-long: override'                                                                                                             => 'Snemaj to posebno oddajo.',
    'rectype-long: weekly'                                                                                                               => 'Snemaj ta program v tem času vsak teden.',
    'rectype: always'                                                                                                                    => 'Vedno',
    'rectype: channel'                                                                                                                   => 'Kanal',
    'rectype: daily'                                                                                                                     => 'Dnevno',
    'rectype: dontrec'                                                                                                                   => 'Ne snemaj',
    'rectype: finddaily'                                                                                                                 => 'Najdi dnevno',
    'rectype: findone'                                                                                                                   => 'Najdi enkrat',
    'rectype: findweekly'                                                                                                                => 'Najdi tedensko',
    'rectype: once'                                                                                                                      => 'Enkrat',
    'rectype: override'                                                                                                                  => 'Prepiši (snemanje)',
    'rectype: weekly'                                                                                                                    => 'tedensko',
    'settings: overview'                                                                                                                 => 'To je index stran nastavitev...<p>Ni še končana, eventuelno pa bo tudi lepše zgledala.  Trenutno si lahko izberete naslednje:',
    'subtitle'                                                                                                                           => 'Podnaslov',
    'title'                                                                                                                              => 'Naslov',
    'type'                                                                                                                               => 'tip',
// themes/.../recording_schedules.php
    'transcoder' => ''
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
