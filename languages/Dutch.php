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
    '$1 min'                                => '$1 min',
    '$1 mins'                               => '$1 min',
    '$1 programs, using $2 ($3) out of $4.' => '$1 programma\'s, U gebruikt $2 ($3) van $4.',
    '$1 to $2'                              => '$1 tot $2',
    'Airtime'                               => 'Uitzendtijd',
    'All recordings'                        => 'Alle opnames',
    'Auto-expire recordings'                => 'Opnames Autom. Vervallen',
    'Backend Status'                        => 'Backend Status',
    'Category'                              => 'Categorie',
    'Check for duplicates in'               => 'Controleer op dubbels in',
    'Current recordings'                    => 'Huidige Opnames',
    'Date'                                  => 'Datum',
    'Description'                           => 'Beschrijving',
    'Dup Method'                            => 'Dubbels Methode',
    'Duplicate Check method'                => 'Testmethode herh.',
    'End Late'                              => 'Later stoppen',
    'Episode'                               => 'Aflevering',
    'Go'                                    => 'Doorgaan',
    'Hour'                                  => 'Uur',
    'Jump to'                               => 'Spring naar',
    'Listings'                              => 'Programmagids',
    'No. of recordings to keep'             => 'Aantal opnames bewaren',
    'None'                                  => 'Geen',
    'Notes'                                 => 'Opmerkingen',
    'Original Airdate'                      => 'Oorsp. Datum',
    'Previous recordings'                   => 'Eerdere opnames',
    'Profile'                               => 'Profiel',
    'Rating'                                => 'Beoordeling',
    'Record new and expire old'             => 'Neem nieuwe op, wis oude',
    'Recorded Programs'                     => 'Opgenomen Programma\'s',
    'Recording Group'                       => 'Opname Groep',
    'Recording Options'                     => 'Opname Opties',
    'Recording Priority'                    => 'Opname Prioriteit',
    'Recording Profile'                     => 'Opname Profiel',
    'Rerun'                                 => 'Opnieuw Uitvoeren',
    'Schedule'                              => 'Programmeer',
    'Scheduled Recordings'                  => 'Geprogrammeerde Opnames',
    'Search'                                => 'Zoeken',
    'Search Results'                        => 'Zoekresultaten',
    'Start Early'                           => 'Eerder Beginnen',
    'Sub and Desc (Empty matches)'          => 'Dubbels en Beschrijving',
    'Subtitle'                              => 'Aflevering',
    'Subtitle and Description'              => 'Aflevering en Beschrijving',
    'Title'                                 => 'Titel',
    'Type'                                  => 'Type',
    'Unknown'                               => 'Onbekend',
    'Update Recording Settings'             => 'Opname-instellingen Vernieuwen',
    'Yes'                                   => 'Ja',
    'airdate'                               => 'uitzenddatum',
    'channum'                               => 'zender',
    'description'                           => 'beschrijving',
    'generic_date'                          => '%b %e, %Y',
    'generic_time'                          => '%H:%M',
    'length'                                => 'duur',
    'recgroup'                              => 'opnamegroep',
    'rectype-long: always'                  => 'Dit programma altijd op elke zender opnemen.',
    'rectype-long: channel'                 => 'Dit programma altijd op deze zender opnemen.',
    'rectype-long: daily'                   => 'Dit programma dagelijks in dit tijdsslot opnemen.',
    'rectype-long: dontrec'                 => 'Dit programma niet opnemen',
    'rectype-long: finddaily'               => 'Vind dagelijks een uitzending van dit programma',
    'rectype-long: findone'                 => 'Vind 1 uitzending van dit programma en neem op.',
    'rectype-long: findweekly'              => 'Vind wekelijks een opname van dit programma',
    'rectype-long: once'                    => 'Dit programma eenmalig opnemen.',
    'rectype-long: override'                => 'Aangepaste opties',
    'rectype-long: weekly'                  => 'Dit programma wekelijks in dit tijdsslot opnemen.',
    'rectype: always'                       => 'Altijd',
    'rectype: channel'                      => 'Zender',
    'rectype: daily'                        => 'Dagelijks',
    'rectype: dontrec'                      => 'Niet Opnemen',
    'rectype: findone'                      => 'Vind Eén',
    'rectype: once'                         => 'Eenmalig',
    'rectype: override'                     => 'Aangepast (opname)',
    'rectype: weekly'                       => 'Wekelijks',
    'subtitle'                              => 'aflevering',
    'title'                                 => 'titel',
// includes/programs.php
    'recstatus: cancelled'         => 'Dit programma zou opgenomen worden maar werd handmatig geannuleerd',
    'recstatus: conflict'          => 'Een ander programma met hogere prioriteit zal opgenomen worden',
    'recstatus: currentrecording'  => 'Dit programma werd eerder opgenomen en bevindt zich nog in de lijst met opgenomen programma\'s',
    'recstatus: deleted'           => 'Dit programma werd opgenomen maar werd al verwijderd voor de opname afgelopen was.',
    'recstatus: earliershowing'    => 'Dit programma wordt op een vroegere tijd opgenomen.',
    'recstatus: force_record'      => 'Dit programma werd handmatig ingesteld op deze manier opgenomen te worden.',
    'recstatus: latershowing'      => 'Dit programma zal op een later tijdstip opgenomen worden.',
    'recstatus: lowdiskspace'      => 'Er was niet voldoende schijfruimte aanwezig om dit programma op te nemen.',
    'recstatus: manualoverride'    => 'Dit werd handmatig ingesteld niet opgenomen te worden.',
    'recstatus: overlap'           => 'Dit programma werd reeds op een eerder tijdstip opgenomen.',
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
    'rectype: finddaily'  => 'Vind een dagelijkse uitzending.',
    'rectype: findweekly' => 'Vind een wekelijkse uitzending.',
// includes/utils.php
    '$1 B'   => '$1 B',
    '$1 GB'  => '$1 GB',
    '$1 KB'  => '$1 KB',
    '$1 MB'  => '$1 MB',
    '$1 TB'  => '$1 TB',
    '$1 hr'  => '$1 uur',
    '$1 hrs' => '$1 uur',
// program_detail.php
    'The requested recording schedule has been deleted.' => 'Het gevraagde opnameschema is verwijderd',
    'Unknown Program.'                                   => 'Onbekend Programma.',
    'Unknown Recording Schedule.'                        => 'Onbekend Opnameschema',
// themes/.../channel_detail.php
    'Length' => 'Duur',
    'Show'   => 'Toon',
    'Time'   => 'Tijd',
// themes/.../program_detail.php
    '$1 Rating'                           => '$1 Waardering',
    'Advanced Options'                    => 'Geavanceerde Opties',
    'Auto-flag commercials'               => 'Reclame Autom. Markeren',
    'Back to the program listing'         => 'Terug naar programmagids',
    'Back to the recording schedules'     => 'Terug naar opnameschema',
    'Cancel this schedule'                => 'Annuleer deze opname',
    'Cast'                                => 'Acteurs',
    'Directed by'                         => 'Regisseur',
    'Don\'t record this program'          => 'Dit programma niet opnemen',
    'Exec. Producer'                      => 'Uitv. Producent',
    'Find other showings of this program' => 'Vind andere afleveringen van dit programma',
    'Find showings of this program'       => 'Vind afleveringen van dit programma',
    'Google'                              => 'Google',
    'Guest Starring'                      => '',
    'Hosted by'                           => '',
    'IMDB'                                => 'IMDB',
    'Only New Episodes'                   => 'Enkel Nieuwe Afleveringen',
    'Presented by'                        => 'Presentator',
    'Produced by'                         => 'Producent',
    'Schedule Options'                    => 'Schema Opties',
    'Schedule Override'                   => 'Aangepast Schema',
    'Schedule normally.'                  => 'Normaal Schema',
    'TVTome'                              => 'TVTome',
    'What else is on at this time?'       => 'Wat wordt er nog uitgezonden op dit tijdstip',
    'Written by'                          => 'Auteur',
    'seconds'                             => 'seconden',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => 'Tijdstip: $1',
    'Jump'                    => 'Ga',
    'Jump To'                 => 'Ga naar',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1 aflevering',
    '$1 episodes'                                         => '$1 afleveringen',
    '$1 recording'                                        => '$1 opname',
    '$1 recordings'                                       => '$1 opnames',
    'Are you sure you want to delete the following show?' => 'Bent U zeker van het verwijderen van volgend programma?',
    'Delete'                                              => 'Verwijderen',
    'No'                                                  => 'Nee',
    'Show group'                                          => 'Toon groep',
    'Show recordings'                                     => 'Toon opnames',
    'auto-expire'                                         => 'automatisch vervallen',
    'file size'                                           => 'bestandsgrootte',
    'has bookmark'                                        => 'heeft index',
    'has commflag'                                        => 'heeft reclamemarkering',
    'has cutlist'                                         => 'heeft knippunten',
    'is editing'                                          => 'wordt bewerkt',
    'preview'                                             => 'preview',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Profielgroepen',
    'Recording profiles' => 'Opnameprofielen',
// themes/.../recording_schedules.php
    'Any'     => 'Alle',
    'profile' => 'profiel',
    'type'    => 'type',
// themes/.../schedule_manually.php
    'Channel'      => 'Zender',
    'Length (min)' => 'Duur (min)',
    'Start Date'   => 'Start Datum',
    'Start Time'   => 'Start Tijd',
// themes/.../scheduled_recordings.php
    'Activate'      => 'Activeer',
    'Commands'      => 'Opdrachten',
    'Conflicts'     => 'Conflicten',
    'Deactivated'   => 'Gedeactiveerd',
    'Default'       => 'Standaard',
    'Display'       => 'Toon',
    'Don\'t Record' => 'Niet Opnemen',
    'Duplicates'    => 'Dubbels',
    'Forget Old'    => 'Vergeet Oude',
    'Never Record'  => 'Nooit Opnemen',
    'Record This'   => 'Dit Opnemen',
    'Scheduled'     => 'Geprogrammeerd',
// themes/.../search.php
    'Category Type'    => 'Categorie Type',
    'Exact Match'      => 'Exacte Overeenkomst',
    'No matches found' => 'Geen programma\'s gevonden',
// themes/.../settings.php
    'Channels'           => 'Zenders',
    'Configure'          => 'Instellen',
    'Key Bindings'       => 'Toetsbindingen',
    'MythWeb Settings'   => 'MythWeb Instellingen',
    'settings: overview' => 'instellingen: overzicht',
// themes/.../settings_channels.php
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Waarschuwing! Als u niet weet wat u doet, kan het veranderen van deze tabel de werking van MythTV ernstig verstoren.',
// themes/.../settings_keys.php
    'Edit keybindings on' => 'Bewerk toetsbindingen op',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'   => 'Zender &quot;Ga naar&quot;',
    'Date Formats'                  => 'Weergave Datum',
    'Hour Format'                   => 'Weergave Tijd',
    'Language'                      => 'Taal',
    'Listing &quot;Jump to&quot;'   => 'Gids &quot;Ga naar&quot;',
    'Listing Time Key'              => 'Weergave Tijd Gids',
    'MythWeb Theme'                 => 'MythWeb Thema',
    'Reset'                         => 'Herstellen',
    'Save'                          => 'Opslaan',
    'Scheduled Popup'               => 'Geprogrammeerd Pop-up',
    'Show descriptions on new line' => 'Toon beschrijvingen op nieuwe regel',
    'Status Bar'                    => 'Statusbalk',
    'format help'                   => 'formaat help',
// themes/.../theme.php
    'Category Legend'                            => 'Categorie Legende',
    'Edit MythWeb and some MythTV settings.'     => 'Bewerk MythWeb en enkele MythTV instellingen',
    'Favorites'                                  => 'Favorieten',
    'Manually Schedule'                          => 'Handmatig Programmeren',
    'Movies'                                     => 'Films',
    'MythMusic on the web.'                      => 'MythMusic op het web',
    'MythVideo on the web.'                      => 'MythVideo op het web',
    'MythWeb Weather.'                           => 'MythWeb Weer',
    'Recording Schedules'                        => 'Opnameschema',
    'Settings'                                   => 'Instellingen',
    'TV functions, including recorded programs.' => 'TV functies, inclusief opgenomen programma\'s',
    'advanced'                                   => 'geavanceerd',
// themes/.../weather.php
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
    'Wind Chill'         => 'Voeltemp. Wind'
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
