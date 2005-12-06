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
    ' at '                                                => ' ',
    '$1 Rating'                                           => '$1 Arvostelu',
    '$1 episode'                                          => '$1 jakso',
    '$1 episodes'                                         => '$1 jaksoa',
    '$1 hr'                                               => '$1 tunti',
    '$1 hrs'                                              => '$1 tuntia',
    '$1 min'                                              => '$1 minuutti',
    '$1 mins'                                             => '$1 minuuttia',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'     => '$1 ohjelmaa, käyttää $2 ($3) $4:stä ($5 vapaana).',
    '$1 recording'                                        => '$1 nauhoitus',
    '$1 recordings'                                       => '$1 nauhoitusta',
    '$1 to $2'                                            => '$1 - $2',
    'Activate'                                            => 'Aktivoi',
    'Advanced Options'                                    => 'Edistyneet Valinnat',
    'Airtime'                                             => 'Lähetysaika',
    'All recordings'                                      => 'Kaikki nauhoitukset',
    'Are you sure you want to delete the following show?' => 'Poistetaanko seuraavat ohjelmat?',
    'Auto-expire recordings'                              => 'Aut. vanheneminen',
    'Auto-flag commercials'                               => 'Aut. mainosten merkkaus',
    'Auto-transcode'                                      => 'Automaattinen jälkikäsittely',
    'Back to the program listing'                         => 'Takaisin ohjelmalistaukseen',
    'Back to the recording schedules'                     => 'Takaisin nauhoituksen ajoitukseen',
    'Backend Logs'                                        => '',
    'Backend Status'                                      => 'Palvelimen Tila',
    'Cancel this schedule.'                               => 'Peruuta nauhoitus',
    'Cast'                                                => 'Pääosat',
    'Category'                                            => 'Kategoria',
    'Category Legend'                                     => 'Kategorian Merkit',
    'Category Type'                                       => 'Kategorian Tyyppi',
    'Channel'                                             => 'Kanava',
    'Check for duplicates in'                             => 'Tarkista kaksoiskappaleet',
    'Commands'                                            => 'Komennot',
    'Conflicts'                                           => 'Ristiriidat',
    'Create Schedule'                                     => 'Ajoita Nauhoitus',
    'Current Conditions'                                  => 'Säätila',
    'Current recordings'                                  => 'Nykyiset nauhoitukset',
    'Currently Browsing:  $1'                             => 'Selataan:  $1',
    'Date'                                                => 'Aika',
    'Deactivated'                                         => 'Pois päältä',
    'Default'                                             => 'Oletus',
    'Delete'                                              => 'Poista',
    'Delete $1'                                           => 'Poista $1',
    'Delete + Rerecord'                                   => 'Poista ja Uudelleennauhoita',
    'Delete and rerecord $1'                              => 'Poista ja Uudelleennauhoita $1',
    'Description'                                         => 'Kuvaus',
    'Details for'                                         => 'Lisätiedot ohjelmalle',
    'Directed by'                                         => 'Ohjaus',
    'Display'                                             => 'Tulosta',
    'Don\'t Record'                                       => 'Älä Nauhoita',
    'Don\'t record this program.'                         => 'Älä nauhoita ohjelmaa.',
    'Duplicate Check method'                              => 'Kaksoiskapp. Tarkistus',
    'Duplicates'                                          => 'Kaksoiskappaleet',
    'Edit MythWeb and some MythTV settings.'              => 'Muokkaa MythWeb:in ja MythTV:n asetuksia.',
    'End Late'                                            => 'Lopeta Myöhemmin',
    'Episode'                                             => 'Jakso',
    'Exact Match'                                         => 'Tarkka Vastaavuus',
    'Exec. Producer'                                      => 'Tuottaja',
    'Find other showings of this program'                 => 'Etsi muita ohjelman lähetyksiä',
    'Find showings of this program'                       => 'Etsi ohjelman lähetyksiä',
    'Forecast'                                            => 'Ennuste',
    'Forget Old'                                          => 'Unohda Vanha',
    'Friday'                                              => 'Perjantai',
    'Go'                                                  => 'Mene',
    'Google'                                              => 'Google',
    'Guest Starring'                                      => 'Vierastähdet',
    'Guide rating'                                        => '',
    'HD Only'                                             => 'Vain Teräväpiirto',
    'High'                                                => 'Korkein',
    'Hosted by'                                           => 'Isäntänä',
    'Hour'                                                => 'Tunti',
    'Humidity'                                            => 'Ilmankosteus',
    'IMDB'                                                => 'Internet MDB',
    'Inactive'                                            => 'Ei aktiivinen',
    'Jump'                                                => 'Hyppäys',
    'Jump To'                                             => 'Hyppää',
    'Jump to'                                             => 'Hyppää',
    'Last Updated'                                        => 'Päivitetty Viimeksi',
    'Length (min)'                                        => 'Pituus (min)',
    'Listings'                                            => 'Listaus',
    'Low'                                                 => 'Alin',
    'Manually Schedule'                                   => 'Manuaalinen Ajastus',
    'Monday'                                              => 'Maanantai',
    'Music'                                               => 'Musiikki',
    'MythMusic on the web.'                               => 'MythMusic Netissä.',
    'MythVideo on the web.'                               => 'MythVideo Netissä.',
    'MythWeb Weather.'                                    => 'MythWeb Sääennuste.',
    'Never Record'                                        => 'Älä Koskaan Nauhoita',
    'No'                                                  => 'N:o',
    'No. of recordings to keep'                           => 'N:o nauhoituksia pidettäväksi',
    'None'                                                => 'Ei Mikään',
    'Notes'                                               => 'Viesti',
    'Only New Episodes'                                   => 'Vain Uudet Jaksot',
    'Original Airdate'                                    => 'Vuosi',
    'Please search for something.'                        => 'Syötä etsimislause.',
    'Presented by'                                        => 'Esittää',
    'Pressure'                                            => 'Ilmanpaine',
    'Previous recordings'                                 => 'Aiemmat nauhoitukset',
    'Produced by'                                         => 'Tuottajana',
    'Program Detail'                                      => 'Ohjelman Lisätietoja',
    'Program Listing'                                     => 'Ohjelmalistaus',
    'Radar'                                               => 'Säätutka',
    'Rating'                                              => 'Arvostelu',
    'Record This'                                         => 'Nauhoita Tämä',
    'Record new and expire old'                           => 'Nauhoita uusi ja poista vanha',
    'Recorded Programs'                                   => 'Nauhoitetut Ohjelmat',
    'Recording Group'                                     => 'Nauhoitusryhmä',
    'Recording Options'                                   => 'Nauhoitusvalinnat',
    'Recording Priority'                                  => 'Nauhoituksen Prioriteetti',
    'Recording Profile'                                   => 'Nauhoitusprofiili',
    'Recording Schedules'                                 => 'Tulevat Nauhoitukset',
    'Rerun'                                               => 'Tee uudelleen',
    'Saturday'                                            => 'Lauantai',
    'Save'                                                => 'Tallenna?',
    'Schedule'                                            => 'Ajoitus',
    'Schedule Options'                                    => 'Ajoitusvalinnat',
    'Schedule Override'                                   => 'Ajoituksen Syrjäytys',
    'Schedule normally.'                                  => 'Ajoita normaalisti',
    'Scheduled'                                           => 'Ajoitettu',
    'Scheduled Recordings'                                => 'Ajoitetut Nauhoitukset',
    'Search'                                              => 'Etsi',
    'Search Results'                                      => 'Etsinnän Tulokset',
    'Search fields'                                       => 'Etsintäasetukset',
    'Search help'                                         => 'Etsintäapu',
    'Search help: movie example'                          => '*** 1/2 Seikkailu',
    'Search help: movie search'                           => 'Elokuvan Haku',
    'Search help: regex example'                          => '/^Hyvä Ateria/',
    'Search help: regex search'                           => 'regex Etsintä',
    'Search options'                                      => 'Etsintävalinnat',
    'Searches'                                            => 'Etsinnät',
    'Settings'                                            => 'Asetukset',
    'Show group'                                          => 'Näytä ryhmä',
    'Show recordings'                                     => 'Näytä nauhoitukset',
    'Start Date'                                          => 'Päivämäärä',
    'Start Early'                                         => 'Aloita Aiemmin',
    'Start Time'                                          => 'Aloitusaika',
    'Subtitle'                                            => 'Jakson Nimi',
    'Subtitle and Description'                            => 'Jakson Kuvaus',
    'Sunday'                                              => 'Sunnuntai',
    'TV functions, including recorded programs.'          => 'Nauhoitetut ohjelmat ja muut TV-asetukset.',
    'TV.com'                                              => 'TV.com',
    'The requested recording schedule has been deleted.'  => 'Ajoitettu nauhoitus on poistettu',
    'Thursday'                                            => 'Torstai',
    'Time Stretch Default'                                => 'Ajan Säädön Oletus',
    'Title'                                               => 'Nimike',
    'Today'                                               => 'Tänään',
    'Tomorrow'                                            => 'Huomenna',
    'Transcoder'                                          => '',
    'Tuesday'                                             => 'Tiistai',
    'UV Extreme'                                          => 'Erittäin korkea UV',
    'UV High'                                             => 'Korkea UV',
    'UV Index'                                            => 'UV-indeksi',
    'UV Minimal'                                          => 'Alhainen UV',
    'UV Moderate'                                         => 'Keskimääräinen UV',
    'Unknown'                                             => 'Tuntematon',
    'Unknown Program.'                                    => 'Tuntematon Ohjelma.',
    'Unknown Recording Schedule.'                         => 'Tuntematon Ajoitus.',
    'Upcoming Recordings'                                 => 'Tulevat Nauhoitukset',
    'Update'                                              => 'Päivitä',
    'Update Recording Settings'                           => 'Päivitä Nauhoitusasetukset',
    'Visibility'                                          => 'Näkyvyys',
    'Weather'                                             => 'Säätila',
    'Wednesday'                                           => 'Keskiviikko',
    'What else is on at this time?'                       => 'Mitä muuta on tähän aikaan?',
    'Wind'                                                => 'Tuuli',
    'Wind Chill'                                          => 'Tuulen Viileys',
    'Written by'                                          => 'Käsikirjoittaja',
    'Yes'                                                 => 'Kyllä',
    'airdate'                                             => 'lähetysaika',
    'auto-expire'                                         => 'anna vanheta',
    'channum'                                             => 'Kanava',
    'description'                                         => 'kuvaus',
    'file size'                                           => 'tiedostokoko',
    'generic_date'                                        => '%a %b %e, %Y',
    'generic_time'                                        => '%I:%M %p',
    'has bookmark'                                        => 'kirjanmerkitty',
    'has commflag'                                        => 'mainokset merkitty',
    'has cutlist'                                         => 'on leikattu',
    'is editing'                                          => 'muokataan',
    'length'                                              => 'pituus',
    'minutes'                                             => 'minuuttia',
    'preview'                                             => 'esikatselu',
    'recgroup'                                            => 'nauh.ryhmä',
    'recpriority'                                         => 'Nauhoitusprioriteetti',
    'rectype-long: always'                                => 'Nauhoita mihin aikaan tahansa millä kanavalla tahansa.',
    'rectype-long: channel'                               => 'Nauhoita mihin aikaan tahansa kanavalla $1.',
    'rectype-long: daily'                                 => 'Nauhoita ohjelma tähän aikaan joka päivä.',
    'rectype-long: dontrec'                               => 'Älä nauhoita tätä lähetystä.',
    'rectype-long: finddaily'                             => 'Etsi yksi nauhoitus tästä lähetyksestä joka päivä.',
    'rectype-long: findone'                               => 'Etsi yksi nauhoitus tästä lähetyksestä.',
    'rectype-long: findweekly'                            => 'Etsi yksi nauhoitus tästä lähetyksestä joka viikko.',
    'rectype-long: once'                                  => 'Nauhoita vain tämä lähetys.',
    'rectype-long: override'                              => 'Nauhoita tämä tietty lähetys.',
    'rectype-long: weekly'                                => 'Nauhoita ohjelma tähän aikaan joka viikko.',
    'rectype: always'                                     => 'Aina',
    'rectype: channel'                                    => 'Kanavakohtainen',
    'rectype: daily'                                      => 'Päivittäin',
    'rectype: dontrec'                                    => 'Ei Nauhoitusta',
    'rectype: findone'                                    => 'Etsi Yksi',
    'rectype: once'                                       => 'Kerran',
    'rectype: override'                                   => 'Syrjäytys (nauhoita)',
    'rectype: weekly'                                     => 'Viikottain',
    'subtitle'                                            => 'Jakson nimi',
    'title'                                               => 'Nimike',
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
// modules/movietimes/init.php
    'Movie Times' => 'Elokuvahaku',
// modules/settings/init.php
    'settings' => 'Asetukset',
// modules/status/init.php
    'Status' => 'Systeemin Tila',
// modules/tv/init.php
    'Search TV'        => 'Ohjelmahaku',
    'Special Searches' => 'Edistynyt Haku',
    'TV'               => '',
// modules/video/init.php
    'Video' => 'Videot',
// themes/.../canned_searches.php
    'handy: overview' => 'Sisältää valmiita edistyneen etsinnän lauseita.',
// themes/.../channel_detail.php
    'Length' => 'Pituus',
    'Show'   => 'Ohjelma',
    'Time'   => 'Aika',
// themes/.../music.php
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
    'Schedule Manually' => 'Ajoita Manuaalisesti',
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
// themes/.../settings_keys.php
    'Action'                => 'Toiminto',
    'Configure Keybindings' => 'Aseta Näppäinkomennot',
    'Context'               => 'Konteksti',
    'Destination'           => 'Kohde',
    'Edit keybindings on'   => 'Muokkaa näppäinkomentoja ',
    'JumpPoints Editor'     => 'Hyppäämisasetukset',
    'Key bindings'          => 'Näppäinkomennot',
    'Keybindings Editor'    => 'Näppäinkomentojen Muokkaus',
    'Set Host'              => 'Aseta Isäntä',
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
// themes/.../video.php
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
// themes/default/backend_log/welcome.php
    'Show the server logs.' => '',
// themes/default/movietimes/welcome.php
    'Get listings for movies playing at local theatres.' => 'Hae Paikallisten elokuvateattereiden elokuvat.',
// themes/default/music/welcome.php
    'Browse your music collection.' => 'Selaa Musiikkitietokantaa.',
// themes/default/settings/welcome.php
    'Configure MythWeb.' => 'Aseta MythWeb.',
// themes/default/status/welcome.php
    'Show the backend status page.' => 'Näytä Systeemin tila.',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => 'EI DATAA',
// themes/default/tv/welcome.php
    'See what\'s on tv, schedule recordings and manage shows that you\'ve already recorded.  Please see the following choices:' => 'TV-ohjelmien nauhoittamisasetukset. Valitse seuraavista:',
// themes/default/video/welcome.php
    'Browse your video collection.' => 'Selaa videoita.',
// themes/default/weather/welcome.php
    'Get the local weather forecast.' => 'Katso paikallinen säätiedotus.'
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

