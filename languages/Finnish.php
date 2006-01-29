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
    'Create Schedule'                                    => 'Ajoita Nauhoitus',
    'Current recordings'                                 => 'Nykyiset nauhoitukset',
    'Currently Browsing:  $1'                            => 'Selataan:  $1',
    'Custom Schedule'                                    => 'Mukautettu Ajastus',
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
    'Friday'                                             => 'Perjantai',
    'Hour'                                               => 'Tunti',
    'IMDB'                                               => 'Internet MDB',
    'Inactive'                                           => 'Ei aktiivinen',
    'Jump'                                               => 'Hyppäys',
    'Jump to'                                            => 'Hyppää',
    'Listings'                                           => 'Listaus',
    'Monday'                                             => 'Maanantai',
    'Music'                                              => 'Musiikki',
    'Never Record'                                       => 'Älä Koskaan Nauhoita',
    'No'                                                 => 'Ei',
    'No. of recordings to keep'                          => 'N:o nauhoituksia pidettäväksi',
    'None'                                               => 'Ei Mikään',
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
    'Repeat'                                             => 'Tee uudelleen',
    'Saturday'                                           => 'Lauantai',
    'Save'                                               => 'Tallenna?',
    'Save Schedule'                                      => 'Tallenna Ajoitus',
    'Schedule'                                           => 'Ajoitus',
    'Schedule Manually'                                  => 'Ajoita Manuaalisesti',
    'Schedule Options'                                   => 'Ajoitusvalinnat',
    'Schedule Override'                                  => 'Ajoituksen Syrjäytys',
    'Schedule normally.'                                 => 'Ajoita normaalisti',
    'Search'                                             => 'Hae',
    'Search Results'                                     => 'Haun Tulokset',
    'Settings'                                           => 'Asetukset',
    'Start Early'                                        => 'Aloita Aiemmin',
    'Subtitle'                                           => 'Jakson Nimi',
    'Subtitle and Description'                           => 'Jakson Kuvaus',
    'Sunday'                                             => 'Sunnuntai',
    'The requested recording schedule has been deleted.' => 'Ajoitettu nauhoitus on poistettu',
    'Thursday'                                           => 'Torstai',
    'Title'                                              => 'Nimike',
    'Transcoder'                                         => 'Jälkikäsittely',
    'Tuesday'                                            => 'Tiistai',
    'Type'                                               => 'Nauhoitustapa',
    'Unknown'                                            => 'Tuntematon',
    'Upcoming Recordings'                                => 'Tulevat Nauhoitukset',
    'Update'                                             => 'Päivitä',
    'Update Recording Settings'                          => 'Päivitä Nauhoitusasetukset',
    'Weather'                                            => 'Säätila',
    'Wednesday'                                          => 'Keskiviikko',
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
    'CC'                           => 'Tekstitys',
    'HDTV'                         => 'Tarkkapiirto',
    'Notes'                        => 'Viesti',
    'Part $1 of $2'                => 'Jakso $1/$2',
    'Stereo'                       => 'Stereo',
    'Subtitled'                    => 'Tekstitetty',
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
    'rectype: finddaily'           => 'Etsi Päivittäinen',
    'rectype: findweekly'          => 'Etsi Viikottainen',
// includes/utils.php
    '$1 B'  => '$1 B',
    '$1 GB' => '$1 GB',
    '$1 KB' => '$1 KB',
    '$1 MB' => '$1 MB',
    '$1 TB' => '$1 TB',
// modules/backend_log/init.php
    'Logs' => 'Lokit',
// modules/movietimes/init.php
    'Movie Times' => 'Elokuvahaku',
// modules/settings/init.php
    'MythTV channel info'      => 'MythTV kanavatiedot',
    'MythTV key bindings'      => 'MythTV komennot',
    'MythWeb session settings' => 'MythWeb istuntoasetukset',
    'settings'                 => 'Asetukset',
// modules/status/init.php
    'Status' => 'Systeemin Tila',
// modules/stream/init.php
    'Streaming' => 'Lähetys',
// modules/tv/detail.php
    'This program is already scheduled to be recorded via a $1custom search$2.' => 'Tämä ohjelma on jo ajastettu nauhoittamaan käyttäen $1custom search$2.',
    'Unknown Program.'                                                          => 'Tuntematon Ohjelma.',
    'Unknown Recording Schedule.'                                               => 'Tuntematon Ajoitus.',
// modules/tv/init.php
    'Special Searches' => 'Edistynyt Haku',
    'TV'               => 'Televisio',
// modules/tv/recorded.php
    'No matching programs found.'             => 'Ei vastaavia ohjelmia.',
    'Showing all programs from the $1 group.' => 'Näytetään kaikki ohjelmat ryhmästä $1.',
    'Showing all programs.'                   => 'Näytetään kaikki ohjelmat.',
// modules/tv/schedules_custom.php
    'Any Category'                               => 'Mikä Tahansa Kategoria',
    'Any Channel'                                => 'Mikä Tahansa Kanava',
    'Any Program Type'                           => 'Mikä Tahansa Ohjelmatyyppi',
    'Find Time must be of the format:  HH:MM:SS' => '',
// modules/tv/search.php
    'Please search for something.' => 'Syötä hakulause.',
// modules/video/init.php
    'Video' => 'Videot',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => 'Palvelimen Lokit',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => 'tervetuloa: lokit',
// themes/default/header.php
    'Category Legend'                            => 'Kategorioiden Värit/Merkitys',
    'Category Type'                              => 'Kategorian Tyyppi',
    'Custom'                                     => 'Mukautettu',
    'Edit MythWeb and some MythTV settings.'     => 'Muokkaa MythWeb:in ja MythTV:n asetuksia.',
    'Exact Match'                                => 'Tarkka Vastaavuus',
    'HD Only'                                    => 'Vain Teräväpiirto',
    'Manual'                                     => 'Manuaalinen',
    'MythMusic on the web.'                      => 'MythMusic Netissä.',
    'MythVideo on the web.'                      => 'MythVideo Netissä.',
    'MythWeb Weather.'                           => 'MythWeb Sääennuste.',
    'Search fields'                              => 'Hakuasetukset',
    'Search help'                                => 'Hakuapu',
    'Search help: movie example'                 => '*** 1/2 Seikkailu',
    'Search help: movie search'                  => 'Elokuvan Haku',
    'Search help: regex example'                 => '/^Hyvä Ateria/',
    'Search help: regex search'                  => 'regex Haku',
    'Search options'                             => 'Hakuvalinnat',
    'Searches'                                   => 'Haut',
    'TV functions, including recorded programs.' => 'Nauhoitetut ohjelmat ja muut TV-asetukset.',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => 'tervetuloa',
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
    'Unfiltered'          => 'Suodattamatonta',
// themes/default/music/welcome.php
    'welcome: music' => 'tervetuloa: musiikki',
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
    'MythWeb Session Settings'        => 'MythWeb Istuntoasetukset',
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
    'welcome: settings' => 'tervetuloa: asetukset',
// themes/default/status/welcome.php
    'welcome: status' => 'tervetuloa: systeemin tila',
// themes/default/tv/channel.php
    'Channel Detail' => 'Kanavatiedot',
    'Length'         => 'Pituus',
    'Show'           => 'Ohjelma',
    'Time'           => 'Aika',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Takaisin ohjelmalistaukseen',
    'Back to the recording schedules'     => 'Takaisin nauhoituksen ajoitukseen',
    'Cast'                                => 'Pääosat',
    'Directed by'                         => 'Ohjaus',
    'Don\'t record this program.'         => 'Älä nauhoita ohjelmaa.',
    'Episode Number'                      => 'Jakson Numero',
    'Exec. Producer'                      => 'Tuottaja',
    'Find other showings of this program' => 'Etsi muita ohjelman lähetyksiä',
    'Find showings of this program'       => 'Etsi ohjelman lähetyksiä',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Vierastähdet',
    'Guide rating'                        => 'Arvostelu',
    'Hosted by'                           => 'Isäntänä',
    'MythTV Status'                       => 'MythTV Tila',
    'Possible conflicts with this show'   => 'Saattaa olla ristiriidassa tämän ohjelman kanssa',
    'Presented by'                        => 'Esittää',
    'Produced by'                         => 'Tuottajana',
    'Program Detail'                      => 'Ohjelman Lisätietoja',
    'Program ID'                          => '',
    'TV.com'                              => 'TV.com',
    'Time Stretch Default'                => 'Ajan Säädön Oletus',
    'What else is on at this time?'       => 'Mitä muuta on tähän aikaan?',
    'Written by'                          => 'Käsikirjoittaja',
// themes/default/tv/list.php
    'Jump To' => 'Hyppää',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => 'EI DATAA',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 jakso',
    '$1 episodes'                                         => '$1 jaksoa',
    '$1 recording'                                        => '$1 nauhoitus',
    '$1 recordings'                                       => '$1 nauhoitusta',
    'All groups'                                          => 'Kaikki ryhmät',
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
    'transcoder'                                => 'jälkikäsittely',
    'type'                                      => 'tyyppi',
// themes/default/tv/schedules_custom.php
    'Additional Tables'        => 'Täydentävät Taulukot',
    'Find Date & Time Options' => '',
    'Find Day'                 => '',
    'Find Time'                => '',
    'Keyword Search'           => 'Haku Avainsanalla',
    'People Search'            => 'Haku Nimellä',
    'Power Search'             => 'Tehokas Haku',
    'Search Phrase'            => 'Hakulause',
    'Search Type'              => 'Haun Tyyppi',
    'Title Search'             => 'Haku Nimikkeellä',
// themes/default/tv/schedules_manual.php
    'Channel'      => 'Kanava',
    'Length (min)' => 'Pituus (min)',
    'Start Date'   => 'Päivämäärä',
    'Start Time'   => 'Aloitusaika',
// themes/default/tv/search.php
    'No matches found'                 => 'Ei vastaavuuksia',
    'No matching programs were found.' => 'Vastaavia ohjelmia ei löytynyt.',
    'Search for:  $1'                  => 'Hae:  $1',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => 'Esitäytetyt Haut',
    'handy: overview'           => 'Sisältää valmiita edistyneen haun lauseita.',
// themes/default/tv/upcoming.php
    'Commands'    => 'Komennot',
    'Conflicts'   => 'Ristiriidat',
    'Deactivated' => 'Pois päältä',
    'Duplicates'  => 'Kaksoiskappaleet',
    'Scheduled'   => 'Ajoitettu',
// themes/default/tv/welcome.php
    'welcome: tv' => 'tervetuloa: televisio',
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
    'welcome: video' => 'tervetuloa: videot',
// themes/default/weather/weather.php
    ' at '               => ' ',
    'Current Conditions' => 'Säätila',
    'Forecast'           => 'Ennuste',
    'High'               => 'Korkein',
    'Humidity'           => 'Ilmankosteus',
    'Last Updated'       => 'Päivitetty Viimeksi',
    'Low'                => 'Alin',
    'Pressure'           => 'Ilmanpaine',
    'Radar'              => 'Säätutka',
    'Today'              => 'Tänään',
    'Tomorrow'           => 'Huomenna',
    'UV Extreme'         => 'Erittäin korkea UV',
    'UV High'            => 'Korkea UV',
    'UV Index'           => 'UV-indeksi',
    'UV Minimal'         => 'Alhainen UV',
    'UV Moderate'        => 'Keskimääräinen UV',
    'Visibility'         => 'Näkyvyys',
    'Wind'               => 'Tuuli',
    'Wind Chill'         => 'Tuulen Viileys',
// themes/default/weather/welcome.php
    'welcome: weather' => 'tervetuloa: säätila'
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
$Categories['Food']           = array('Ruoka',             '\\b(?:food|cook|drink)');
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

