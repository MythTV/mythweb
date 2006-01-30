<?php
/***                                                                        ***\
    languages/German.php

    Translation hash for German.
\***                                                                        ***/

// Set locale to German
setlocale(LC_ALL, 'de_DE');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 Search'                                          => '',
    '$1 hr'                                              => '$1 Std.',
    '$1 hrs'                                             => '$1 Std.',
    '$1 min'                                             => '$1 Min.',
    '$1 mins'                                            => '$1 Min.',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 Aufnahmen, belegen $2 ($3) von $4.',
    '$1 to $2'                                           => '$1 bis $2',
    'Activate'                                           => 'Aktivieren',
    'Advanced Options'                                   => 'Erweiterte Optionen',
    'Airtime'                                            => 'Sendezeit',
    'All recordings'                                     => 'Alle Aufnahmen',
    'Auto-expire recordings'                             => 'Aufnahmen autom. löschen',
    'Auto-flag commercials'                              => 'Werbung markieren',
    'Auto-transcode'                                     => 'autom. Umwandeln',
    'Backend Status'                                     => 'Backend Status',
    'Cancel this schedule.'                              => 'Aufnahme abbrechen',
    'Category'                                           => 'Kategorie',
    'Check for duplicates in'                            => 'Nach Wdhgn. suchen in',
    'Create Schedule'                                    => 'Speichern',
    'Current recordings'                                 => 'Aktuelle Aufnahmen',
    'Currently Browsing:  $1'                            => 'Aktuell: $1',
    'Custom Schedule'                                    => '',
    'Date'                                               => 'Datum',
    'Default'                                            => 'Standard',
    'Description'                                        => 'Beschreibung',
    'Details for'                                        => 'Details für',
    'Display'                                            => 'Anzeigen',
    'Don\'t Record'                                      => 'Nicht aufnehmen',
    'Duplicate Check method'                             => 'Testmethode für Wdhgn.',
    'End Late'                                           => 'verspätetes Aufnahmeende',
    'Episode'                                            => 'Folge',
    'Forget Old'                                         => 'frühere Aufnahmen vergessen',
    'Friday'                                             => 'Freitag',
    'Hour'                                               => 'Stunde',
    'IMDB'                                               => 'IMDB',
    'Inactive'                                           => 'Inaktiv',
    'Jump'                                               => 'Gehe',
    'Jump to'                                            => 'Gehe zu',
    'Keyword'                                            => '',
    'Listings'                                           => 'TV Programm',
    'Monday'                                             => 'Montag',
    'Music'                                              => 'Musik',
    'Never Record'                                       => 'Niemals aufnehmen',
    'No'                                                 => 'Nein',
    'No. of recordings to keep'                          => 'Wieviele Aufnahmen behalten',
    'None'                                               => 'Keine',
    'Only New Episodes'                                  => 'Nur neue Folgen',
    'Original Airdate'                                   => 'Produktion',
    'People'                                             => '',
    'Power'                                              => '',
    'Previous recordings'                                => 'Alte Aufnahmen',
    'Program Listing'                                    => 'TV Programm',
    'Rating'                                             => 'Freigegeben ab',
    'Record This'                                        => 'Diese Sendung aufnehmen',
    'Record new and expire old'                          => 'Nur neue Folgen aufnehmen',
    'Recorded Programs'                                  => 'Aufnahmen',
    'Recording Group'                                    => 'Aufnahmegruppe',
    'Recording Options'                                  => 'Aufnahmeoptionen',
    'Recording Priority'                                 => 'Aufnahmepriorität',
    'Recording Profile'                                  => 'Aufnahmeprofil',
    'Recording Schedules'                                => 'Aufnahmemodi',
    'Repeat'                                             => 'Wiederholung',
    'Saturday'                                           => 'Samstag',
    'Save'                                               => 'Speichern',
    'Save Schedule'                                      => 'Aufnahme speichern',
    'Schedule'                                           => 'Modus',
    'Schedule Manually'                                  => 'Manuell aufnehmen',
    'Schedule Options'                                   => 'Aufnahmemodus',
    'Schedule Override'                                  => 'manuelle Korrektur',
    'Schedule normally.'                                 => 'Sonderoption löschen',
    'Search'                                             => 'Suche',
    'Search Results'                                     => 'Suchergebnisse',
    'Settings'                                           => 'Einstellungen',
    'Start Early'                                        => 'vorzeitiger Aufnahmestart',
    'Subtitle'                                           => 'Untertitel',
    'Subtitle and Description'                           => 'Untertitel und Beschreibung',
    'Sunday'                                             => 'Sonntag',
    'The requested recording schedule has been deleted.' => 'Die geplante Aufnahme wurde gelöscht.',
    'Thursday'                                           => 'Donnerstag',
    'Title'                                              => 'Titel',
    'Transcoder'                                         => 'Umwandlungsprofil',
    'Tuesday'                                            => 'Dienstag',
    'Type'                                               => 'Typ',
    'Unknown'                                            => 'Unbekannt',
    'Upcoming Recordings'                                => '',
    'Update'                                             => 'Aktualisieren',
    'Update Recording Settings'                          => 'Speichern',
    'Weather'                                            => 'Wetter',
    'Wednesday'                                          => 'Mittwoch',
    'Yes'                                                => 'Ja',
    'airdate'                                            => 'Sendezeit',
    'channum'                                            => 'Sender',
    'description'                                        => 'Beschreibung',
    'generic_date'                                       => '%e.%m.%Y',
    'generic_time'                                       => '%H:%M',
    'length'                                             => 'Dauer',
    'minutes'                                            => 'Minuten',
    'recgroup'                                           => 'Aufnahmegruppe',
    'recpriority'                                        => 'Aufnahme- priorität',
    'rectype-long: always'                               => 'Jede Ausstrahlung aufnehmen',
    'rectype-long: channel'                              => 'Jede Ausstrahlung auf Sender $1 aufnehmen',
    'rectype-long: daily'                                => 'Täglich aufnehmen',
    'rectype-long: dontrec'                              => 'Nicht aufnehmen',
    'rectype-long: finddaily'                            => 'Suche Täglich',
    'rectype-long: findone'                              => 'Suche eine Ausstrahlung',
    'rectype-long: findweekly'                           => 'Suche Wöchentlich',
    'rectype-long: once'                                 => 'Einmalig aufnehmen',
    'rectype-long: override'                             => 'Sonderoption',
    'rectype-long: weekly'                               => 'Wöchentlich aufnehmen',
    'rectype: always'                                    => 'Immer',
    'rectype: channel'                                   => 'Sender',
    'rectype: daily'                                     => 'Täglich',
    'rectype: dontrec'                                   => 'Blockiert',
    'rectype: findone'                                   => 'Suche Eine',
    'rectype: once'                                      => 'Einmalig',
    'rectype: override'                                  => 'Sonderoption',
    'rectype: weekly'                                    => 'Wöchentlich',
    'subtitle'                                           => 'Untertitel',
    'title'                                              => 'Titel',
// includes/programs.php
    'CC'                           => '',
    'HDTV'                         => '',
    'Notes'                        => 'Hinweis',
    'Part $1 of $2'                => '',
    'Stereo'                       => '',
    'Subtitled'                    => '',
    'recstatus: cancelled'         => 'Abgebrochen',
    'recstatus: conflict'          => 'Konflikt',
    'recstatus: currentrecording'  => 'aktuelle Aufnahme',
    'recstatus: deleted'           => 'Gelöscht',
    'recstatus: earliershowing'    => 'frühere Ausstrahlung',
    'recstatus: force_record'      => 'Sonderoption',
    'recstatus: inactive'          => '',
    'recstatus: latershowing'      => 'spätere Ausstrahlung',
    'recstatus: lowdiskspace'      => 'kein Speicherplatz',
    'recstatus: manualoverride'    => 'manuell blockiert',
    'recstatus: neverrecord'       => 'niemals aufnehmen',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => 'frühere Aufnahme',
    'recstatus: recorded'          => 'Aufgenommen',
    'recstatus: recording'         => 'Aufnahme läuft',
    'recstatus: repeat'            => 'Wiederholung',
    'recstatus: stopped'           => 'Gestoppt',
    'recstatus: toomanyrecordings' => 'zu viele Aufnahmen',
    'recstatus: tunerbusy'         => 'TV-Karte belegt',
    'recstatus: unknown'           => 'Unbekannt',
    'recstatus: willrecord'        => 'wird aufgenommen',
// includes/recording_schedules.php
    'Dup Method'                   => 'Methode für Wdhgn.',
    'Profile'                      => 'Profil',
    'Sub and Desc (Empty matches)' => 'Untertitel & Beschr. (leere Ergebnisse)',
    'rectype: finddaily'           => 'Suche Täglich',
    'rectype: findweekly'          => 'Suche Wöchentlich',
// includes/utils.php
    '$1 B'  => '$1 B',
    '$1 GB' => '$1 GB',
    '$1 KB' => '$1 kB',
    '$1 MB' => '$1 MB',
    '$1 TB' => '$1 TB',
// modules/backend_log/init.php
    'Logs' => '',
// modules/movietimes/init.php
    'Movie Times' => '',
// modules/settings/init.php
    'MythTV channel info'      => '',
    'MythTV key bindings'      => '',
    'MythWeb session settings' => '',
    'settings'                 => '',
// modules/status/init.php
    'Status' => '',
// modules/stream/init.php
    'Streaming' => '',
// modules/tv/detail.php
    'This program is already scheduled to be recorded via a $1custom search$2.' => '',
    'Unknown Program.'                                                          => 'Unbekannte Sendung.',
    'Unknown Recording Schedule.'                                               => 'Unbekannter Aufnahmeplan',
// modules/tv/init.php
    'Special Searches' => '',
    'TV'               => '',
// modules/tv/recorded.php
    'No matching programs found.'             => '',
    'Showing all programs from the $1 group.' => '',
    'Showing all programs.'                   => '',
// modules/tv/schedules_custom.php
    'Any Category'                               => '',
    'Any Channel'                                => '',
    'Any Program Type'                           => '',
    'Find Time must be of the format:  HH:MM:SS' => '',
// modules/tv/schedules_manual.php
    'Use callsign'  => '',
    'Use date/time' => '',
// modules/tv/search.php
    'Please search for something.' => 'Bitte suchen Sie nach etwas.',
// modules/video/init.php
    'Video' => '',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => '',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => '',
// themes/default/header.php
    'Category Legend'                            => 'Kategorien',
    'Category Type'                              => 'Kategorietyp',
    'Custom'                                     => '',
    'Edit MythWeb and some MythTV settings.'     => 'Einstellungen für MythWeb & MythTV ändern',
    'Exact Match'                                => 'Exakte Übereinstimmung',
    'HD Only'                                    => 'nur in HDTV',
    'Manual'                                     => '',
    'MythMusic on the web.'                      => 'MythMusic',
    'MythVideo on the web.'                      => 'MythVideo',
    'MythWeb Weather.'                           => 'Wettervorhersage',
    'Search fields'                              => 'Suchfelder',
    'Search help'                                => 'Hilfe zur Suche',
    'Search help: movie example'                 => '*** 1/2 Abenteuer',
    'Search help: movie search'                  => 'Spielfilmsuche',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'reg. Ausdrücke',
    'Search options'                             => 'Suchoptionen',
    'Searches'                                   => 'Suchen',
    'TV functions, including recorded programs.' => 'TV Funktionen incl. allen Aufnahmen',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => '',
// themes/default/music/music.php
    'Album'               => 'Album',
    'Album (filtered)'    => 'Album (gefiltert)',
    'All Music'           => 'Alle Titel',
    'Artist'              => 'Interpret',
    'Artist (filtered)'   => 'Interpret (gefiltert)',
    'Displaying'          => 'Angezeigt',
    'Duration'            => 'Dauer',
    'End'                 => 'Ende',
    'Filtered'            => 'gefiltert',
    'Genre'               => 'Genre',
    'Genre (filtered)'    => 'Genre (gefiltert)',
    'Next'                => 'Nächste',
    'No Tracks Available' => 'Keine Titel verfügbar',
    'Previous'            => 'Vorherige',
    'Top'                 => 'Anfang',
    'Track Name'          => 'Titel',
    'Unfiltered'          => 'ungefiltert',
// themes/default/music/welcome.php
    'welcome: music' => '',
// themes/default/settings/channels.php
    'Configure Channels'                                                                                                                 => 'Sender einrichten',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Achtung! Falls diese Tabelle ohne das nötige Hintergrundwissen verändert wird, könnte MythTVs Funktionalität nachhaltig gestört werden.',
    'brightness'                                                                                                                         => 'Helligkeit',
    'callsign'                                                                                                                           => 'Kurzname',
    'colour'                                                                                                                             => 'Farbe',
    'commfree'                                                                                                                           => 'Werbefrei',
    'contrast'                                                                                                                           => 'Kontrast',
    'delete'                                                                                                                             => 'Löschen',
    'finetune'                                                                                                                           => 'Feinabstimmung',
    'freqid'                                                                                                                             => 'Kanal',
    'hue'                                                                                                                                => 'Farbton',
    'name'                                                                                                                               => 'Name',
    'sourceid'                                                                                                                           => 'Source ID',
    'useonairguide'                                                                                                                      => '',
    'videofilters'                                                                                                                       => 'Wiedergabefilter',
    'visible'                                                                                                                            => 'Sichtbar',
    'xmltvid'                                                                                                                            => '',
// themes/default/settings/keys.php
    'Action'                => 'Aktion',
    'Configure Keybindings' => 'Tastenbelegung konfigurieren',
    'Context'               => 'Kontext',
    'Destination'           => 'Ziel',
    'Edit keybindings on'   => 'Tastaturbelegung ändern für',
    'JumpPoints Editor'     => '',
    'Key bindings'          => 'Tastenbelegung',
    'Keybindings Editor'    => 'Tastenbelegung bearbeiten',
    'Set Host'              => 'Setze Host',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'Sender &quot;Gehe zu&quot;',
    'Date Formats'                    => 'Datumsformate',
    'Guide Settings'                  => 'EPG Einstellungen',
    'Hour Format'                     => 'Zeitformat',
    'Language'                        => 'Sprache',
    'Listing &quot;Jump to&quot;'     => 'TV Programm &quot;Gehe zu&quot;',
    'Listing Time Key'                => '',
    'MythWeb Session Settings'        => '',
    'MythWeb Theme'                   => 'MythWeb Thema',
    'Only display favourite channels' => 'Nur Favoriten anzeigen',
    'Reset'                           => 'Zurücksetzen',
    'SI Units?'                       => 'SI Einheiten?',
    'Scheduled Popup'                 => 'Aufnahmen Popup',
    'Show descriptions on new line'   => 'Beschreibungen in neuer Zeile anzeigen',
    'Status Bar'                      => 'Statuszeile',
    'Weather Icons'                   => 'Wetter Icons',
    'format help'                     => 'Format Hilfe',
// themes/default/settings/settings.php
    'settings: overview' => 'Einstellungen: Übersicht',
// themes/default/settings/welcome.php
    'welcome: settings' => '',
// themes/default/status/welcome.php
    'welcome: status' => '',
// themes/default/tv/channel.php
    'Channel Detail' => '',
    'Length'         => 'Dauer',
    'Show'           => 'Sendung',
    'Time'           => 'Zeit',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Zurück zum TV Programm',
    'Back to the recording schedules'     => 'Zurück zum Aufnahmeplan',
    'Cast'                                => 'Besetzung',
    'Directed by'                         => 'Regie',
    'Don\'t record this program.'         => 'Diese Sendung nicht aufnehmen',
    'Episode Number'                      => '',
    'Exec. Producer'                      => 'Produzent',
    'Find other showings of this program' => 'Andere Termine dieser Sendung finden',
    'Find showings of this program'       => 'Termine dieser Sendung finden',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Gaststar',
    'Guide rating'                        => '',
    'Hosted by'                           => '',
    'MythTV Status'                       => '',
    'Possible conflicts with this show'   => '',
    'Presented by'                        => 'Präsentiert von',
    'Produced by'                         => 'Produzent',
    'Program Detail'                      => 'Programmdetails',
    'Program ID'                          => '',
    'TV.com'                              => 'TV.com',
    'Time Stretch Default'                => 'Zeitraffer Vorgabewert',
    'What else is on at this time?'       => 'Was läuft noch zu dieser Zeit?',
    'Written by'                          => 'Geschrieben von',
// themes/default/tv/list.php
    'Jump To' => 'Gehe zu',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 Folge',
    '$1 episodes'                                         => '$1 Folgen',
    '$1 recording'                                        => '$1 Aufnahme',
    '$1 recordings'                                       => '$1 Aufnahmen',
    'All groups'                                          => '',
    'Are you sure you want to delete the following show?' => 'Diese Aufnahme wirklich löschen?',
    'Delete'                                              => 'Löschen',
    'Delete $1'                                           => 'Lösche &quot;$1&quot;',
    'Delete + Rerecord'                                   => 'Löschen und erneut aufnehmen',
    'Delete and rerecord $1'                              => 'Löschen und &quot;$1&quot; erneut aufnehmen',
    'Go'                                                  => 'Los',
    'Show group'                                          => 'Gruppe zeigen',
    'Show recordings'                                     => 'Aufnahmen zeigen',
    'auto-expire'                                         => 'autom. löschen',
    'file size'                                           => 'Dateigröße',
    'has bookmark'                                        => 'Position gesetzt',
    'has commflag'                                        => 'Werbung markiert',
    'has cutlist'                                         => 'Schnittliste',
    'is editing'                                          => 'wird bearbeitet',
    'preview'                                             => 'Vorschaubild',
// themes/default/tv/schedules.php
    'Any'                                       => 'Jeder',
    'No recording schedules have been defined.' => 'Keine Aufnahmen geplant.',
    'channel'                                   => 'Sender',
    'profile'                                   => 'Profil',
    'transcoder'                                => 'Umwandlungsprofil',
    'type'                                      => 'Modus',
// themes/default/tv/schedules_custom.php
    'Additional Tables'        => '',
    'Find Date & Time Options' => '',
    'Find Day'                 => '',
    'Find Time'                => '',
    'Keyword Search'           => '',
    'People Search'            => '',
    'Power Search'             => '',
    'Search Phrase'            => '',
    'Search Type'              => '',
    'Title Search'             => '',
// themes/default/tv/schedules_manual.php
    'Channel'      => 'Sender',
    'Length (min)' => 'Dauer (Min.)',
    'Start Date'   => 'Datum',
    'Start Time'   => 'Uhrzeit',
// themes/default/tv/search.php
    'No matches found'                 => 'Keine Übereinstimmungen gefunden',
    'No matching programs were found.' => '',
    'Search for:  $1'                  => 'Suche nach: $1',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => '',
    'handy: overview'           => 'Handy: Übersicht',
// themes/default/tv/upcoming.php
    'Commands'    => 'Optionen',
    'Conflicts'   => 'Überschneidungen',
    'Deactivated' => 'Deaktiviert',
    'Duplicates'  => 'Wiederholungen',
    'Scheduled'   => 'Geplant',
// themes/default/tv/welcome.php
    'welcome: tv' => '',
// themes/default/video/video.php
    'Edit'          => 'Bearbeiten',
    'Reverse Order' => 'Umsortieren',
    'Videos'        => 'Videos',
    'category'      => 'Kategorie',
    'cover'         => 'Titelbild',
    'director'      => 'Regisseur',
    'imdb rating'   => 'IMDB Bewertung',
    'plot'          => 'Handlung',
    'rating'        => 'Bewertung',
    'year'          => 'Jahr',
// themes/default/video/welcome.php
    'welcome: video' => '',
// themes/default/weather/weather.php
    ' at '               => ' um ',
    'Current Conditions' => 'Das aktuelle Wetter',
    'Forecast'           => 'Vorhersage',
    'High'               => 'Max',
    'Humidity'           => 'Luftfeuchtigkeit',
    'Last Updated'       => 'zuletzt aktualisiert',
    'Low'                => 'Min',
    'Pressure'           => 'Luftdruck',
    'Radar'              => 'Satellitenbild',
    'Today'              => 'Heute',
    'Tomorrow'           => 'Morgen',
    'UV Extreme'         => 'Extrem',
    'UV High'            => 'Hoch',
    'UV Index'           => 'UV Index',
    'UV Minimal'         => 'Minimal',
    'UV Moderate'        => 'Gemäßigt',
    'Visibility'         => 'Sichtweite',
    'Wind'               => 'Windgeschwindigkeit',
    'Wind Chill'         => 'gefühlte Temperatur',
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
$Categories['Action']         = array('Action',             '\\b(?:action|adven|abenteuer)');
$Categories['Adult']          = array('Erwachsene',         '\\b(?:adult|erot)');
$Categories['Animals']        = array('Tiere',              '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Kunst/Musik',        '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur|rock|volksmusik|jazz|videos)');
$Categories['Business']       = array('Wirtschaft',         '\\b(?:biz|busine)');
$Categories['Children']       = array('Kinder',             '\\b(?:child|kin?d|infan|animation|jugend)');
$Categories['Comedy']         = array('Comedy',             '\\b(?:comed|entertain|sitcom|ulk)');
$Categories['Crime_Mystery']  = array('Krimi/Mystery',      '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Dokumentation',      '\\b(?:do[ck]|gesellschaft)');
$Categories['Drama']          = array('Drama',              '\\b(?:drama)');
$Categories['Educational']    = array('Bildung',            '\\b(?:edu|bildung|interests)');
$Categories['Food']           = array('Essen',              '\\b(?:food|cook|essen|[dt]rink|kochen)');
$Categories['Game']           = array('Spiele',             '\\b(?:game|spiel|quiz)');
$Categories['Health_Medical'] = array('Gesundheit/Medizin', '\\b(?:health|medi[cz]|gesundheit)');
$Categories['History']        = array('Geschichte',         '\\b(?:hist|geschichte)');
$Categories['Horror']         = array('Horror',             '\\b(?:horror)');
$Categories['HowTo']          = array('HowTo',              '\\b(?:how|home|house|garden|ratgeber)');
$Categories['Misc']           = array('Versch.',            '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nachrichten',        '\\b(?:news|nachrichten|current|magazin|bericht)');
$Categories['Reality']        = array('Reality',            '\\b(?:reality)');
$Categories['Romance']        = array('Romantik',           '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Science Fiction/Fantasy',      '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Science_Nature'] = array('Wissenschaft/Natur', '\\b(?:science|nature|environment|wissenschaft|natur)');
$Categories['Shopping']       = array('Shopping',           '\\b(?:shop)');
$Categories['Soaps']          = array('Serien',             '\\b(?:soap|reihe|serie)');
$Categories['Spiritual']      = array('Spiritual',          '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',              '\\b(?:sport|deportes|futbol|fussball)');
$Categories['Talk']           = array('Talk',               '\\b(?:talk|interview)');
$Categories['Travel']         = array('Reisen',             '\\b(?:travel|reisen|touris|auto)');
$Categories['War']            = array('Krieg',              '\\b(?:war|krieg)');
$Categories['Western']        = array('Western',            '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Unbekannt');
$Categories['movie']          = array('Film',               '\\b(?:film)');

