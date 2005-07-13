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
    ' at '                                                                                                                               => ' aan ',
    '$1 B'                                                                                                                               => '$1 B',
    '$1 GB'                                                                                                                              => '$1 GB',
    '$1 KB'                                                                                                                              => '$1 KB',
    '$1 MB'                                                                                                                              => '$1 MB',
    '$1 Rating'                                                                                                                          => '$1 Waardering',
    '$1 TB'                                                                                                                              => '$1 TB',
    '$1 episode'                                                                                                                         => '$1 aflevering',
    '$1 episodes'                                                                                                                        => '$1 afleveringen',
    '$1 hr'                                                                                                                              => '$1 uur',
    '$1 hrs'                                                                                                                             => '$1 uur',
    '$1 min'                                                                                                                             => '$1 min',
    '$1 mins'                                                                                                                            => '$1 min',
    '$1 programs, using $2 ($3) out of $4.'                                                                                              => '$1 programma\'s, U gebruikt $2 ($3) van $4.',
    '$1 recording'                                                                                                                       => '$1 opname',
    '$1 recordings'                                                                                                                      => '$1 opnames',
    '$1 to $2'                                                                                                                           => '$1 tot $2',
    'Activate'                                                                                                                           => 'Activeer',
    'Advanced Options'                                                                                                                   => 'Geavanceerde Opties',
    'Airtime'                                                                                                                            => 'Uitzendtijd',
    'All recordings'                                                                                                                     => 'Alle opnames',
    'Any'                                                                                                                                => 'Alle',
    'Are you sure you want to delete the following show?'                                                                                => 'Bent U zeker van het verwijderen van volgend programma?',
    'Auto-expire recordings'                                                                                                             => 'Opnames Autom. Vervallen',
    'Auto-flag commercials'                                                                                                              => 'Reclame Autom. Markeren',
    'Auto-transcode'                                                                                                                     => '',
    'Back to the program listing'                                                                                                        => 'Terug naar programmagids',
    'Back to the recording schedules'                                                                                                    => 'Terug naar opnameschema',
    'Backend Status'                                                                                                                     => 'Backend Status',
    'Cancel this schedule.'                                                                                                              => 'Annuleer deze opname',
    'Cast'                                                                                                                               => 'Acteurs',
    'Category'                                                                                                                           => 'Categorie',
    'Category Legend'                                                                                                                    => 'Categorie Legende',
    'Category Type'                                                                                                                      => 'Categorie Type',
    'Channel'                                                                                                                            => 'Zender',
    'Channel &quot;Jump to&quot;'                                                                                                        => 'Zender &quot;Ga naar&quot;',
    'Channels'                                                                                                                           => 'Zenders',
    'Check for duplicates in'                                                                                                            => 'Controleer op dubbels in',
    'Commands'                                                                                                                           => 'Opdrachten',
    'Configure'                                                                                                                          => 'Instellen',
    'Conflicts'                                                                                                                          => 'Conflicten',
    'Create Schedule'                                                                                                                    => 'Maak Schema',
    'Current Conditions'                                                                                                                 => 'Huidige Waarnemingen',
    'Current recordings'                                                                                                                 => 'Huidige Opnames',
    'Currently Browsing:  $1'                                                                                                            => 'Tijdstip: $1',
    'Date'                                                                                                                               => 'Datum',
    'Date Formats'                                                                                                                       => 'Weergave Datum',
    'Deactivated'                                                                                                                        => 'Gedeactiveerd',
    'Default'                                                                                                                            => 'Standaard',
    'Delete'                                                                                                                             => 'Verwijderen',
    'Delete + Rerecord'                                                                                                                  => '',
    'Description'                                                                                                                        => 'Beschrijving',
    'Directed by'                                                                                                                        => 'Regisseur',
    'Display'                                                                                                                            => 'Toon',
    'Don\'t Record'                                                                                                                      => 'Niet Opnemen',
    'Don\'t record this program.'                                                                                                        => 'Dit programma niet opnemen',
    'Dup Method'                                                                                                                         => 'Dubbels Methode',
    'Duplicate Check method'                                                                                                             => 'Testmethode herh.',
    'Duplicates'                                                                                                                         => 'Dubbels',
    'Edit MythWeb and some MythTV settings.'                                                                                             => 'Bewerk MythWeb en enkele MythTV instellingen',
    'Edit keybindings on'                                                                                                                => 'Bewerk toetsbindingen op',
    'End Late'                                                                                                                           => 'Later stoppen',
    'Episode'                                                                                                                            => 'Aflevering',
    'Exact Match'                                                                                                                        => 'Exacte Overeenkomst',
    'Exec. Producer'                                                                                                                     => 'Uitv. Producent',
    'Find other showings of this program'                                                                                                => 'Vind andere afleveringen van dit programma',
    'Find showings of this program'                                                                                                      => 'Vind afleveringen van dit programma',
    'Forecast'                                                                                                                           => 'Voorspelling',
    'Forget Old'                                                                                                                         => 'Vergeet Oude',
    'Friday'                                                                                                                             => 'Vrijdag',
    'Go'                                                                                                                                 => 'Doorgaan',
    'Google'                                                                                                                             => 'Google',
    'Guest Starring'                                                                                                                     => '',
    'Guide Settings'                                                                                                                     => '',
    'HD Only'                                                                                                                            => '',
    'High'                                                                                                                               => 'Maximum',
    'Hosted by'                                                                                                                          => '',
    'Hour'                                                                                                                               => 'Uur',
    'Hour Format'                                                                                                                        => 'Weergave Tijd',
    'Humidity'                                                                                                                           => 'Vochtigheid',
    'IMDB'                                                                                                                               => 'IMDB',
    'Inactive'                                                                                                                           => '',
    'Jump'                                                                                                                               => 'Ga',
    'Jump To'                                                                                                                            => 'Ga naar',
    'Jump to'                                                                                                                            => 'Spring naar',
    'Key Bindings'                                                                                                                       => 'Toetsbindingen',
    'Language'                                                                                                                           => 'Taal',
    'Last Updated'                                                                                                                       => 'Laatst Vernieuwd',
    'Length'                                                                                                                             => 'Duur',
    'Length (min)'                                                                                                                       => 'Duur (min)',
    'Listing &quot;Jump to&quot;'                                                                                                        => 'Gids &quot;Ga naar&quot;',
    'Listing Time Key'                                                                                                                   => 'Weergave Tijd Gids',
    'Listings'                                                                                                                           => 'Programmagids',
    'Low'                                                                                                                                => 'Minimum',
    'Manually Schedule'                                                                                                                  => 'Handmatig Programmeren',
    'Monday'                                                                                                                             => 'Maandag',
    'MythMusic on the web.'                                                                                                              => 'Muziek',
    'MythVideo on the web.'                                                                                                              => 'Video',
    'MythWeb Settings'                                                                                                                   => 'MythWeb Instellingen',
    'MythWeb Theme'                                                                                                                      => 'MythWeb Thema',
    'MythWeb Weather.'                                                                                                                   => 'Weer',
    'Never Record'                                                                                                                       => 'Nooit Opnemen',
    'No'                                                                                                                                 => 'Nee',
    'No matches found'                                                                                                                   => 'Geen programma\'s gevonden',
    'No recording schedules have been defined.'                                                                                          => 'Er zijn geen opnameschema\'s gevonden.',
    'No. of recordings to keep'                                                                                                          => 'Aantal opnames bewaren',
    'None'                                                                                                                               => 'Geen',
    'Notes'                                                                                                                              => 'Opmerkingen',
    'Only New Episodes'                                                                                                                  => 'Enkel Nieuwe Afleveringen',
    'Only display favourite channels'                                                                                                    => '',
    'Original Airdate'                                                                                                                   => 'Oorsp. Datum',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Waarschuwing! Als u niet weet wat u doet, kan het veranderen van deze tabel de werking van MythTV ernstig verstoren.',
    'Please search for something.'                                                                                                       => '',
    'Presented by'                                                                                                                       => 'Presentator',
    'Pressure'                                                                                                                           => 'Luchtdruk',
    'Previous recordings'                                                                                                                => 'Eerdere opnames',
    'Produced by'                                                                                                                        => 'Producent',
    'Profile'                                                                                                                            => 'Profiel',
    'Profile Groups'                                                                                                                     => 'Profielgroepen',
    'Radar'                                                                                                                              => 'Radar',
    'Rating'                                                                                                                             => 'Beoordeling',
    'Record This'                                                                                                                        => 'Dit Opnemen',
    'Record new and expire old'                                                                                                          => 'Neem nieuwe op, wis oude',
    'Recorded Programs'                                                                                                                  => 'Opgenomen Programma\'s',
    'Recording Group'                                                                                                                    => 'Opname Groep',
    'Recording Options'                                                                                                                  => 'Opname Opties',
    'Recording Priority'                                                                                                                 => 'Opname Prioriteit',
    'Recording Profile'                                                                                                                  => 'Opname Profiel',
    'Recording Schedules'                                                                                                                => 'Opnameschema',
    'Recording profiles'                                                                                                                 => 'Opnameprofielen',
    'Rerun'                                                                                                                              => 'Opnieuw Uitvoeren',
    'Reset'                                                                                                                              => 'Herstellen',
    'SI Units?'                                                                                                                          => '',
    'Saturday'                                                                                                                           => 'Zaterdag',
    'Save'                                                                                                                               => 'Opslaan',
    'Save Schedule'                                                                                                                      => '',
    'Schedule'                                                                                                                           => 'Programmeer',
    'Schedule Options'                                                                                                                   => 'Schema Opties',
    'Schedule Override'                                                                                                                  => 'Aangepast Schema',
    'Schedule normally.'                                                                                                                 => 'Normaal Schema',
    'Scheduled'                                                                                                                          => 'Geprogrammeerd',
    'Scheduled Popup'                                                                                                                    => 'Geprogrammeerd Pop-up',
    'Scheduled Recordings'                                                                                                               => 'Geprogrammeerde Opnames',
    'Search'                                                                                                                             => 'Zoeken',
    'Search Results'                                                                                                                     => 'Zoekresultaten',
    'Search fields'                                                                                                                      => 'Zoek Velden',
    'Search for:  $1'                                                                                                                    => '',
    'Search help'                                                                                                                        => 'Zoek Help',
    'Search help: movie example'                                                                                                         => '*** 1/2 Avontuur',
    'Search help: movie search'                                                                                                          => 'zoek films',
    'Search help: regex example'                                                                                                         => '/^Good Eats/',
    'Search help: regex search'                                                                                                          => 'regex zoeken',
    'Search options'                                                                                                                     => 'Zoek Opties',
    'Searches'                                                                                                                           => '',
    'Settings'                                                                                                                           => 'Instellingen',
    'Show'                                                                                                                               => 'Toon',
    'Show descriptions on new line'                                                                                                      => 'Toon beschrijvingen op nieuwe regel',
    'Show group'                                                                                                                         => 'Toon groep',
    'Show recordings'                                                                                                                    => 'Toon opnames',
    'Start Date'                                                                                                                         => 'Start Datum',
    'Start Early'                                                                                                                        => 'Eerder Beginnen',
    'Start Time'                                                                                                                         => 'Start Tijd',
    'Status Bar'                                                                                                                         => 'Statusbalk',
    'Sub and Desc (Empty matches)'                                                                                                       => 'Dubbels en Beschrijving',
    'Subtitle'                                                                                                                           => 'Aflevering',
    'Subtitle and Description'                                                                                                           => 'Aflevering en Beschrijving',
    'Sunday'                                                                                                                             => 'Zondag',
    'TV functions, including recorded programs.'                                                                                         => 'TV functies, inclusief opgenomen programma\'s',
    'TVTome'                                                                                                                             => 'TVTome',
    'The requested recording schedule has been deleted.'                                                                                 => 'Het gevraagde opnameschema is verwijderd',
    'Thursday'                                                                                                                           => 'Donderdag',
    'Time'                                                                                                                               => 'Tijd',
    'Title'                                                                                                                              => 'Titel',
    'Today'                                                                                                                              => 'Vandaag',
    'Tomorrow'                                                                                                                           => 'Morgen',
    'Transcoder'                                                                                                                         => '',
    'Tuesday'                                                                                                                            => 'Dinsdag',
    'Type'                                                                                                                               => 'Type',
    'UV Extreme'                                                                                                                         => 'UV Zeer Hoog',
    'UV High'                                                                                                                            => 'UV Hoog',
    'UV Index'                                                                                                                           => 'UV Index',
    'UV Minimal'                                                                                                                         => 'UV Laag',
    'UV Moderate'                                                                                                                        => 'UV Gemiddeld',
    'Unknown'                                                                                                                            => 'Onbekend',
    'Unknown Program.'                                                                                                                   => 'Onbekend Programma.',
    'Unknown Recording Schedule.'                                                                                                        => 'Onbekend Opnameschema',
    'Update'                                                                                                                             => 'Pas Aan',
    'Update Recording Settings'                                                                                                          => 'Opname-instellingen Vernieuwen',
    'Visibility'                                                                                                                         => 'Zichtbaarheid',
    'Weather Icons'                                                                                                                      => '',
    'Wednesday'                                                                                                                          => 'Woensdag',
    'What else is on at this time?'                                                                                                      => 'Wat wordt er nog uitgezonden op dit tijdstip',
    'Wind'                                                                                                                               => 'Wind',
    'Wind Chill'                                                                                                                         => 'Voeltemp. Wind',
    'Written by'                                                                                                                         => 'Auteur',
    'Yes'                                                                                                                                => 'Ja',
    'airdate'                                                                                                                            => 'uitzenddatum',
    'auto-expire'                                                                                                                        => 'automatisch vervallen',
    'channel'                                                                                                                            => 'zender',
    'channum'                                                                                                                            => 'zender',
    'description'                                                                                                                        => 'beschrijving',
    'file size'                                                                                                                          => 'bestandsgrootte',
    'format help'                                                                                                                        => 'formaat help',
    'generic_date'                                                                                                                       => '%a %e %b, %Y',
    'generic_time'                                                                                                                       => '%H:%M',
    'handy: overview'                                                                                                                    => '',
    'has bookmark'                                                                                                                       => 'heeft index',
    'has commflag'                                                                                                                       => 'heeft reclamemarkering',
    'has cutlist'                                                                                                                        => 'heeft knippunten',
    'is editing'                                                                                                                         => 'wordt bewerkt',
    'length'                                                                                                                             => 'duur',
    'minutes'                                                                                                                            => 'minuten',
    'preview'                                                                                                                            => 'preview',
    'profile'                                                                                                                            => 'profiel',
    'recgroup'                                                                                                                           => 'opnamegroep',
    'recstatus: cancelled'                                                                                                               => 'Dit programma zou opgenomen worden maar werd handmatig geannuleerd',
    'recstatus: conflict'                                                                                                                => 'Een ander programma met hogere prioriteit zal opgenomen worden',
    'recstatus: currentrecording'                                                                                                        => 'Dit programma werd eerder opgenomen en bevindt zich nog in de lijst met opgenomen programma\'s',
    'recstatus: deleted'                                                                                                                 => 'Dit programma werd opgenomen maar werd al verwijderd voor de opname afgelopen was.',
    'recstatus: earliershowing'                                                                                                          => 'Dit programma wordt op een vroegere tijd opgenomen.',
    'recstatus: force_record'                                                                                                            => 'Dit programma werd handmatig ingesteld op deze manier opgenomen te worden.',
    'recstatus: latershowing'                                                                                                            => 'Dit programma zal op een later tijdstip opgenomen worden.',
    'recstatus: lowdiskspace'                                                                                                            => 'Er was niet voldoende schijfruimte aanwezig om dit programma op te nemen.',
    'recstatus: manualoverride'                                                                                                          => 'Dit werd handmatig ingesteld niet opgenomen te worden.',
    'recstatus: overlap'                                                                                                                 => 'Dit programma werd reeds op een eerder tijdstip opgenomen.',
    'recstatus: previousrecording'                                                                                                       => 'Dit programma werd eerder opgenomen volgens de regels die gekozen werden voor het detecteren van dubbels.',
    'recstatus: recorded'                                                                                                                => 'Dit programma werd opgenomen.',
    'recstatus: recording'                                                                                                               => 'Dit programma wordt nu opgenomen.',
    'recstatus: repeat'                                                                                                                  => 'Dit programma is een herhaling en wordt niet opgenomen.',
    'recstatus: stopped'                                                                                                                 => 'Dit programma werd opgenomen maar de opname werd gestopt voor het programma eindigde.',
    'recstatus: toomanyrecordings'                                                                                                       => 'Er werden al te veel afleveringen van dit programma opgenomen.',
    'recstatus: tunerbusy'                                                                                                               => 'De tuner was al in gebruik toen dit programma geprogrammeerd werd.',
    'recstatus: unknown'                                                                                                                 => 'De status van dit programma is onbekend.',
    'recstatus: willrecord'                                                                                                              => 'Dit programma zal opgenomen worden.',
    'rectype-long: always'                                                                                                               => 'Dit programma altijd op elke zender opnemen.',
    'rectype-long: channel'                                                                                                              => 'Dit programma altijd op deze zender opnemen.',
    'rectype-long: daily'                                                                                                                => 'Dit programma dagelijks in dit tijdsslot opnemen.',
    'rectype-long: dontrec'                                                                                                              => 'Dit programma niet opnemen',
    'rectype-long: finddaily'                                                                                                            => 'Vind dagelijks een uitzending van dit programma',
    'rectype-long: findone'                                                                                                              => 'Vind 1 uitzending van dit programma en neem op.',
    'rectype-long: findweekly'                                                                                                           => 'Vind wekelijks een opname van dit programma',
    'rectype-long: once'                                                                                                                 => 'Dit programma eenmalig opnemen.',
    'rectype-long: override'                                                                                                             => 'Aangepaste opties',
    'rectype-long: weekly'                                                                                                               => 'Dit programma wekelijks in dit tijdsslot opnemen.',
    'rectype: always'                                                                                                                    => 'Altijd',
    'rectype: channel'                                                                                                                   => 'Zender',
    'rectype: daily'                                                                                                                     => 'Dagelijks',
    'rectype: dontrec'                                                                                                                   => 'Niet Opnemen',
    'rectype: finddaily'                                                                                                                 => 'Vind een dagelijkse uitzending.',
    'rectype: findone'                                                                                                                   => 'Vind Eén',
    'rectype: findweekly'                                                                                                                => 'Vind een wekelijkse uitzending.',
    'rectype: once'                                                                                                                      => 'Eenmalig',
    'rectype: override'                                                                                                                  => 'Aangepast (opname)',
    'rectype: weekly'                                                                                                                    => 'Wekelijks',
    'settings: overview'                                                                                                                 => 'instellingen: overzicht',
    'subtitle'                                                                                                                           => 'aflevering',
    'title'                                                                                                                              => 'titel',
    'type'                                                                                                                               => 'type',
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

?>
