<?php
/***                                                                        ***\
    languages/Dutch.php

    Translation hash for Dutch.
\***                                                                        ***/

// Set the locale to Dutch
setlocale(LC_ALL, 'nl_NL');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 hr'                                              => '$1 uur',
    '$1 hrs'                                             => '$1 uur',
    '$1 min'                                             => '$1 min',
    '$1 mins'                                            => '$1 min',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 programma\'s, U gebruikt $2 ($3) van $4.',
    '$1 to $2'                                           => '$1 tot $2',
    'Activate'                                           => 'Activeer',
    'Advanced Options'                                   => 'Geavanceerde Opties',
    'Airtime'                                            => 'Uitzendtijd',
    'All recordings'                                     => 'Alle opnames',
    'Auto-expire recordings'                             => 'Opnames Autom. Vervallen',
    'Auto-flag commercials'                              => 'Reclame Autom. Markeren',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'Backend Status',
    'Cancel this schedule.'                              => 'Annuleer deze opname',
    'Category'                                           => 'Categorie',
    'Check for duplicates in'                            => 'Controleer op dubbels in',
    'Create Schedule'                                    => 'Maak Schema',
    'Current recordings'                                 => 'Huidige Opnames',
    'Custom Schedule'                                    => '',
    'Date'                                               => 'Datum',
    'Default'                                            => 'Standaard',
    'Description'                                        => 'Beschrijving',
    'Details for'                                        => '',
    'Display'                                            => 'Toon',
    'Don\'t Record'                                      => 'Niet Opnemen',
    'Duplicate Check method'                             => 'Testmethode herh.',
    'End Late'                                           => 'Later stoppen',
    'Episode'                                            => 'Aflevering',
    'Forget Old'                                         => 'Vergeet Oude',
    'Hour'                                               => 'Uur',
    'IMDB'                                               => 'IMDB',
    'Inactive'                                           => '',
    'Jump'                                               => 'Ga',
    'Jump to'                                            => 'Spring naar',
    'Listings'                                           => 'Programmagids',
    'Music'                                              => '',
    'Never Record'                                       => 'Nooit Opnemen',
    'No'                                                 => 'Nee',
    'No. of recordings to keep'                          => 'Aantal opnames bewaren',
    'None'                                               => 'Geen',
    'Only New Episodes'                                  => 'Enkel Nieuwe Afleveringen',
    'Original Airdate'                                   => 'Oorsp. Datum',
    'Previous recordings'                                => 'Eerdere opnames',
    'Program Listing'                                    => '',
    'Rating'                                             => 'Beoordeling',
    'Record This'                                        => 'Dit Opnemen',
    'Record new and expire old'                          => 'Neem nieuwe op, wis oude',
    'Recorded Programs'                                  => 'Opgenomen Programma\'s',
    'Recording Group'                                    => 'Opname Groep',
    'Recording Options'                                  => 'Opname Opties',
    'Recording Priority'                                 => 'Opname Prioriteit',
    'Recording Profile'                                  => 'Opname Profiel',
    'Recording Schedules'                                => 'Opnameschema',
    'Repeat'                                             => 'Opnieuw Uitvoeren',
    'Save'                                               => 'Opslaan',
    'Save Schedule'                                      => '',
    'Schedule'                                           => 'Programmeer',
    'Schedule Manually'                                  => '',
    'Schedule Options'                                   => 'Schema Opties',
    'Schedule Override'                                  => 'Aangepast Schema',
    'Schedule normally.'                                 => 'Normaal Schema',
    'Search'                                             => 'Zoeken',
    'Search Results'                                     => 'Zoekresultaten',
    'Settings'                                           => 'Instellingen',
    'Start Early'                                        => 'Eerder Beginnen',
    'Subtitle'                                           => 'Aflevering',
    'Subtitle and Description'                           => 'Aflevering en Beschrijving',
    'The requested recording schedule has been deleted.' => 'Het gevraagde opnameschema is verwijderd',
    'Title'                                              => 'Titel',
    'Transcoder'                                         => '',
    'Type'                                               => 'Type',
    'Unknown'                                            => 'Onbekend',
    'Upcoming Recordings'                                => '',
    'Update'                                             => 'Pas Aan',
    'Update Recording Settings'                          => 'Opname-instellingen Vernieuwen',
    'Weather'                                            => '',
    'Yes'                                                => 'Ja',
    'airdate'                                            => 'uitzenddatum',
    'channum'                                            => 'zender',
    'description'                                        => 'beschrijving',
    'generic_date'                                       => '%a %e %b, %Y',
    'generic_time'                                       => '%H:%M',
    'length'                                             => 'duur',
    'minutes'                                            => 'minuten',
    'recgroup'                                           => 'opnamegroep',
    'recpriority'                                        => '',
    'rectype-long: always'                               => 'Dit programma altijd op elke zender opnemen.',
    'rectype-long: channel'                              => 'Dit programma altijd op deze zender opnemen.',
    'rectype-long: daily'                                => 'Dit programma dagelijks in dit tijdsslot opnemen.',
    'rectype-long: dontrec'                              => 'Dit programma niet opnemen',
    'rectype-long: finddaily'                            => 'Vind dagelijks een uitzending van dit programma',
    'rectype-long: findone'                              => 'Vind 1 uitzending van dit programma en neem op.',
    'rectype-long: findweekly'                           => 'Vind wekelijks een opname van dit programma',
    'rectype-long: once'                                 => 'Dit programma eenmalig opnemen.',
    'rectype-long: override'                             => 'Aangepaste opties',
    'rectype-long: weekly'                               => 'Dit programma wekelijks in dit tijdsslot opnemen.',
    'rectype: always'                                    => 'Altijd',
    'rectype: channel'                                   => 'Zender',
    'rectype: daily'                                     => 'Dagelijks',
    'rectype: dontrec'                                   => 'Niet Opnemen',
    'rectype: findone'                                   => 'Vind Eén',
    'rectype: once'                                      => 'Eenmalig',
    'rectype: override'                                  => 'Aangepast (opname)',
    'rectype: weekly'                                    => 'Wekelijks',
    'subtitle'                                           => 'aflevering',
    'title'                                              => 'titel',
// includes/programs.php
    'CC'                           => '',
    'HDTV'                         => '',
    'Notes'                        => 'Opmerkingen',
    'Part $1 of $2'                => '',
    'Stereo'                       => '',
    'Subtitled'                    => '',
    'recstatus: cancelled'         => 'Dit programma zou opgenomen worden maar werd handmatig geannuleerd',
    'recstatus: conflict'          => 'Een ander programma met hogere prioriteit zal opgenomen worden',
    'recstatus: currentrecording'  => 'Dit programma werd eerder opgenomen en bevindt zich nog in de lijst met opgenomen programma\'s',
    'recstatus: deleted'           => 'Dit programma werd opgenomen maar werd al verwijderd voor de opname afgelopen was.',
    'recstatus: earliershowing'    => 'Dit programma wordt op een vroegere tijd opgenomen.',
    'recstatus: force_record'      => 'Dit programma werd handmatig ingesteld op deze manier opgenomen te worden.',
    'recstatus: inactive'          => '',
    'recstatus: latershowing'      => 'Dit programma zal op een later tijdstip opgenomen worden.',
    'recstatus: lowdiskspace'      => 'Er was niet voldoende schijfruimte aanwezig om dit programma op te nemen.',
    'recstatus: manualoverride'    => 'Dit werd handmatig ingesteld niet opgenomen te worden.',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => 'Dit programma werd eerder opgenomen volgens de regels die gekozen werden voor het detecteren van dubbels.',
    'recstatus: recorded'          => 'Dit programma werd opgenomen.',
    'recstatus: recording'         => 'Dit programma wordt nu opgenomen.',
    'recstatus: repeat'            => 'Dit programma is een herhaling en wordt niet opgenomen.',
    'recstatus: stopped'           => 'Dit programma werd opgenomen maar de opname werd gestopt voor het programma eindigde.',
    'recstatus: toomanyrecordings' => 'Er werden al te veel afleveringen van dit programma opgenomen.',
    'recstatus: tunerbusy'         => 'De tuner was al in gebruik toen dit programma geprogrammeerd werd.',
    'recstatus: unknown'           => 'De status van dit programma is onbekend.',
    'recstatus: willrecord'        => 'Dit programma zal opgenomen worden.',
// includes/recording_schedules.php
    'Dup Method'                   => 'Dubbels Methode',
    'Profile'                      => 'Profiel',
    'Sub and Desc (Empty matches)' => 'Dubbels en Beschrijving',
    'rectype: finddaily'           => 'Vind een dagelijkse uitzending.',
    'rectype: findweekly'          => 'Vind een wekelijkse uitzending.',
// includes/utils.php
    '$1 B'  => '$1 B',
    '$1 GB' => '$1 GB',
    '$1 KB' => '$1 KB',
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
    'Unknown Program.'                                                          => 'Onbekend Programma.',
    'Unknown Recording Schedule.'                                               => 'Onbekend Opnameschema',
// modules/tv/init.php
    'Special Searches' => '',
    'TV'               => '',
// modules/tv/recorded.php
    'No matching programs found.'             => '',
    'Showing all programs from the $1 group.' => '',
    'Showing all programs.'                   => '',
// modules/tv/schedules_custom.php
    'Any Category'     => '',
    'Any Channel'      => '',
    'Any Program Type' => '',
// modules/tv/search.php
    'Please search for something.' => '',
// modules/video/init.php
    'Video' => '',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => '',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => '',
// themes/default/header.php
    'Category Legend'                            => 'Categorie Legende',
    'Category Type'                              => 'Categorie Type',
    'Custom'                                     => '',
    'Edit MythWeb and some MythTV settings.'     => 'Bewerk MythWeb en enkele MythTV instellingen',
    'Exact Match'                                => 'Exacte Overeenkomst',
    'HD Only'                                    => '',
    'Manual'                                     => '',
    'MythMusic on the web.'                      => 'Muziek',
    'MythVideo on the web.'                      => 'Video',
    'MythWeb Weather.'                           => 'Weer',
    'Search fields'                              => 'Zoek Velden',
    'Search help'                                => 'Zoek Help',
    'Search help: movie example'                 => '*** 1/2 Avontuur',
    'Search help: movie search'                  => 'zoek films',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'regex zoeken',
    'Search options'                             => 'Zoek Opties',
    'Searches'                                   => '',
    'TV functions, including recorded programs.' => 'TV functies, inclusief opgenomen programma\'s',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => '',
// themes/default/music/music.php
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
    'Next'                => '',
    'No Tracks Available' => '',
    'Previous'            => '',
    'Top'                 => '',
    'Track Name'          => '',
    'Unfiltered'          => '',
// themes/default/music/welcome.php
    'welcome: music' => '',
// themes/default/settings/channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Waarschuwing! Als u niet weet wat u doet, kan het veranderen van deze tabel de werking van MythTV ernstig verstoren.',
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
    'sourceid'                                                                                                                           => '',
    'useonairguide'                                                                                                                      => '',
    'videofilters'                                                                                                                       => '',
    'visible'                                                                                                                            => '',
    'xmltvid'                                                                                                                            => '',
// themes/default/settings/keys.php
    'Action'                => '',
    'Configure Keybindings' => '',
    'Context'               => '',
    'Destination'           => '',
    'Edit keybindings on'   => 'Bewerk toetsbindingen op',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'Zender &quot;Ga naar&quot;',
    'Date Formats'                    => 'Weergave Datum',
    'Guide Settings'                  => '',
    'Hour Format'                     => 'Weergave Tijd',
    'Language'                        => 'Taal',
    'Listing &quot;Jump to&quot;'     => 'Gids &quot;Ga naar&quot;',
    'Listing Time Key'                => 'Weergave Tijd Gids',
    'MythWeb Session Settings'        => '',
    'MythWeb Theme'                   => 'MythWeb Thema',
    'Only display favourite channels' => '',
    'Reset'                           => 'Herstellen',
    'SI Units?'                       => '',
    'Scheduled Popup'                 => 'Geprogrammeerd Pop-up',
    'Show descriptions on new line'   => 'Toon beschrijvingen op nieuwe regel',
    'Status Bar'                      => 'Statusbalk',
    'Weather Icons'                   => '',
    'format help'                     => 'formaat help',
// themes/default/settings/settings.php
    'settings: overview' => 'instellingen: overzicht',
// themes/default/settings/welcome.php
    'welcome: settings' => '',
// themes/default/status/welcome.php
    'welcome: status' => '',
// themes/default/tv/channel.php
    'Channel Detail' => '',
    'Length'         => 'Duur',
    'Show'           => 'Toon',
    'Time'           => 'Tijd',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Terug naar programmagids',
    'Back to the recording schedules'     => 'Terug naar opnameschema',
    'Cast'                                => 'Acteurs',
    'Directed by'                         => 'Regisseur',
    'Don\'t record this program.'         => 'Dit programma niet opnemen',
    'Episode Number'                      => '',
    'Exec. Producer'                      => 'Uitv. Producent',
    'Find other showings of this program' => 'Vind andere afleveringen van dit programma',
    'Find showings of this program'       => 'Vind afleveringen van dit programma',
    'Google'                              => 'Google',
    'Guest Starring'                      => '',
    'Guide rating'                        => '',
    'Hosted by'                           => '',
    'MythTV Status'                       => '',
    'Possible conflicts with this show'   => '',
    'Presented by'                        => 'Presentator',
    'Produced by'                         => 'Producent',
    'Program Detail'                      => '',
    'Program ID'                          => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'Wat wordt er nog uitgezonden op dit tijdstip',
    'Written by'                          => 'Auteur',
// themes/default/tv/list.php
    'Currently Browsing:  $1' => 'Tijdstip: $1',
    'Jump To'                 => 'Ga naar',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 aflevering',
    '$1 episodes'                                         => '$1 afleveringen',
    '$1 recording'                                        => '$1 opname',
    '$1 recordings'                                       => '$1 opnames',
    'All groups'                                          => '',
    'Are you sure you want to delete the following show?' => 'Bent U zeker van het verwijderen van volgend programma?',
    'Delete'                                              => 'Verwijderen',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => '',
    'Delete and rerecord $1'                              => '',
    'Go'                                                  => 'Doorgaan',
    'Show group'                                          => 'Toon groep',
    'Show recordings'                                     => 'Toon opnames',
    'auto-expire'                                         => 'automatisch vervallen',
    'file size'                                           => 'bestandsgrootte',
    'has bookmark'                                        => 'heeft index',
    'has commflag'                                        => 'heeft reclamemarkering',
    'has cutlist'                                         => 'heeft knippunten',
    'is editing'                                          => 'wordt bewerkt',
    'preview'                                             => 'preview',
// themes/default/tv/schedules.php
    'Any'                                       => 'Alle',
    'No recording schedules have been defined.' => 'Er zijn geen opnameschema\'s gevonden.',
    'channel'                                   => 'zender',
    'profile'                                   => 'profiel',
    'transcoder'                                => '',
    'type'                                      => 'type',
// themes/default/tv/schedules_custom.php
    'Additional Tables' => '',
    'Keyword Search'    => '',
    'People Search'     => '',
    'Power Search'      => '',
    'Search Phrase'     => '',
    'Search Type'       => '',
    'Title Search'      => '',
// themes/default/tv/schedules_manual.php
    'Channel'      => 'Zender',
    'Length (min)' => 'Duur (min)',
    'Start Date'   => 'Start Datum',
    'Start Time'   => 'Start Tijd',
// themes/default/tv/search.php
    'No matches found'                 => 'Geen programma\'s gevonden',
    'No matching programs were found.' => '',
    'Search for:  $1'                  => '',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => '',
    'handy: overview'           => '',
// themes/default/tv/upcoming.php
    'Commands'    => 'Opdrachten',
    'Conflicts'   => 'Conflicten',
    'Deactivated' => 'Gedeactiveerd',
    'Duplicates'  => 'Dubbels',
    'Scheduled'   => 'Geprogrammeerd',
// themes/default/tv/welcome.php
    'welcome: tv' => '',
// themes/default/video/video.php
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
// themes/default/video/welcome.php
    'welcome: video' => '',
// themes/default/weather/weather.php
    ' at '               => ' aan ',
    'Current Conditions' => 'Huidige Waarnemingen',
    'Forecast'           => 'Voorspelling',
    'Friday'             => 'Vrijdag',
    'High'               => 'Maximum',
    'Humidity'           => 'Vochtigheid',
    'Last Updated'       => 'Laatst Vernieuwd',
    'Low'                => 'Minimum',
    'Monday'             => 'Maandag',
    'Pressure'           => 'Luchtdruk',
    'Radar'              => 'Radar',
    'Saturday'           => 'Zaterdag',
    'Sunday'             => 'Zondag',
    'Thursday'           => 'Donderdag',
    'Today'              => 'Vandaag',
    'Tomorrow'           => 'Morgen',
    'Tuesday'            => 'Dinsdag',
    'UV Extreme'         => 'UV Zeer Hoog',
    'UV High'            => 'UV Hoog',
    'UV Index'           => 'UV Index',
    'UV Minimal'         => 'UV Laag',
    'UV Moderate'        => 'UV Gemiddeld',
    'Visibility'         => 'Zichtbaarheid',
    'Wednesday'          => 'Woensdag',
    'Wind'               => 'Wind',
    'Wind Chill'         => 'Voeltemp. Wind',
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
$Categories['Action']         = array('Actie',              '\\b(?:action|avon|actie)');
$Categories['Adult']          = array('Erotisch',           '\\b(?:adult|erot|sex)');
$Categories['Animals']        = array('Dieren',             '\\b(?:animal|dier)');
$Categories['Art_Music']      = array('Kunst_Muziek',       '\\b(?:art|kunst|dans|musi[ck]|muziek|kunst|[ck]ultur)');
$Categories['Business']       = array('Zakelijk',           '\\b(?:biz|busine|zake)');
$Categories['Children']       = array('Kinderen',           '\\b(?:child|jeugd|animatie|kin?d|infan)');
$Categories['Comedy']         = array('Komisch',            '\\b(?:comed|entertain|sitcom|serie)');
$Categories['Crime_Mystery']  = array('Misdaad_Crimi',      '\\b(?:[ck]rim|myster|misdaad)');
$Categories['Documentary']    = array('Documentaire',       '\\b(?:informatief|docu)');
$Categories['Drama']          = array('Drama',              '\\b(?:drama)');
$Categories['Educational']    = array('Educatie',           '\\b(?:edu|interes)');
$Categories['Food']           = array('Eten',               '\\b(?:food|cook|[dt]rink|kook|eten|kok)');
$Categories['Game']           = array('Spel',               '\\b(?:game|spel|quiz)');
$Categories['Health_Medical'] = array('Gezondheid_Medisch', '\\b(?:medisch|gezond)');
$Categories['History']        = array('Geschiedenis',       '\\b(?:hist|geschied)');
$Categories['Horror']         = array('Horror',             '\\b(?:horror)');
$Categories['HowTo']          = array('Hulp',               '\\b(?:how|home|house|garden|huis|tuin|woning)');
$Categories['Misc']           = array('Divers',             '\\b(?:special|variety|info|collect)');
$Categories['News']           = array('Nieuws',             '\\b(?:news|current|nieuws|duiding|actua)');
$Categories['Reality']        = array('Reality',            '\\b(?:reality|leven)');
$Categories['Romance']        = array('Romantiek',          '\\b(?:romance|lief)');
$Categories['SciFi_Fantasy']  = array('Wetenschap_Natuur',  '\\b(?:fantasy|sci\\w*\\W*fi|natuur|wetenschap)');
$Categories['Science_Nature'] = array('SciFi_Fantasy',      '\\b(?:science|natuur|environment|wetenschap)');
$Categories['Shopping']       = array('Shopping',           '\\b(?:shop|koop)');
$Categories['Soaps']          = array('Soaps',              '\\b(?:soap)');
$Categories['Spiritual']      = array('Religie',            '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',              '\\b(?:sport|deportes|voetbal|tennis)');
$Categories['Talk']           = array('Praat',              '\\b(?:talk|praat)');
$Categories['Travel']         = array('Reis',               '\\b(?:travel|reis)');
$Categories['War']            = array('Oorlog',             '\\b(?:war|oorlog)');
$Categories['Western']        = array('Films',              '\\b(?:west|film)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Onbekend');
$Categories['movie']          = array('Films'  );

