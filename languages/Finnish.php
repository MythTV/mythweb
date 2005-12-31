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
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 ohjelmaa, käyttää $2 ($3) $4:stä ($5 vapaana).',
    '$1 to $2'                                           => '$1 - $2',
    'Activate'                                           => 'Aktivoi',
    'Advanced Options'                                   => 'Edistyneet Valinnat',
    'Airtime'                                            => 'Lähetysaika',
    'All recordings'                                     => 'Kaikki nauhoitukset',
    'Auto-expire recordings'                             => 'Aut. vanheneminen',
    'Auto-flag commercials'                              => 'Aut. mainosten merkkaus',
    'Auto-transcode'                                     => 'Automaattinen jälkikäsittely',
    'Backend Status'                                     => 'Palvelimen Tila',
    'Cancel this schedule.'                              => 'Peruuta nauhoitus',
    'Category'                                           => 'Kategoria',
    'Check for duplicates in'                            => 'Tarkista kaksoiskappaleet',
    'Current recordings'                                 => 'Nykyiset nauhoitukset',
    'Date'                                               => 'Aika',
    'Default'                                            => 'Oletus',
    'Description'                                        => 'Kuvaus',
    'Details for'                                        => 'Lisätiedot ohjelmalle',
    'Display'                                            => 'Tulosta',
    'Don\'t Record'                                      => 'Älä Nauhoita',
    'Duplicate Check method'                             => 'Kaksoiskapp. Tarkistus',
    'End Late'                                           => 'Lopeta Myöhemmin',
    'Episode'                                            => 'Jakso',
    'Forget Old'                                         => 'Unohda Vanha',
    'Hour'                                               => 'Tunti',
    'IMDB'                                               => 'Internet MDB',
    'Inactive'                                           => 'Ei aktiivinen',
    'Jump'                                               => 'Hyppäys',
    'Jump to'                                            => 'Hyppää',
    'Listings'                                           => 'Listaus',
    'Music'                                              => 'Musiikki',
    'Never Record'                                       => 'Älä Koskaan Nauhoita',
    'No'                                                 => 'N:o',
    'No. of recordings to keep'                          => 'N:o nauhoituksia pidettäväksi',
    'None'                                               => 'Ei Mikään',
    'Notes'                                              => 'Viesti',
    'Only New Episodes'                                  => 'Vain Uudet Jaksot',
    'Original Airdate'                                   => 'Vuosi',
    'Previous recordings'                                => 'Aiemmat nauhoitukset',
    'Program Listing'                                    => 'Ohjelmalistaus',
    'Rating'                                             => 'Arvostelu',
    'Record This'                                        => 'Nauhoita Tämä',
    'Record new and expire old'                          => 'Nauhoita uusi ja poista vanha',
    'Recorded Programs'                                  => 'Nauhoitetut Ohjelmat',
    'Recording Group'                                    => 'Nauhoitusryhmä',
    'Recording Options'                                  => 'Nauhoitusvalinnat',
    'Recording Priority'                                 => 'Nauhoituksen Prioriteetti',
    'Recording Profile'                                  => 'Nauhoitusprofiili',
    'Recording Schedules'                                => 'Tulevat Nauhoitukset',
    'Rerun'                                              => 'Tee uudelleen',
    'Save'                                               => 'Tallenna?',
    'Schedule'                                           => 'Ajoitus',
    'Schedule Options'                                   => 'Ajoitusvalinnat',
    'Schedule Override'                                  => 'Ajoituksen Syrjäytys',
    'Schedule normally.'                                 => 'Ajoita normaalisti',
    'Search'                                             => 'Etsi',
    'Search Results'                                     => 'Etsinnän Tulokset',
    'Settings'                                           => 'Asetukset',
    'Start Early'                                        => 'Aloita Aiemmin',
    'Subtitle'                                           => 'Jakson Nimi',
    'Subtitle and Description'                           => 'Jakson Kuvaus',
    'The requested recording schedule has been deleted.' => 'Ajoitettu nauhoitus on poistettu',
    'Title'                                              => 'Nimike',
    'Transcoder'                                         => '',
    'Unknown'                                            => 'Tuntematon',
    'Upcoming Recordings'                                => 'Tulevat Nauhoitukset',
    'Update'                                             => 'Päivitä',
    'Update Recording Settings'                          => 'Päivitä Nauhoitusasetukset',
    'Weather'                                            => 'Säätila',
    'Yes'                                                => 'Kyllä',
    'airdate'                                            => 'lähetysaika',
    'channum'                                            => 'Kanava',
    'description'                                        => 'kuvaus',
    'generic_date'                                       => '%a %b %e, %Y',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => 'pituus',
    'minutes'                                            => 'minuuttia',
    'recgroup'                                           => 'nauh.ryhmä',
    'recpriority'                                        => 'Nauhoitusprioriteetti',
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
    'recstatus: inactive'          => 'Nauhoitus on poistettu käytöstä tälle ohjelmalle.',
    'recstatus: latershowing'      => 'Jakso tullaan nauhoittamaan myöhemmin.',
    'recstatus: lowdiskspace'      => 'Levytilaa ei ollut tarpeeksi tämän ohjelman nauhoittamiseen.',
    'recstatus: manualoverride'    => 'Ohjelman nauhoitus peruttiin manuaalisesti.',
    'recstatus: neverrecord'       => 'Ohjelmaa ei tulla koskaan nauhoittamaan',
    'recstatus: notlisted'         => 'Ohjelmaa ei löydetty oppaasta',
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
// modules/backend_log/init.php
    'Logs' => '',
// modules/movietimes/init.php
    'Movie Times' => 'Elokuvahaku',
// modules/settings/init.php
    'MythTV channel info'      => '',
    'MythTV key bindings'      => '',
    'MythWeb session settings' => '',
    'settings'                 => 'Asetukset',
// modules/status/init.php
    'Status' => 'Systeemin Tila',
// modules/stream/init.php
    'Streaming' => '',
// modules/tv/detail.php
    'Unknown Program.'            => 'Tuntematon Ohjelma.',
    'Unknown Recording Schedule.' => 'Tuntematon Ajoitus.',
// modules/tv/init.php
    'Search TV'        => 'Ohjelmahaku',
    'Special Searches' => 'Edistynyt Haku',
    'TV'               => '',
// modules/tv/search.php
    'Please search for something.' => 'Syötä etsimislause.',
// modules/video/init.php
    'Video' => 'Videot',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => '',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => '',
// themes/default/header.php
    'Category Legend'                            => 'Kategorian Merkit',
    'Category Type'                              => 'Kategorian Tyyppi',
    'Edit MythWeb and some MythTV settings.'     => 'Muokkaa MythWeb:in ja MythTV:n asetuksia.',
    'Exact Match'                                => 'Tarkka Vastaavuus',
    'HD Only'                                    => 'Vain Teräväpiirto',
    'Manually Schedule'                          => 'Manuaalinen Ajastus',
    'MythMusic on the web.'                      => 'MythMusic Netissä.',
    'MythVideo on the web.'                      => 'MythVideo Netissä.',
    'MythWeb Weather.'                           => 'MythWeb Sääennuste.',
    'Search fields'                              => 'Etsintäasetukset',
    'Search help'                                => 'Etsintäapu',
    'Search help: movie example'                 => '*** 1/2 Seikkailu',
    'Search help: movie search'                  => 'Elokuvan Haku',
    'Search help: regex example'                 => '/^Hyvä Ateria/',
    'Search help: regex search'                  => 'regex Etsintä',
    'Search options'                             => 'Etsintävalinnat',
    'Searches'                                   => 'Etsinnät',
    'TV functions, including recorded programs.' => 'Nauhoitetut ohjelmat ja muut TV-asetukset.',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => '',
// themes/default/music/music.php
    'Album'               => 'Albumi',
    'Album (filtered)'    => 'Albumi (suodatettu)',
    'All Music'           => 'Kaikki Musiikki',
    'Artist'              => 'Esittäjä',
    'Artist (filtered)'   => 'Esittäjä (suodatettu)',
    'Displaying'          => 'Näytetään',
    'Duration'            => 'Kesto',
    'End'                 => 'Loppu',
    'Filtered'            => 'Suodatettu',
    'Genre'               => 'Laji',
    'Genre (filtered)'    => 'Laji (suodatettu)',
    'Next'                => 'Seuraava',
    'No Tracks Available' => 'Kappaleita Ei Saatavilla',
    'Previous'            => 'Edellinen',
    'Top'                 => 'Ylös',
    'Track Name'          => 'Kappaleen Nimi',
    'Unfiltered'          => 'Suodattamaton',
// themes/default/music/welcome.php
    'welcome: music' => '',
// themes/default/settings/channels.php
    'Configure Channels'                                                                                                                 => 'Aseta Kanavat',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Varoitus: Näiden asetusten muokkaus voi haitata MythTV:n toimintaa.',
    'brightness'                                                                                                                         => 'Kirkkaus',
    'callsign'                                                                                                                           => 'Kutsumanimi',
    'colour'                                                                                                                             => 'Väri',
    'commfree'                                                                                                                           => 'Mainosvapaa',
    'contrast'                                                                                                                           => 'Kontrasti',
    'delete'                                                                                                                             => 'Poista',
    'finetune'                                                                                                                           => 'Hienosäätö',
    'freqid'                                                                                                                             => '',
    'hue'                                                                                                                                => 'Värikylläisyys',
    'name'                                                                                                                               => 'Nimi',
    'sourceid'                                                                                                                           => '',
    'useonairguide'                                                                                                                      => 'Käytä Ohjelmavirran Opasta',
    'videofilters'                                                                                                                       => 'Videosuodattimet',
    'visible'                                                                                                                            => 'Näkyvä',
    'xmltvid'                                                                                                                            => '',
// themes/default/settings/keys.php
    'Action'                => 'Toiminto',
    'Configure Keybindings' => 'Aseta Näppäinkomennot',
    'Context'               => 'Konteksti',
    'Destination'           => 'Kohde',
    'Edit keybindings on'   => 'Muokkaa näppäinkomentoja ',
    'JumpPoints Editor'     => 'Hyppäämisasetukset',
    'Key bindings'          => 'Näppäinkomennot',
    'Keybindings Editor'    => 'Näppäinkomentojen Muokkaus',
    'Set Host'              => 'Aseta Isäntä',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'Kanavahyppy',
    'Date Formats'                    => 'Päivämäärän Muoto',
    'Guide Settings'                  => 'Ohjelmalistauksen Asetus',
    'Hour Format'                     => 'Ajan Muoto',
    'Language'                        => 'Kieli',
    'Listing &quot;Jump to&quot;'     => 'Listauksen Hyppy',
    'Listing Time Key'                => 'Listauksen Aikanäppäin',
    'MythWeb Session Settings'        => '',
    'MythWeb Theme'                   => 'Teema',
    'Only display favourite channels' => 'Vain Suosikkikanavat',
    'Reset'                           => 'Alustus',
    'SI Units?'                       => 'SI-yksiköt',
    'Scheduled Popup'                 => 'Ajoitusten Ikkunointi',
    'Show descriptions on new line'   => 'Kuvaukset uudella rivillä',
    'Status Bar'                      => 'Tilarivi',
    'Weather Icons'                   => 'Sääennusteen Ikonit',
    'format help'                     => 'apua muotoiluun',
// themes/default/settings/settings.php
    'settings: overview' => 'MythWeb:in asetussivu...<p>Nykyisellään keskeneräinen. Valitse seuraavista:',
// themes/default/settings/welcome.php
    'welcome: settings' => '',
// themes/default/status/welcome.php
    'welcome: status' => '',
// themes/default/tv/channel.php
    'Channel Detail' => '',
    'Length'         => 'Pituus',
    'Show'           => 'Ohjelma',
    'Time'           => 'Aika',
// themes/default/tv/detail.php
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
    'Guide rating'                        => '',
    'Hosted by'                           => 'Isäntänä',
    'Possible conflicts with this show'   => '',
    'Presented by'                        => 'Esittää',
    'Produced by'                         => 'Tuottajana',
    'Program Detail'                      => 'Ohjelman Lisätietoja',
    'TV.com'                              => 'TV.com',
    'Time Stretch Default'                => 'Ajan Säädön Oletus',
    'What else is on at this time?'       => 'Mitä muuta on tähän aikaan?',
    'Written by'                          => 'Käsikirjoittaja',
// themes/default/tv/list.php
    'Currently Browsing:  $1' => 'Selataan:  $1',
    'Jump To'                 => 'Hyppää',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => 'EI DATAA',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 jakso',
    '$1 episodes'                                         => '$1 jaksoa',
    '$1 recording'                                        => '$1 nauhoitus',
    '$1 recordings'                                       => '$1 nauhoitusta',
    'Are you sure you want to delete the following show?' => 'Poistetaanko seuraavat ohjelmat?',
    'Delete'                                              => 'Poista',
    'Delete $1'                                           => 'Poista $1',
    'Delete + Rerecord'                                   => 'Poista ja Uudelleennauhoita',
    'Delete and rerecord $1'                              => 'Poista ja Uudelleennauhoita $1',
    'Go'                                                  => 'Mene',
    'Show group'                                          => 'Näytä ryhmä',
    'Show recordings'                                     => 'Näytä nauhoitukset',
    'auto-expire'                                         => 'anna vanheta',
    'file size'                                           => 'tiedostokoko',
    'has bookmark'                                        => 'kirjanmerkitty',
    'has commflag'                                        => 'mainokset merkitty',
    'has cutlist'                                         => 'on leikattu',
    'is editing'                                          => 'muokataan',
    'preview'                                             => 'esikatselu',
// themes/default/tv/schedules.php
    'Any'                                       => 'Mikä vain',
    'No recording schedules have been defined.' => 'Ajoituksia ei määritelty.',
    'channel'                                   => 'kanava',
    'profile'                                   => 'profiili',
    'transcoder'                                => '',
    'type'                                      => 'tyyppi',
// themes/default/tv/schedules_manual.php
    'Channel'           => 'Kanava',
    'Create Schedule'   => 'Ajoita Nauhoitus',
    'Length (min)'      => 'Pituus (min)',
    'Save Schedule'     => 'Tallenna Ajoitus',
    'Schedule Manually' => 'Ajoita Manuaalisesti',
    'Start Date'        => 'Päivämäärä',
    'Start Time'        => 'Aloitusaika',
// themes/default/tv/search.php
    'No matches found'                 => 'Ei vastaavuuksia',
    'No matching programs were found.' => '',
    'Search for:  $1'                  => 'Etsi:  $1',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => '',
    'handy: overview'           => 'Sisältää valmiita edistyneen etsinnän lauseita.',
// themes/default/tv/upcoming.php
    'Commands'    => 'Komennot',
    'Conflicts'   => 'Ristiriidat',
    'Deactivated' => 'Pois päältä',
    'Duplicates'  => 'Kaksoiskappaleet',
    'Scheduled'   => 'Ajoitettu',
// themes/default/tv/welcome.php
    'welcome: tv' => '',
// themes/default/video/video.php
    'Edit'          => 'Muokkaa',
    'Reverse Order' => 'Päinvastainen Järjestys',
    'Videos'        => 'Videot',
    'category'      => 'Kategoria',
    'cover'         => 'Kuvake',
    'director'      => 'Ohjaaja',
    'imdb rating'   => 'imbd arvostelu',
    'plot'          => 'juoni',
    'rating'        => 'arvostelu',
    'year'          => 'vuosi',
// themes/default/video/welcome.php
    'welcome: video' => '',
// themes/default/weather/weather.php
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
    'Wednesday'          => 'Keskiviikko',
    'Wind'               => 'Tuuli',
    'Wind Chill'         => 'Tuulen Viileys',
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
$Categories['Action']         = array('Toiminta',           '\\b(?:action|adven)');
$Categories['Adult']          = array('Seksi',            '\\b(?:adult|erot)');
$Categories['Animals']        = array('Eläimet',          '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Kulttuuri',        '\\b(?:art|dance|music|cultur)');
$Categories['Business']       = array('Kauppa',         '\\b(?:biz|busine)');
$Categories['Children']       = array('Lasten',         '\\b(?:child|infan|animation)');
$Categories['Comedy']         = array('Komedia',           '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Trilleri',  '\\b(?:crim|myster)');
$Categories['Documentary']    = array('Dokumentti',      '\\b(?:doc)');
$Categories['Drama']          = array('Draama',            '\\b(?:drama)');
$Categories['Educational']    = array('Opetus',      '\\b(?:edu|interests)');
$Categories['Food']           = array('Kokki',             '\\b(?:food|cook|drink)');
$Categories['Game']           = array('Pelit',             '\\b(?:game)');
$Categories['Health_Medical'] = array('Terveys', '\\b(?:health|medic)');
$Categories['History']        = array('Historia',          '\\b(?:hist)');
$Categories['Horror']         = array('Kauhu',           '\\b(?:horror)');
$Categories['HowTo']          = array('TeeSeItse',            '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Muu',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Uutiset',             '\\b(?:news|current)');
$Categories['Reality']        = array('Tositv',          '\\b(?:reality)');
$Categories['Romance']        = array('Romanssi',          '\\b(?:romance)');
$Categories['SciFi_Fantasy']  = array('Tieteisjännitys',  '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Science_Nature'] = array('Luonto', '\\b(?:science|nature|environment)');
$Categories['Shopping']       = array('Ostaminen',         '\\b(?:shop)');
$Categories['Soaps']          = array('Saippua',            '\\b(?:soaps)');
$Categories['Spiritual']      = array('Uskonnollinen',        '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Urheilu',           '\\b(?:sport)');
$Categories['Talk']           = array('Keskustelu',             '\\b(?:talk)');
$Categories['Travel']         = array('Matkailu',           '\\b(?:travel)');
$Categories['War']            = array('Sota',              '\\b(?:war)');
$Categories['Western']        = array('Lännen',          '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Tuntematon');
$Categories['movie']          = array('Elokuva'  );

