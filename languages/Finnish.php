<?php
/*
 *  $Date$
 *  $Revision$
 *  $Author$
 *
 *  languages/Finnish.php
 *
 *    Translation hash for Finnish.
 *
/*/

// Set the locale
setlocale(LC_ALL, 'fi_FI.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 hr'                                              => '$1 tunti',
    '$1 hrs'                                             => '$1 tuntia',
    '$1 min'                                             => '$1 minuutti',
    '$1 mins'                                            => '$1 minuuttia',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 ohjelmaa, k�ytt�� $2 ($3) $4:st�.',
    '$1 to $2'                                           => '$1 - $2',
    'Advanced Options'                                   => 'Edistyneet Valinnat',
    'Airtime'                                            => 'Lähetysaika',
    'All recordings'                                     => 'Kaikki nauhoitukset',
    'Auto-expire recordings'                             => 'Aut. vanheneminen',
    'Auto-flag commercials'                              => 'Aut. mainosten merkkaus',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'Palvelimen Tila',
    'Cancel this schedule.'                              => 'Peruuta nauhoitus',
    'Category'                                           => 'Kategoria',
    'Channel'                                            => 'Kanava',
    'Check for duplicates in'                            => 'Tarkista kaksoiskappaleet',
    'Create Schedule'                                    => 'Ajoita Nauhoitus',
    'Current recordings'                                 => 'Nykyiset nauhoitukset',
    'Date'                                               => 'Aika',
    'Description'                                        => 'Kuvaus',
    'Details for'                                        => '',
    'Display'                                            => 'Tulosta',
    'Duplicate Check method'                             => 'Kaksoiskapp. Tarkistus',
    'End Late'                                           => 'Lopeta Myöhemmin',
    'Episode'                                            => 'Jakso',
    'Go'                                                 => 'Mene',
    'Hour'                                               => 'Tunti',
    'IMDB'                                               => 'Internet MDB',
    'Inactive'                                           => 'Ei aktiivinen',
    'Jump'                                               => 'Hyppäys',
    'Jump to'                                            => 'Hyppää',
    'Length (min)'                                       => 'Pituus (min)',
    'Listings'                                           => 'Listaus',
    'No'                                                 => 'Ei',
    'No. of recordings to keep'                          => 'N:o nauhoituksia pidettäväksi',
    'None'                                               => 'Ei Mikään',
    'Notes'                                              => 'Viesti',
    'Only New Episodes'                                  => 'Vain Uudet Jaksot',
    'Original Airdate'                                   => 'Vuosi',
    'Previous recordings'                                => 'Aiemmat nauhoitukset',
    'Rating'                                             => 'Arvostelu',
    'Record new and expire old'                          => 'Nauhoita uusi ja poista vanha',
    'Recorded Programs'                                  => 'Nauhoitetut Ohjelmat',
    'Recording Group'                                    => 'Nauhoitusryhmä',
    'Recording Options'                                  => 'Nauhoitusvalinnat',
    'Recording Priority'                                 => 'Nauhoituksen Prioriteetti',
    'Recording Profile'                                  => 'Nauhoitusprofiili',
    'Rerun'                                              => 'Tee uudelleen',
    'Save'                                               => 'Tallenna?',
    'Schedule'                                           => 'Ajoitus',
    'Schedule Options'                                   => 'Ajoitusvalinnat',
    'Schedule Override'                                  => 'Ajoituksen Syrjäytys',
    'Schedule normally.'                                 => 'Ajoita normaalisti',
    'Scheduled Recordings'                               => 'Ajoitetut Nauhoitukset',
    'Search'                                             => 'Etsi',
    'Search Results'                                     => 'Etsinnän Tulokset',
    'Start Date'                                         => 'Päivämäärä',
    'Start Early'                                        => 'Aloita Aiemmin',
    'Start Time'                                         => 'Aloitusaika',
    'Subtitle'                                           => 'Jakson Nimi',
    'Subtitle and Description'                           => 'Jakson Kuvaus',
    'The requested recording schedule has been deleted.' => 'Ajoitettu nauhoitus on poistettu',
    'Title'                                              => 'Nimike',
    'Transcoder'                                         => '',
    'Unknown'                                            => 'Tuntematon',
    'Update'                                             => 'Päivitä',
    'Update Recording Settings'                          => 'Päivitä Nauhoitusasetukset',
    'Yes'                                                => 'Kyllä',
    'airdate'                                            => 'lähetysaika',
    'channum'                                            => 'Kanava',
    'description'                                        => 'kuvaus',
    'generic_date'                                       => '%a %b %e, %Y',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => 'pituus',
    'minutes'                                            => 'minuuttia',
    'recgroup'                                           => 'nauh.ryhmä',
    'rectype-long: always'                               => 'Nauhoita mihin aikaan tahansa millä kanavalla tahansa.',
    'rectype-long: channel'                              => 'Nauhoita mihin aikaan tahansa kanavalla $1.',
    'rectype-long: daily'                                => 'Nauhoita ohjelma tähän aikaan joka päivä.',
    'rectype-long: dontrec'                              => 'Älä nauhoita tätä lähetystä.',
    'rectype-long: finddaily'                            => 'Etsi yksi nauhoitus tästä lähetyksestä joka päivä.',
    'rectype-long: findone'                              => 'Etsi yksi nauhoitus tästä lähetyksestä.',
    'rectype-long: findweekly'                           => 'Etsi yksi nauhoitus tästä lähetyksestä joka viikko.',
    'rectype-long: once'                                 => 'Nauhoita vain tämä lähetys.',
    'rectype-long: override'                             => 'Nauhoita tämä tietty lähetys.',
    'rectype-long: weekly'                               => 'Nauhoita ohjelma tähän aikaan joka viikko.',
    'rectype: always'                                    => 'Aina',
    'rectype: channel'                                   => 'Kanavakohtainen',
    'rectype: daily'                                     => 'Päivittäin',
    'rectype: dontrec'                                   => 'Ei Nauhoitusta',
    'rectype: findone'                                   => 'Etsi Yksi',
    'rectype: once'                                      => 'Kerran',
    'rectype: override'                                  => 'Syrjäytys (nauhoita)',
    'rectype: weekly'                                    => 'Viikottain',
    'subtitle'                                           => 'Jakson nimi',
    'title'                                              => 'Nimike',
// includes/programs.php
    'recstatus: cancelled'         => 'Ajoitettu nauhoitus oli manuaalisesti peruttu.',
    'recstatus: conflict'          => 'Toinen korkeamman prioriteetin ohjelma nauhoitetaan tämän sijasta.',
    'recstatus: currentrecording'  => 'Jakso on aikaisemmin nauhoitettu ja katsottavissa.',
    'recstatus: deleted'           => 'Jaksoa nauhoitettiin, mutta nauhoitus poistettiin sen aikana.',
    'recstatus: earliershowing'    => 'Jakso tullaan nauhoittamaan aikaisemmin.',
    'recstatus: force_record'      => 'Ohjelman nauhoitus ajoitettiin käsin tälle ajankohdalle.',
    'recstatus: latershowing'      => 'Jakso tullaan nauhoittamaan myöhemmin.',
    'recstatus: lowdiskspace'      => 'Levytilaa ei ollut tarpeeksi tämän ohjelman nauhoittamiseen.',
    'recstatus: manualoverride'    => 'Ohjelman nauhoitus peruttiin manuaalisesti.',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: overlap'           => 'Toinen nauhoitus on ajastettu tälle ohjelmalle.',
    'recstatus: previousrecording' => 'Jakso on nauhoitettu aikaisemmin, sen mukaisesti mitä ajastuksen kaksoiskappaleiden asetukset määräävät.',
    'recstatus: recorded'          => 'Ohjelma on nauhoitettu.',
    'recstatus: recording'         => 'Ohjelmaa nauhoitetaan.',
    'recstatus: repeat'            => 'Ohjelma on uudelleenesitys, joten sitä ei nauhoiteta.',
    'recstatus: stopped'           => 'Ohjelman nauhoitus lopetettiin ennen sen loppumista.',
    'recstatus: toomanyrecordings' => 'Liian monta nauhoitusta tälle ohjelmalle.',
    'recstatus: tunerbusy'         => 'Viritinkortti oli käytössä tämän ohjelman aikana.',
    'recstatus: unknown'           => 'Ohjelman tilaa ei voida määritellä.',
    'recstatus: willrecord'        => 'Ohjelma tullaan nauhoittamaan.',
// includes/recording_schedules.php
    'Dup Method'                   => 'Metodi',
    'Profile'                      => 'Profiili',
    'Sub and Desc (Empty matches)' => 'Kuvaus ja Nimike (Ei vastaavuuksia)',
    'Type'                         => 'Nauhoitustapa',
    'rectype: finddaily'           => 'Etsi Päivittäinen',
    'rectype: findweekly'          => 'Etsi Viikottainen',
// includes/utils.php
    '$1 B'  => '$1 B',
    '$1 GB' => '$1 GB',
    '$1 KB' => '$1 KB',
    '$1 MB' => '$1 MB',
    '$1 TB' => '$1 TB',
// program_detail.php
    'Unknown Program.'            => 'Tuntematon Ohjelma.',
    'Unknown Recording Schedule.' => 'Tuntematon Ajoitus.',
// search.php
    'Please search for something.' => 'Syötä etsimislause.',
// themes/.../canned_searches.php
    'handy: overview' => 'Sisältää valmiita edistyneen etsinnän lauseita.',
// themes/.../channel_detail.php
    'Length' => 'Pituus',
    'Show'   => 'Ohjelma',
    'Time'   => 'Aika',
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
    '$1 Rating'                           => '$1 Arvostelu',
    'Back to the program listing'         => 'Takaisin ohjelmalistaukseen',
    'Back to the recording schedules'     => 'Takaisin nauhoituksen ajoitukseen',
    'Cast'                                => 'Pääosat',
    'Directed by'                         => 'Ohjaus',
    'Don\'t record this program.'         => 'Älä nauhoita ohjelmaa.',
    'Exec. Producer'                      => 'Tuottaja',
    'Find other showings of this program' => 'Etsi muita ohjelman lähetyksiä',
    'Find showings of this program'       => 'Etsi ohjelman lähetyksiä',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Vierastähdet',
    'Hosted by'                           => 'Isäntänä',
    'Presented by'                        => 'Esittää',
    'Produced by'                         => 'Tuottajana',
    'Program Detail'                      => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'Mitä muuta on tähän aikaan?',
    'Written by'                          => 'Käsikirjoittaja',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => 'Selataan:  $1',
    'Jump To'                 => 'Hyppää',
    'Program Listing'         => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1 jakso',
    '$1 episodes'                                         => '$1 jaksoa',
    '$1 recording'                                        => '$1 nauhoitus',
    '$1 recordings'                                       => '$1 nauhoitusta',
    'Are you sure you want to delete the following show?' => 'Poistetaanko seuraavat ohjelmat?',
    'Delete'                                              => 'Poista',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => 'Poista ja Uudelleennauhoita',
    'Delete and rerecord $1'                              => '',
    'Show group'                                          => 'Näytä ryhmä',
    'Show recordings'                                     => 'Näytä nauhoitukset',
    'auto-expire'                                         => 'anna vanheta',
    'file size'                                           => 'tiedostokoko',
    'has bookmark'                                        => 'kirjanmerkitty',
    'has commflag'                                        => 'mainokset merkitty',
    'has cutlist'                                         => 'on leikattu',
    'is editing'                                          => 'muokataan',
    'preview'                                             => 'esikatselu',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profiililuokat',
    'Recording profiles' => 'Nauhoitusprofiilit',
// themes/.../recording_schedules.php
    'Any'                                       => 'Mikä vain',
    'No recording schedules have been defined.' => 'Ajoituksia ei määritelty.',
    'channel'                                   => 'kanava',
    'profile'                                   => 'profiili',
    'transcoder'                                => '',
    'type'                                      => 'tyyppi',
// themes/.../schedule_manually.php
    'Save Schedule'     => 'Tallenna Ajoitus',
    'Schedule Manually' => '',
// themes/.../scheduled_recordings.php
    'Activate'      => 'Aktivoi',
    'Commands'      => 'Komennot',
    'Conflicts'     => 'Ristiriidat',
    'Deactivated'   => 'Pois päältä',
    'Default'       => 'Oletus',
    'Don\'t Record' => 'Älä Nauhoita',
    'Duplicates'    => 'Kaksoiskappaleet',
    'Forget Old'    => 'Unohda Vanha',
    'Never Record'  => 'Älä Koskaan Nauhoita',
    'Record This'   => 'Nauhoita Tämä',
    'Scheduled'     => 'Ajoitettu',
// themes/.../search.php
    'No matches found' => 'Ei vastaavuuksia',
    'Search for:  $1'  => 'Etsi:  $1',
// themes/.../settings.php
    'Channels'           => 'Kanavat',
    'Configure'          => 'Asetukset',
    'Key Bindings'       => 'Näppäinkomennot',
    'MythWeb Settings'   => 'MythWeb:in Asetukset',
    'settings: overview' => 'MythWeb:in asetussivu...<p>Nykyisellään keskeneräinen. Valitse seuraavista:',
// themes/.../settings_channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Varoitus: Näiden asetusten muokkaus voi haitata MythTV:n toimintaa.',
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
    'Edit keybindings on'   => 'Muokkaa näppäinkomentoja ',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'Kanavahyppy',
    'Date Formats'                    => 'Päivämäärän Muoto',
    'Guide Settings'                  => 'Ohjelmalistauksen Asetus',
    'Hour Format'                     => 'Ajan Muoto',
    'Language'                        => 'Kieli',
    'Listing &quot;Jump to&quot;'     => 'Listauksen Hyppy',
    'Listing Time Key'                => 'Listauksen Aikanäppäin',
    'MythWeb Theme'                   => 'Teema',
    'Only display favourite channels' => 'Vain Suosikkikanavat',
    'Reset'                           => 'Alustus',
    'SI Units?'                       => 'SI-yksiköt',
    'Scheduled Popup'                 => 'Ajoitusten Ikkunointi',
    'Show descriptions on new line'   => 'Kuvaukset uudella rivillä',
    'Status Bar'                      => 'Tilarivi',
    'Weather Icons'                   => 'Sääennusteen Ikonit',
    'format help'                     => 'apua muotoiluun',
// themes/.../theme.php
    'Category Legend'                            => 'Kategorian Merkit',
    'Category Type'                              => 'Kategorian Tyyppi',
    'Edit MythWeb and some MythTV settings.'     => 'Muokkaa MythWeb:in ja MythTV:n asetuksia.',
    'Exact Match'                                => 'Tarkka Vastaavuus',
    'HD Only'                                    => 'Vain Teräväpiirto',
    'Manually Schedule'                          => 'Manuaalinen Ajastus',
    'MythMusic on the web.'                      => 'MythMusic Netissä.',
    'MythVideo on the web.'                      => 'MythVideo Netissä.',
    'MythWeb Weather.'                           => 'MythWeb Sääennuste.',
    'Recording Schedules'                        => 'Tulevat Nauhoitukset',
    'Search fields'                              => 'Etsintäasetukset',
    'Search help'                                => 'Etsintäapu',
    'Search help: movie example'                 => '*** 1/2 Seikkailu',
    'Search help: movie search'                  => 'Elokuvan Haku',
    'Search help: regex example'                 => '/^Hyvä Ateria/',
    'Search help: regex search'                  => 'regex Etsintä',
    'Search options'                             => 'Etsintävalinnat',
    'Searches'                                   => 'Etsinnät',
    'Settings'                                   => 'Asetukset',
    'TV functions, including recorded programs.' => 'Nauhoitetut ohjelmat ja muut TV-asetukset.',
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
    ' at '               => ' ',
    'Current Conditions' => 'Säätila',
    'Forecast'           => 'Ennuste',
    'Friday'             => 'Perjantai',
    'High'               => 'Korkein',
    'Humidity'           => 'Ilmankosteus',
    'Last Updated'       => 'Päivitetty Viimeksi',
    'Low'                => 'Alin',
    'Monday'             => 'Maanantai',
    'Pressure'           => 'Ilmanpaine',
    'Radar'              => 'Säätutka',
    'Saturday'           => 'Lauantai',
    'Sunday'             => 'Sunnuntai',
    'Thursday'           => 'Torstai',
    'Today'              => 'Tänään',
    'Tomorrow'           => 'Huomenna',
    'Tuesday'            => 'Tiistai',
    'UV Extreme'         => 'Erittäin korkea UV',
    'UV High'            => 'Korkea UV',
    'UV Index'           => 'UV-indeksi',
    'UV Minimal'         => 'Alhainen UV',
    'UV Moderate'        => 'Keskimääräinen UV',
    'Visibility'         => 'Näkyvyys',
    'Weather'            => '',
    'Wednesday'          => 'Keskiviikko',
    'Wind'               => 'Tuuli',
    'Wind Chill'         => 'Tuulen Viileys'
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
$Categories['Unknown']        = array('Tuntematon');
$Categories['movie']          = array('Elokuva'  );

?>
