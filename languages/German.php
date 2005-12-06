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
    ' at '                                                => ' um ',
    '$1 Rating'                                           => 'Bewertung $1',
    '$1 episode'                                          => '$1 Folge',
    '$1 episodes'                                         => '$1 Folgen',
    '$1 hr'                                               => '$1 Std.',
    '$1 hrs'                                              => '$1 Std.',
    '$1 min'                                              => '$1 Min.',
    '$1 mins'                                             => '$1 Min.',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'     => '$1 Aufnahmen, belegen $2 ($3) von $4.',
    '$1 recording'                                        => '$1 Aufnahme',
    '$1 recordings'                                       => '$1 Aufnahmen',
    '$1 to $2'                                            => '$1 bis $2',
    'Activate'                                            => 'Aktivieren',
    'Advanced Options'                                    => 'Erweiterte Optionen',
    'Airtime'                                             => 'Sendezeit',
    'All recordings'                                      => 'Alle Aufnahmen',
    'Are you sure you want to delete the following show?' => 'Diese Aufnahme wirklich löschen?',
    'Auto-expire recordings'                              => 'Aufnahmen autom. löschen',
    'Auto-flag commercials'                               => 'Werbung markieren',
    'Auto-transcode'                                      => 'autom. Umwandeln',
    'Back to the program listing'                         => 'Zurück zum TV Programm',
    'Back to the recording schedules'                     => 'Zurück zum Aufnahmeplan',
    'Backend Logs'                                        => '',
    'Backend Status'                                      => 'Backend Status',
    'Cancel this schedule.'                               => 'Aufnahme abbrechen',
    'Cast'                                                => 'Besetzung',
    'Category'                                            => 'Kategorie',
    'Category Legend'                                     => 'Kategorien',
    'Category Type'                                       => 'Kategorietyp',
    'Channel'                                             => 'Sender',
    'Check for duplicates in'                             => 'Nach Wdhgn. suchen in',
    'Commands'                                            => 'Optionen',
    'Conflicts'                                           => 'Überschneidungen',
    'Create Schedule'                                     => 'Speichern',
    'Current Conditions'                                  => 'Das aktuelle Wetter',
    'Current recordings'                                  => 'Aktuelle Aufnahmen',
    'Currently Browsing:  $1'                             => 'Aktuell: $1',
    'Date'                                                => 'Datum',
    'Deactivated'                                         => 'Deaktiviert',
    'Default'                                             => 'Standard',
    'Delete'                                              => 'Löschen',
    'Delete $1'                                           => 'Lösche &quot;$1&quot;',
    'Delete + Rerecord'                                   => 'Löschen und erneut aufnehmen',
    'Delete and rerecord $1'                              => 'Löschen und &quot;$1&quot; erneut aufnehmen',
    'Description'                                         => 'Beschreibung',
    'Details for'                                         => 'Details für',
    'Directed by'                                         => 'Regie',
    'Display'                                             => 'Anzeigen',
    'Don\'t Record'                                       => 'Nicht aufnehmen',
    'Don\'t record this program.'                         => 'Diese Sendung nicht aufnehmen',
    'Duplicate Check method'                              => 'Testmethode für Wdhgn.',
    'Duplicates'                                          => 'Wiederholungen',
    'Edit MythWeb and some MythTV settings.'              => 'Einstellungen für MythWeb & MythTV ändern',
    'End Late'                                            => 'verspätetes Aufnahmeende',
    'Episode'                                             => 'Folge',
    'Exact Match'                                         => 'Exakte Übereinstimmung',
    'Exec. Producer'                                      => 'Produzent',
    'Find other showings of this program'                 => 'Andere Termine dieser Sendung finden',
    'Find showings of this program'                       => 'Termine dieser Sendung finden',
    'Forecast'                                            => 'Vorhersage',
    'Forget Old'                                          => 'frühere Aufnahmen vergessen',
    'Friday'                                              => 'Freitag',
    'Go'                                                  => 'Los',
    'Google'                                              => 'Google',
    'Guest Starring'                                      => 'Gaststar',
    'Guide rating'                                        => '',
    'HD Only'                                             => 'nur in HDTV',
    'High'                                                => 'Max',
    'Hosted by'                                           => '',
    'Hour'                                                => 'Stunde',
    'Humidity'                                            => 'Luftfeuchtigkeit',
    'IMDB'                                                => 'IMDB',
    'Inactive'                                            => 'Inaktiv',
    'Jump'                                                => 'Gehe',
    'Jump To'                                             => 'Gehe zu',
    'Jump to'                                             => 'Gehe zu',
    'Last Updated'                                        => 'zuletzt aktualisiert',
    'Length (min)'                                        => 'Dauer (Min.)',
    'Listings'                                            => 'TV Programm',
    'Low'                                                 => 'Min',
    'Manually Schedule'                                   => 'manuelle Aufnahme',
    'Monday'                                              => 'Montag',
    'Music'                                               => 'Musik',
    'MythMusic on the web.'                               => 'MythMusic',
    'MythVideo on the web.'                               => 'MythVideo',
    'MythWeb Weather.'                                    => 'Wettervorhersage',
    'Never Record'                                        => 'Niemals aufnehmen',
    'No'                                                  => 'Nein',
    'No. of recordings to keep'                           => 'Wieviele Aufnahmen behalten',
    'None'                                                => 'Keine',
    'Notes'                                               => 'Hinweis',
    'Only New Episodes'                                   => 'Nur neue Folgen',
    'Original Airdate'                                    => 'Produktion',
    'Please search for something.'                        => 'Bitte suchen Sie nach etwas.',
    'Presented by'                                        => 'Präsentiert von',
    'Pressure'                                            => 'Luftdruck',
    'Previous recordings'                                 => 'Alte Aufnahmen',
    'Produced by'                                         => 'Produzent',
    'Program Detail'                                      => 'Programmdetails',
    'Program Listing'                                     => 'TV Programm',
    'Radar'                                               => 'Satellitenbild',
    'Rating'                                              => 'Freigegeben ab',
    'Record This'                                         => 'Diese Sendung aufnehmen',
    'Record new and expire old'                           => 'Nur neue Folgen aufnehmen',
    'Recorded Programs'                                   => 'Aufnahmen',
    'Recording Group'                                     => 'Aufnahmegruppe',
    'Recording Options'                                   => 'Aufnahmeoptionen',
    'Recording Priority'                                  => 'Aufnahmepriorität',
    'Recording Profile'                                   => 'Aufnahmeprofil',
    'Recording Schedules'                                 => 'Aufnahmemodi',
    'Rerun'                                               => 'Wiederholung',
    'Saturday'                                            => 'Samstag',
    'Save'                                                => 'Speichern',
    'Schedule'                                            => 'Modus',
    'Schedule Options'                                    => 'Aufnahmemodus',
    'Schedule Override'                                   => 'manuelle Korrektur',
    'Schedule normally.'                                  => 'Sonderoption löschen',
    'Scheduled'                                           => 'Geplant',
    'Scheduled Recordings'                                => 'Aufnahmeplan',
    'Search'                                              => 'Suche',
    'Search Results'                                      => 'Suchergebnisse',
    'Search fields'                                       => 'Suchfelder',
    'Search help'                                         => 'Hilfe zur Suche',
    'Search help: movie example'                          => '*** 1/2 Abenteuer',
    'Search help: movie search'                           => 'Spielfilmsuche',
    'Search help: regex example'                          => '/^Good Eats/',
    'Search help: regex search'                           => 'reg. Ausdrücke',
    'Search options'                                      => 'Suchoptionen',
    'Searches'                                            => 'Suchen',
    'Settings'                                            => 'Einstellungen',
    'Show group'                                          => 'Gruppe zeigen',
    'Show recordings'                                     => 'Aufnahmen zeigen',
    'Start Date'                                          => 'Datum',
    'Start Early'                                         => 'vorzeitiger Aufnahmestart',
    'Start Time'                                          => 'Uhrzeit',
    'Subtitle'                                            => 'Untertitel',
    'Subtitle and Description'                            => 'Untertitel und Beschreibung',
    'Sunday'                                              => 'Sonntag',
    'TV functions, including recorded programs.'          => 'TV Funktionen incl. allen Aufnahmen',
    'TV.com'                                              => 'TV.com',
    'The requested recording schedule has been deleted.'  => 'Die geplante Aufnahme wurde gelöscht.',
    'Thursday'                                            => 'Donnerstag',
    'Time Stretch Default'                                => 'Zeitraffer Vorgabewert',
    'Title'                                               => 'Titel',
    'Today'                                               => 'Heute',
    'Tomorrow'                                            => 'Morgen',
    'Transcoder'                                          => 'Umwandlungsprofil',
    'Tuesday'                                             => 'Dienstag',
    'UV Extreme'                                          => 'Extrem',
    'UV High'                                             => 'Hoch',
    'UV Index'                                            => 'UV Index',
    'UV Minimal'                                          => 'Minimal',
    'UV Moderate'                                         => 'Gemäßigt',
    'Unknown'                                             => 'Unbekannt',
    'Unknown Program.'                                    => 'Unbekannte Sendung.',
    'Unknown Recording Schedule.'                         => 'Unbekannter Aufnahmeplan',
    'Upcoming Recordings'                                 => '',
    'Update'                                              => 'Aktualisieren',
    'Update Recording Settings'                           => 'Speichern',
    'Visibility'                                          => 'Sichtweite',
    'Weather'                                             => 'Wetter',
    'Wednesday'                                           => 'Mittwoch',
    'What else is on at this time?'                       => 'Was läuft noch zu dieser Zeit?',
    'Wind'                                                => 'Windgeschwindigkeit',
    'Wind Chill'                                          => 'gefühlte Temperatur',
    'Written by'                                          => 'Geschrieben von',
    'Yes'                                                 => 'Ja',
    'airdate'                                             => 'Sendezeit',
    'auto-expire'                                         => 'autom. löschen',
    'channum'                                             => 'Sender',
    'description'                                         => 'Beschreibung',
    'file size'                                           => 'Dateigröße',
    'generic_date'                                        => '%e.%m.%Y',
    'generic_time'                                        => '%H:%M',
    'has bookmark'                                        => 'Position gesetzt',
    'has commflag'                                        => 'Werbung markiert',
    'has cutlist'                                         => 'Schnittliste',
    'is editing'                                          => 'wird bearbeitet',
    'length'                                              => 'Dauer',
    'minutes'                                             => 'Minuten',
    'preview'                                             => 'Vorschaubild',
    'recgroup'                                            => 'Aufnahmegruppe',
    'recpriority'                                         => 'Aufnahme- priorität',
    'rectype-long: always'                                => 'Jede Ausstrahlung aufnehmen',
    'rectype-long: channel'                               => 'Jede Ausstrahlung auf Sender $1 aufnehmen',
    'rectype-long: daily'                                 => 'Täglich aufnehmen',
    'rectype-long: dontrec'                               => 'Nicht aufnehmen',
    'rectype-long: finddaily'                             => 'Suche Täglich',
    'rectype-long: findone'                               => 'Suche eine Ausstrahlung',
    'rectype-long: findweekly'                            => 'Suche Wöchentlich',
    'rectype-long: once'                                  => 'Einmalig aufnehmen',
    'rectype-long: override'                              => 'Sonderoption',
    'rectype-long: weekly'                                => 'Wöchentlich aufnehmen',
    'rectype: always'                                     => 'Immer',
    'rectype: channel'                                    => 'Sender',
    'rectype: daily'                                      => 'Täglich',
    'rectype: dontrec'                                    => 'Blockiert',
    'rectype: findone'                                    => 'Suche Eine',
    'rectype: once'                                       => 'Einmalig',
    'rectype: override'                                   => 'Sonderoption',
    'rectype: weekly'                                     => 'Wöchentlich',
    'subtitle'                                            => 'Untertitel',
    'title'                                               => 'Titel',
// includes/programs.php
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
    'Type'                         => 'Typ',
    'rectype: finddaily'           => 'Suche Täglich',
    'rectype: findweekly'          => 'Suche Wöchentlich',
// includes/utils.php
    '$1 B'  => '$1 B',
    '$1 GB' => '$1 GB',
    '$1 KB' => '$1 kB',
    '$1 MB' => '$1 MB',
    '$1 TB' => '$1 TB',
// modules/movietimes/init.php
    'Movie Times' => '',
// modules/settings/init.php
    'settings' => '',
// modules/status/init.php
    'Status' => '',
// modules/tv/init.php
    'Search TV'        => '',
    'Special Searches' => '',
    'TV'               => '',
// modules/video/init.php
    'Video' => '',
// themes/.../canned_searches.php
    'handy: overview' => 'Handy: Übersicht',
// themes/.../channel_detail.php
    'Length' => 'Dauer',
    'Show'   => 'Sendung',
    'Time'   => 'Zeit',
// themes/.../music.php
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
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profilgruppen',
    'Recording profiles' => 'Aufnahmeprofile',
// themes/.../recording_schedules.php
    'Any'                                       => 'Jeder',
    'No recording schedules have been defined.' => 'Keine Aufnahmen geplant.',
    'channel'                                   => 'Sender',
    'profile'                                   => 'Profil',
    'transcoder'                                => 'Umwandlungsprofil',
    'type'                                      => 'Modus',
// themes/.../schedule_manually.php
    'Save Schedule'     => 'Aufnahme speichern',
    'Schedule Manually' => 'Manuell aufnehmen',
// themes/.../search.php
    'No matches found' => 'Keine Übereinstimmungen gefunden',
    'Search for:  $1'  => 'Suche nach: $1',
// themes/.../settings.php
    'Channels'           => 'Sender',
    'Configure'          => 'Konfigurieren',
    'Key Bindings'       => 'Tastenbelegung',
    'MythWeb Settings'   => 'MythWeb Einstellungen',
    'settings: overview' => 'Einstellungen: Übersicht',
// themes/.../settings_channels.php
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
// themes/.../settings_keys.php
    'Action'                => 'Aktion',
    'Configure Keybindings' => 'Tastenbelegung konfigurieren',
    'Context'               => 'Kontext',
    'Destination'           => 'Ziel',
    'Edit keybindings on'   => 'Tastaturbelegung ändern für',
    'JumpPoints Editor'     => '',
    'Key bindings'          => 'Tastenbelegung',
    'Keybindings Editor'    => 'Tastenbelegung bearbeiten',
    'Set Host'              => 'Setze Host',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'Sender &quot;Gehe zu&quot;',
    'Date Formats'                    => 'Datumsformate',
    'Guide Settings'                  => 'EPG Einstellungen',
    'Hour Format'                     => 'Zeitformat',
    'Language'                        => 'Sprache',
    'Listing &quot;Jump to&quot;'     => 'TV Programm &quot;Gehe zu&quot;',
    'Listing Time Key'                => '',
    'MythWeb Theme'                   => 'MythWeb Thema',
    'Only display favourite channels' => 'Nur Favoriten anzeigen',
    'Reset'                           => 'Zurücksetzen',
    'SI Units?'                       => 'SI Einheiten?',
    'Scheduled Popup'                 => 'Aufnahmen Popup',
    'Show descriptions on new line'   => 'Beschreibungen in neuer Zeile anzeigen',
    'Status Bar'                      => 'Statuszeile',
    'Weather Icons'                   => 'Wetter Icons',
    'format help'                     => 'Format Hilfe',
// themes/.../video.php
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
// themes/default/backend_log/welcome.php
    'Show the server logs.' => '',
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

