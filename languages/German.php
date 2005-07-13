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
    ' at '                                                                                                                               => ' um ',
    '$1 B'                                                                                                                               => '',
    '$1 GB'                                                                                                                              => '',
    '$1 KB'                                                                                                                              => '',
    '$1 MB'                                                                                                                              => '',
    '$1 Rating'                                                                                                                          => 'Bewertung $1',
    '$1 TB'                                                                                                                              => '',
    '$1 episode'                                                                                                                         => '$1 Folge',
    '$1 episodes'                                                                                                                        => '$1 Folgen',
    '$1 hr'                                                                                                                              => '$1 Std.',
    '$1 hrs'                                                                                                                             => '$1 Std.',
    '$1 min'                                                                                                                             => '$1 Min.',
    '$1 mins'                                                                                                                            => '$1 Min.',
    '$1 programs, using $2 ($3) out of $4.'                                                                                              => '$1 Aufnahmen, belegen $2 ($3) von $4.',
    '$1 recording'                                                                                                                       => '$1 Aufnahme',
    '$1 recordings'                                                                                                                      => '$1 Aufnahmen',
    '$1 to $2'                                                                                                                           => '$1 bis $2',
    'Activate'                                                                                                                           => 'Aktivieren',
    'Advanced Options'                                                                                                                   => 'Erweiterte Optionen',
    'Airtime'                                                                                                                            => 'Sendezeit',
    'All recordings'                                                                                                                     => 'Alle Aufnahmen',
    'Any'                                                                                                                                => 'Jeder',
    'Are you sure you want to delete the following show?'                                                                                => 'Diese Aufnahme sicher löschen?',
    'Auto-expire recordings'                                                                                                             => 'Aufnahmen autom. löschen',
    'Auto-flag commercials'                                                                                                              => 'Werbung markieren',
    'Auto-transcode'                                                                                                                     => '',
    'Back to the program listing'                                                                                                        => 'Zurück zum TV Programm',
    'Back to the recording schedules'                                                                                                    => 'Zurück zum Aufnahmeplan',
    'Backend Status'                                                                                                                     => 'Backend Status',
    'Cancel this schedule.'                                                                                                              => 'Aufnahme abbrechen',
    'Cast'                                                                                                                               => 'Besetzung',
    'Category'                                                                                                                           => 'Kategorie',
    'Category Legend'                                                                                                                    => 'Kategorien',
    'Category Type'                                                                                                                      => 'Kategorietyp',
    'Channel'                                                                                                                            => 'Sender',
    'Channel &quot;Jump to&quot;'                                                                                                        => 'Sender &quot;Gehe zu&quot;',
    'Channels'                                                                                                                           => 'Sender',
    'Check for duplicates in'                                                                                                            => 'Nach Wdhgn. suchen in',
    'Commands'                                                                                                                           => 'Optionen',
    'Configure'                                                                                                                          => 'Konfigurieren',
    'Conflicts'                                                                                                                          => 'Überschneidungen',
    'Create Schedule'                                                                                                                    => '',
    'Current Conditions'                                                                                                                 => 'Das aktuelle Wetter',
    'Current recordings'                                                                                                                 => 'Aktuelle Aufnahmen',
    'Currently Browsing:  $1'                                                                                                            => 'Aktuell: $1',
    'Date'                                                                                                                               => 'Datum',
    'Date Formats'                                                                                                                       => 'Datumsformate',
    'Deactivated'                                                                                                                        => 'Deaktiviert',
    'Default'                                                                                                                            => 'Standard',
    'Delete'                                                                                                                             => 'Löschen',
    'Delete + Rerecord'                                                                                                                  => '',
    'Description'                                                                                                                        => 'Beschreibung',
    'Directed by'                                                                                                                        => 'Regie',
    'Display'                                                                                                                            => 'Anzeigen',
    'Don\'t Record'                                                                                                                      => 'Nicht aufnehmen',
    'Don\'t record this program.'                                                                                                        => 'Diese Sendung nicht aufnehmen',
    'Dup Method'                                                                                                                         => 'Methode für Wdhgn.',
    'Duplicate Check method'                                                                                                             => 'Testmethode für Wdhgn.',
    'Duplicates'                                                                                                                         => 'Wiederholungen',
    'Edit MythWeb and some MythTV settings.'                                                                                             => 'MythWeb & einige MythTV Einstellungen ändern.',
    'Edit keybindings on'                                                                                                                => 'Tastaturbelegung ändern für',
    'End Late'                                                                                                                           => 'verspätetes Aufnahmeende',
    'Episode'                                                                                                                            => 'Folge',
    'Exact Match'                                                                                                                        => 'Exakte Übereinstimmung',
    'Exec. Producer'                                                                                                                     => 'Produzent',
    'Find other showings of this program'                                                                                                => 'Andere Termine dieser Sendung finden',
    'Find showings of this program'                                                                                                      => 'Termine dieser Sendung finden',
    'Forecast'                                                                                                                           => 'Vorhersage',
    'Forget Old'                                                                                                                         => '',
    'Friday'                                                                                                                             => 'Freitag',
    'Go'                                                                                                                                 => 'Los',
    'Google'                                                                                                                             => '',
    'Guest Starring'                                                                                                                     => 'Gaststar',
    'Guide Settings'                                                                                                                     => '',
    'HD Only'                                                                                                                            => '',
    'High'                                                                                                                               => 'Max',
    'Hosted by'                                                                                                                          => '',
    'Hour'                                                                                                                               => 'Stunde',
    'Hour Format'                                                                                                                        => 'Zeitformat',
    'Humidity'                                                                                                                           => 'Luftfeuchtigkeit',
    'IMDB'                                                                                                                               => '',
    'Inactive'                                                                                                                           => 'Inaktiv',
    'Jump'                                                                                                                               => 'Gehe',
    'Jump To'                                                                                                                            => 'Gehe zu',
    'Jump to'                                                                                                                            => 'Gehe zu',
    'Key Bindings'                                                                                                                       => 'Tastenbelegung',
    'Language'                                                                                                                           => 'Sprache',
    'Last Updated'                                                                                                                       => 'zuletzt aktualisiert',
    'Length'                                                                                                                             => 'Dauer',
    'Length (min)'                                                                                                                       => 'Dauer (Min.)',
    'Listing &quot;Jump to&quot;'                                                                                                        => 'Liste &quot;Gehe zu&quot;',
    'Listing Time Key'                                                                                                                   => '',
    'Listings'                                                                                                                           => 'TV Programm',
    'Low'                                                                                                                                => 'Min',
    'Manually Schedule'                                                                                                                  => 'manuelle Aufnahme',
    'Monday'                                                                                                                             => 'Montag',
    'MythMusic on the web.'                                                                                                              => 'MythMusic im Internet.',
    'MythVideo on the web.'                                                                                                              => 'MythVideo im Internet.',
    'MythWeb Settings'                                                                                                                   => 'MythWeb Einstellungen',
    'MythWeb Theme'                                                                                                                      => 'MythWeb Thema',
    'MythWeb Weather.'                                                                                                                   => 'MythWeb Wetter.',
    'Never Record'                                                                                                                       => 'Niemals aufnehmen',
    'No'                                                                                                                                 => 'Nein',
    'No matches found'                                                                                                                   => 'Keine Übereinstimmungen gefunden',
    'No recording schedules have been defined.'                                                                                          => '',
    'No. of recordings to keep'                                                                                                          => 'Wieviele Aufnahmen behalten',
    'None'                                                                                                                               => 'Keine',
    'Notes'                                                                                                                              => 'Hinweis',
    'Only New Episodes'                                                                                                                  => 'Nur neue Folgen',
    'Only display favourite channels'                                                                                                    => '',
    'Original Airdate'                                                                                                                   => 'Produktion',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Achtung! Falls diese Tabelle ohne das nötige Hintergrundwissen verändert wird, könnte MythTVs Funktionalität nachhaltig gestört werden.',
    'Please search for something.'                                                                                                       => '',
    'Presented by'                                                                                                                       => 'Präsentiert von',
    'Pressure'                                                                                                                           => 'Luftdruck',
    'Previous recordings'                                                                                                                => 'Alte Aufnahmen',
    'Produced by'                                                                                                                        => 'Produzent',
    'Profile'                                                                                                                            => 'Profil',
    'Profile Groups'                                                                                                                     => 'Profilgruppen',
    'Radar'                                                                                                                              => 'Satellitenbild',
    'Rating'                                                                                                                             => 'Freigegeben ab',
    'Record This'                                                                                                                        => 'Diese Sendung aufnehmen',
    'Record new and expire old'                                                                                                          => 'Nur neue Folgen aufnehmen',
    'Recorded Programs'                                                                                                                  => 'Aufnahmen',
    'Recording Group'                                                                                                                    => 'Aufnahmegruppe',
    'Recording Options'                                                                                                                  => 'Aufnahmeoptionen',
    'Recording Priority'                                                                                                                 => 'Aufnahmepriorität',
    'Recording Profile'                                                                                                                  => 'Aufnahmeprofil',
    'Recording Schedules'                                                                                                                => 'Aufnahmemodi',
    'Recording profiles'                                                                                                                 => 'Aufnahmeprofile',
    'Rerun'                                                                                                                              => 'Wiederholung',
    'Reset'                                                                                                                              => 'Zurücksetzen',
    'SI Units?'                                                                                                                          => '',
    'Saturday'                                                                                                                           => 'Samstag',
    'Save'                                                                                                                               => 'Speichern',
    'Save Schedule'                                                                                                                      => '',
    'Schedule'                                                                                                                           => 'Modus',
    'Schedule Options'                                                                                                                   => 'Aufnahmeoptionen',
    'Schedule Override'                                                                                                                  => 'manuelle Korrektur',
    'Schedule normally.'                                                                                                                 => 'Sonderoption löschen',
    'Scheduled'                                                                                                                          => 'Geplant',
    'Scheduled Popup'                                                                                                                    => 'Aufnahmen Popup',
    'Scheduled Recordings'                                                                                                               => 'Aufnahmeplan',
    'Search'                                                                                                                             => 'Suche',
    'Search Results'                                                                                                                     => 'Suchergebnisse',
    'Search fields'                                                                                                                      => '',
    'Search for:  $1'                                                                                                                    => '',
    'Search help'                                                                                                                        => '',
    'Search help: movie example'                                                                                                         => '*** 1/2 Adventure',
    'Search help: movie search'                                                                                                          => 'movie search',
    'Search help: regex example'                                                                                                         => '/^Good Eats/',
    'Search help: regex search'                                                                                                          => 'regex search',
    'Search options'                                                                                                                     => '',
    'Searches'                                                                                                                           => '',
    'Settings'                                                                                                                           => 'Einstellungen',
    'Show'                                                                                                                               => 'Sendung',
    'Show descriptions on new line'                                                                                                      => 'Beschreibungen in neuer Zeile anzeigen',
    'Show group'                                                                                                                         => 'Gruppe zeigen',
    'Show recordings'                                                                                                                    => 'Aufnahmen zeigen',
    'Start Date'                                                                                                                         => 'Datum',
    'Start Early'                                                                                                                        => 'vorzeitiger Aufnahmestart',
    'Start Time'                                                                                                                         => 'Uhrzeit',
    'Status Bar'                                                                                                                         => 'Statuszeile',
    'Sub and Desc (Empty matches)'                                                                                                       => 'Untertitel & Beschr. (leere Ergebnisse)',
    'Subtitle'                                                                                                                           => 'Untertitel',
    'Subtitle and Description'                                                                                                           => 'Untertitel und Beschreibung',
    'Sunday'                                                                                                                             => 'Sonntag',
    'TV functions, including recorded programs.'                                                                                         => 'TV Funktionen, mit allen Aufnahmen.',
    'TVTome'                                                                                                                             => '',
    'The requested recording schedule has been deleted.'                                                                                 => 'Die geplante Aufnahme wurde gel�scht.',
    'Thursday'                                                                                                                           => 'Donnerstag',
    'Time'                                                                                                                               => 'Zeit',
    'Title'                                                                                                                              => 'Titel',
    'Today'                                                                                                                              => 'Heute',
    'Tomorrow'                                                                                                                           => 'Morgen',
    'Transcoder'                                                                                                                         => '',
    'Tuesday'                                                                                                                            => 'Dienstag',
    'Type'                                                                                                                               => 'Typ',
    'UV Extreme'                                                                                                                         => 'Extrem',
    'UV High'                                                                                                                            => 'Hoch',
    'UV Index'                                                                                                                           => 'UV Index',
    'UV Minimal'                                                                                                                         => 'Minimal',
    'UV Moderate'                                                                                                                        => 'Gemäßigt',
    'Unknown'                                                                                                                            => 'Unbekannt',
    'Unknown Program.'                                                                                                                   => 'Unbekannte Sendung.',
    'Unknown Recording Schedule.'                                                                                                        => '',
    'Update'                                                                                                                             => '',
    'Update Recording Settings'                                                                                                          => 'Aufnahmeoptionen speichern',
    'Visibility'                                                                                                                         => 'Sichtweite',
    'Weather Icons'                                                                                                                      => '',
    'Wednesday'                                                                                                                          => 'Mittwoch',
    'What else is on at this time?'                                                                                                      => 'Was läuft noch zu dieser Zeit?',
    'Wind'                                                                                                                               => 'Windgeschwindigkeit',
    'Wind Chill'                                                                                                                         => 'gefühlte Temperatur',
    'Written by'                                                                                                                         => 'Geschrieben von',
    'Yes'                                                                                                                                => 'Ja',
    'airdate'                                                                                                                            => 'Sendezeit',
    'auto-expire'                                                                                                                        => 'autom. löschen',
    'channel'                                                                                                                            => '',
    'channum'                                                                                                                            => 'Sender',
    'description'                                                                                                                        => 'Beschreibung',
    'file size'                                                                                                                          => 'Dateigröße',
    'format help'                                                                                                                        => 'Format Hilfe',
    'generic_date'                                                                                                                       => '%e.%m.%Y',
    'generic_time'                                                                                                                       => '%H:%M',
    'handy: overview'                                                                                                                    => '',
    'has bookmark'                                                                                                                       => 'Position gesetzt',
    'has commflag'                                                                                                                       => 'Werbung markiert',
    'has cutlist'                                                                                                                        => 'Schnittliste',
    'is editing'                                                                                                                         => 'wird bearbeitet',
    'length'                                                                                                                             => 'Dauer',
    'minutes'                                                                                                                            => 'Minuten',
    'preview'                                                                                                                            => 'Vorschaubild',
    'profile'                                                                                                                            => 'Profil',
    'recgroup'                                                                                                                           => 'Aufnahmegruppe',
    'recstatus: cancelled'                                                                                                               => 'Abgebrochen',
    'recstatus: conflict'                                                                                                                => 'Konflikt',
    'recstatus: currentrecording'                                                                                                        => '',
    'recstatus: deleted'                                                                                                                 => 'Gelöscht',
    'recstatus: earliershowing'                                                                                                          => 'frühere Ausstrahlung',
    'recstatus: force_record'                                                                                                            => '',
    'recstatus: latershowing'                                                                                                            => 'spätere Ausstrahlung',
    'recstatus: lowdiskspace'                                                                                                            => 'kein Speicherplatz',
    'recstatus: manualoverride'                                                                                                          => 'manuell blockiert',
    'recstatus: overlap'                                                                                                                 => 'Konflikt',
    'recstatus: previousrecording'                                                                                                       => '',
    'recstatus: recorded'                                                                                                                => 'Aufgenommen',
    'recstatus: recording'                                                                                                               => 'Aufnahme läuft',
    'recstatus: repeat'                                                                                                                  => 'Wiederholung',
    'recstatus: stopped'                                                                                                                 => 'Gestoppt',
    'recstatus: toomanyrecordings'                                                                                                       => 'zu viele Aufnahmen',
    'recstatus: tunerbusy'                                                                                                               => 'TV-Karte belegt',
    'recstatus: unknown'                                                                                                                 => 'Unbekannt',
    'recstatus: willrecord'                                                                                                              => 'wird aufgenommen',
    'rectype-long: always'                                                                                                               => 'Jede Ausstrahlung aufnehmen',
    'rectype-long: channel'                                                                                                              => 'Jede Ausstrahlung auf Sender $1 aufnehmen',
    'rectype-long: daily'                                                                                                                => 'Täglich aufnehmen',
    'rectype-long: dontrec'                                                                                                              => 'Nicht aufnehmen',
    'rectype-long: finddaily'                                                                                                            => 'Suche Täglich',
    'rectype-long: findone'                                                                                                              => 'Suche eine Ausstrahlung',
    'rectype-long: findweekly'                                                                                                           => 'Suche Wöchentlich',
    'rectype-long: once'                                                                                                                 => 'Einmalige Aufnahme',
    'rectype-long: override'                                                                                                             => 'Sonderoption',
    'rectype-long: weekly'                                                                                                               => 'Wöchentlich aufnehmen',
    'rectype: always'                                                                                                                    => 'Immer',
    'rectype: channel'                                                                                                                   => 'Sender',
    'rectype: daily'                                                                                                                     => 'Täglich',
    'rectype: dontrec'                                                                                                                   => 'Blockiert',
    'rectype: finddaily'                                                                                                                 => 'Suche Täglich',
    'rectype: findone'                                                                                                                   => 'Suche Eine',
    'rectype: findweekly'                                                                                                                => 'Suche Wöchentlich',
    'rectype: once'                                                                                                                      => 'Einmalig',
    'rectype: override'                                                                                                                  => 'Sonderoption',
    'rectype: weekly'                                                                                                                    => 'Wöchentlich',
    'settings: overview'                                                                                                                 => 'Einstellungen: Übersicht',
    'subtitle'                                                                                                                           => 'Untertitel',
    'title'                                                                                                                              => 'Titel',
    'type'                                                                                                                               => 'Modus',
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
$Categories['Action']         = array('Action',             '\\b(?:action|adven)');
$Categories['Adult']          = array('Erwachsene',              '\\b(?:adult|erot)');
$Categories['Animals']        = array('Tiere',              '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Kunst/Musik',          '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur|rock)');
$Categories['Business']       = array('Wirtschaft',           '\\b(?:biz|busine)');
$Categories['Children']       = array('Kinder',             '\\b(?:child|kin?d|infan|animation)');
$Categories['Comedy']         = array('Comedy',             '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Krimi/Mystery',      '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Dokumentation',        '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',              '\\b(?:drama)');
$Categories['Educational']    = array('Bildung',            '\\b(?:edu|bildung|interests)');
$Categories['Food']           = array('Essen',              '\\b(?:food|cook|essen|[dt]rink)');
$Categories['Game']           = array('Spiele',             '\\b(?:game|spiele)');
$Categories['Health_Medical'] = array('Gesundheit/Medizin',     '\\b(?:health|medic|gesundheit)');
$Categories['History']        = array('Geschichte',            '\\b(?:hist|geschichte)');
$Categories['Horror']         = array('Horror',             '\\b(?:horror)');
$Categories['HowTo']          = array('HowTo',              '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Versch.',               '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nachrichten',        '\\b(?:news|nachrichten|current)');
$Categories['Reality']        = array('Reality',            '\\b(?:reality)');
$Categories['Romance']        = array('Romantik',           '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Science Fiction/Fantasy',      '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Science_Nature'] = array('Wissenschaft/Natur', '\\b(?:science|nature|environment|wissenschaft)');
$Categories['Shopping']       = array('Shopping',           '\\b(?:shop)');
$Categories['Soaps']          = array('Serien',              '\\b(?:soaps)');
$Categories['Spiritual']      = array('Spiritual',          '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',              '\\b(?:sport|deportes|futbol)');
$Categories['Talk']           = array('Talk',               '\\b(?:talk)');
$Categories['Travel']         = array('Reisen',             '\\b(?:travel|reisen|touris)');
$Categories['War']            = array('Krieg',              '\\b(?:war|krieg)');
$Categories['Western']        = array('Western',            '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Unbekannt');
$Categories['movie']          = array('Filme'  );

?>
