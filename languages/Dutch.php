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
    '$1 Search'                                          => '$1 Zoeken',
    '$1 hr'                                              => '$1 uur',
    '$1 hrs'                                             => '$1 uur',
    '$1 min'                                             => '$1 min',
    '$1 mins'                                            => '$1 min',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 programma\'s, U gebruikt $2 ($3) van $4.',
    '$1 to $2'                                           => '$1 tot $2',
    'Activate'                                           => 'Activeren',
    'Advanced Options'                                   => 'Geavanceerde Opties',
    'Airtime'                                            => 'Uitzendtijd',
    'All recordings'                                     => 'Alle opnames',
    'Auto-expire recordings'                             => 'Opnames Autom. Vervallen',
    'Auto-flag commercials'                              => 'Reclame Autom. Markeren',
    'Auto-transcode'                                     => 'Auto-transcode',
    'Backend Logs'                                       => 'Backend Logboek',
    'Backend Status'                                     => 'Backend Status',
    'Cancel this schedule.'                              => 'Opname annuleren',
    'Category'                                           => 'Categorie',
    'Check for duplicates in'                            => 'Op dubbels controleren in',
    'Create Schedule'                                    => 'Opname plannen',
    'Current recordings'                                 => 'Huidige Opnames',
    'Currently Browsing:  $1'                            => 'Tijdstip: $1',
    'Custom Schedule'                                    => 'Geavanceerde Opname',
    'Date'                                               => 'Datum',
    'Default'                                            => 'Standaard',
    'Description'                                        => 'Beschrijving',
    'Details for'                                        => 'Details',
    'Display'                                            => 'Tonen',
    'Don\'t Record'                                      => 'Niet Opnemen',
    'Duplicate Check method'                             => 'Testmethode herh.',
    'End Late'                                           => 'Later stoppen',
    'Episode'                                            => 'Aflevering',
    'Forget Old'                                         => 'Oude vergeten',
    'Friday'                                             => 'Vrijdag',
    'Hour'                                               => 'Uur',
    'IMDB'                                               => 'IMDB',
    'Inactive'                                           => 'Niet actief',
    'Jump'                                               => 'Ga',
    'Jump to'                                            => 'Ga naar',
    'Keyword'                                            => 'Kernwoord',
    'Listings'                                           => 'Programmagids',
    'Monday'                                             => 'Maandag',
    'Music'                                              => 'Muziek',
    'Never Record'                                       => 'Nooit Opnemen',
    'No'                                                 => 'Neen',
    'No. of recordings to keep'                          => 'Aantal opnames bewaren',
    'None'                                               => 'Geen',
    'Only New Episodes'                                  => 'Enkel Nieuwe Afleveringen',
    'Original Airdate'                                   => 'Oorsp. Datum',
    'People'                                             => 'Personen',
    'Power'                                              => '',
    'Previous recordings'                                => 'Eerdere opnames',
    'Program Listing'                                    => 'Programmalijst',
    'Rating'                                             => 'Beoordeling',
    'Record This'                                        => 'Dit Opnemen',
    'Record new and expire old'                          => 'Nieuwe opnemen en oude wissen',
    'Recorded Programs'                                  => 'Opgenomen Programma\'s',
    'Recording Group'                                    => 'Opname Groep',
    'Recording Options'                                  => 'Opname Opties',
    'Recording Priority'                                 => 'Opname Prioriteit',
    'Recording Profile'                                  => 'Opname Profiel',
    'Recording Schedules'                                => 'Opnameschema',
    'Repeat'                                             => 'Opnieuw Uitvoeren',
    'Saturday'                                           => 'Zaterdag',
    'Save'                                               => 'Opslaan',
    'Save Schedule'                                      => 'Schema opslaan',
    'Schedule'                                           => 'Programmeren',
    'Schedule Manually'                                  => 'Handmatig',
    'Schedule Options'                                   => 'Schema Opties',
    'Schedule Override'                                  => 'Aangepast Schema',
    'Schedule normally.'                                 => 'Normaal Schema',
    'Search'                                             => 'Zoeken',
    'Search Results'                                     => 'Zoekresultaten',
    'Settings'                                           => 'Instellingen',
    'Start Early'                                        => 'Eerder beginnen',
    'Subtitle'                                           => 'Aflevering',
    'Subtitle and Description'                           => 'Aflevering en beschrijving',
    'Sunday'                                             => 'Zondag',
    'The requested recording schedule has been deleted.' => 'Het gevraagde opnameschema is verwijderd',
    'Thursday'                                           => 'Donderdag',
    'Title'                                              => 'Titel',
    'Transcoder'                                         => 'Transcoder',
    'Tuesday'                                            => 'Dinsdag',
    'Type'                                               => 'Type',
    'Unknown'                                            => 'Onbekend',
    'Upcoming Recordings'                                => 'Geplande Opnames',
    'Update'                                             => 'Aanpassen',
    'Update Recording Settings'                          => 'Opname-instellingen Vernieuwen',
    'Weather'                                            => 'Weer',
    'Wednesday'                                          => 'Woensdag',
    'Yes'                                                => 'Ja',
    'airdate'                                            => 'uitzenddatum',
    'channum'                                            => 'zender',
    'description'                                        => 'beschrijving',
    'generic_date'                                       => '%a %e %b, %Y',
    'generic_time'                                       => '%H:%M',
    'length'                                             => 'duur',
    'minutes'                                            => 'minuten',
    'recgroup'                                           => 'opnamegroep',
    'recpriority'                                        => 'opnameprioriteit',
    'rectype-long: always'                               => 'Altijd op elke zender opnemen.',
    'rectype-long: channel'                              => 'Altijd op deze zender opnemen.',
    'rectype-long: daily'                                => 'Dagelijks in dit tijdsslot opnemen.',
    'rectype-long: dontrec'                              => 'Niet opnemen',
    'rectype-long: finddaily'                            => 'Dagelijks een uitzending opnemen',
    'rectype-long: findone'                              => '1 uitzending opnemen',
    'rectype-long: findweekly'                           => 'Wekelijks een uitzending opnemen',
    'rectype-long: once'                                 => 'Deze uitzending opnemen.',
    'rectype-long: override'                             => 'Aangepaste opties',
    'rectype-long: weekly'                               => 'Wekelijks in dit tijdsslot opnemen.',
    'rectype: always'                                    => 'Altijd',
    'rectype: channel'                                   => 'Zender',
    'rectype: daily'                                     => 'Dagelijks',
    'rectype: dontrec'                                   => 'Niet Opnemen',
    'rectype: findone'                                   => '1 Opnemen',
    'rectype: once'                                      => 'Deze',
    'rectype: override'                                  => 'Aangepast (opname)',
    'rectype: weekly'                                    => 'Wekelijks',
    'subtitle'                                           => 'aflevering',
    'title'                                              => 'titel',
// config/canned_searches.php
    'All HDTV'                           => 'Alle HDTV',
    'Movies'                             => 'Films',
    'Movies, 3&frac12; Stars or more'    => 'Films, 3&frac12; sterren of meer',
    'Movies, Stinkers (2 Stars or less)' => 'Films, Stinkers (2 sterren of minder)',
    'Music Specials'                     => 'Muziek Specials',
    'New Titles, Premieres'              => 'Nieuwe Titels, Premieres',
    'Non-Music Specials'                 => 'Niet-Muziek Specials',
    'Non-Series HDTV'                    => 'HDTV, geen series',
    'Science Fiction Movies'             => 'Science Fiction Films',
// includes/programs.php
    'CC'                           => 'OND',
    'HDTV'                         => 'HDTV',
    'Notes'                        => 'Opmerkingen',
    'Part $1 of $2'                => 'Deel $1 van $2',
    'Stereo'                       => 'Stereo',
    'Subtitled'                    => 'Ondertiteld',
    'recstatus: cancelled'         => 'Dit programma zou opgenomen worden maar werd handmatig geannuleerd',
    'recstatus: conflict'          => 'Een ander programma met hogere prioriteit zal opgenomen worden',
    'recstatus: currentrecording'  => 'Dit programma werd eerder opgenomen en bevindt zich nog in de lijst met opgenomen programma\'s',
    'recstatus: deleted'           => 'Dit programma werd opgenomen maar werd al verwijderd voor de opname afgelopen was.',
    'recstatus: earliershowing'    => 'Dit programma wordt op een vroegere tijd opgenomen.',
    'recstatus: force_record'      => 'Dit programma werd handmatig ingesteld op deze manier opgenomen te worden.',
    'recstatus: inactive'          => 'Dit opnameschema is niet actief',
    'recstatus: latershowing'      => 'Dit programma zal op een later tijdstip opgenomen worden.',
    'recstatus: lowdiskspace'      => 'Er was niet voldoende schijfruimte aanwezig om dit programma op te nemen.',
    'recstatus: manualoverride'    => 'Dit werd handmatig ingesteld niet opgenomen te worden.',
    'recstatus: neverrecord'       => 'Dit programma werd ingesteld nooit opgenomen te wordem',
    'recstatus: notlisted'         => 'Dit programa komt niet overeen met de programmagids',
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
    'rectype: finddaily'           => 'Dagelijkse een uitzending opnemen.',
    'rectype: findweekly'          => 'Wekelijkse een uitzending opnemen.',
// includes/utils.php
    '$1 B'  => '$1 B',
    '$1 GB' => '$1 GB',
    '$1 KB' => '$1 KB',
    '$1 MB' => '$1 MB',
    '$1 TB' => '$1 TB',
// modules/backend_log/init.php
    'Logs' => 'Logboek',
// modules/movietimes/init.php
    'Movie Times' => 'Bioscoop Tijden',
// modules/settings/init.php
    'MythTV channel info'      => 'MythTV zenderinfo',
    'MythTV key bindings'      => 'MythTV toetsbindingen',
    'MythWeb session settings' => 'MythWeb sessie instellingen',
    'settings'                 => 'instellingen',
// modules/status/init.php
    'Status' => 'Status',
// modules/stream/init.php
    'Streaming' => 'Stroom aan het doorsturen',
// modules/tv/detail.php
    'This program is already scheduled to be recorded via a $1custom search$2.' => 'Dit programma is al ingesteld opgenomen te worden via $1custom search$2',
    'Unknown Program.'                                                          => 'Onbekend Programma.',
    'Unknown Recording Schedule.'                                               => 'Onbekend Opnameschema',
// modules/tv/init.php
    'Special Searches' => 'Speciaal zoeken',
    'TV'               => 'TV',
// modules/tv/recorded.php
    'No matching programs found.'             => 'Geen overeenkomsten gevonden',
    'Showing all programs from the $1 group.' => 'Alle programma\'s uit de $1 groep laten zien',
    'Showing all programs.'                   => 'Alle programma\'s laten zien',
// modules/tv/schedules_custom.php
    'Any Category'                               => 'Alle categorien',
    'Any Channel'                                => 'Alle zenders',
    'Any Program Type'                           => 'Alle programmatypes',
    'Find Time must be of the format:  HH:MM:SS' => 'Tijd moet in het formaat: HH:MM:SS zijn',
// modules/tv/schedules_manual.php
    'Use callsign'  => 'Zender gebruiken',
    'Use date/time' => 'Datum/tijd gebruiken',
// modules/tv/search.php
    'Please search for something.' => 'Graag iets zoeken.',
// modules/video/init.php
    'Video' => 'Films',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => 'Logboek laten zien',
// themes/default/header.php
    'Category Legend'                            => 'Categorie Legende',
    'Category Type'                              => 'Categorie Type',
    'Custom'                                     => 'Geavanceerd',
    'Edit MythWeb and some MythTV settings.'     => 'MythWeb en enkele MythTV instellingen bewerken',
    'Exact Match'                                => 'Exacte Overeenkomst',
    'Fold Duplicates'                            => '',
    'HD Only'                                    => 'Enkel HD',
    'Manual'                                     => 'Manueel',
    'MythMusic on the web.'                      => 'Muziek',
    'MythVideo on the web.'                      => 'Video',
    'MythWeb Weather.'                           => 'Weer',
    'Search fields'                              => 'Zoek Velden',
    'Search help'                                => 'Zoek Help',
    'Search help: movie example'                 => '*** 1/2 Avontuur',
    'Search help: movie search'                  => 'zoek films',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'regex zoeken',
    'Search options'                             => 'Zoeken Opties',
    'Searches'                                   => 'Zoekopdrachten',
    'TV functions, including recorded programs.' => 'TV functies, inclusief opgenomen programma\'s',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => 'De filmtijden voor uw lokale bioscoop',
// themes/default/music/music.php
    'Album'               => 'Album',
    'Album (filtered)'    => 'Album (filter)',
    'All Music'           => 'Alle muziek',
    'Artist'              => 'Artiest',
    'Artist (filtered)'   => 'Artiest (filter)',
    'Displaying'          => 'Zichtbaar',
    'Duration'            => 'Lengte',
    'End'                 => 'Einde',
    'Filtered'            => 'Met filter',
    'Genre'               => 'Genre',
    'Genre (filtered)'    => 'Genre (filter)',
    'Next'                => 'Volgende',
    'No Tracks Available' => 'Geen nummers gevonden',
    'Previous'            => 'Vorige',
    'Top'                 => 'Begin',
    'Track Name'          => 'Naam',
    'Unfiltered'          => 'Zonder filter',
// themes/default/music/welcome.php
    'welcome: music' => 'Doorheen uw muziekcollectie bladeren',
// themes/default/settings/channels.php
    'Configure Channels'                                                                                                                 => 'Zenders instellen',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Waarschuwing! Als u niet weet wat u doet, kan het veranderen van deze tabel de werking van MythTV ernstig verstoren.',
    'brightness'                                                                                                                         => 'helderheid',
    'callsign'                                                                                                                           => 'zender',
    'colour'                                                                                                                             => 'kleur',
    'commfree'                                                                                                                           => 'reclamevrij',
    'contrast'                                                                                                                           => 'contrast',
    'delete'                                                                                                                             => 'verwijderen',
    'finetune'                                                                                                                           => 'fijn afstemmen',
    'freqid'                                                                                                                             => 'frequentie',
    'hue'                                                                                                                                => 'verzadiging',
    'name'                                                                                                                               => 'naam',
    'sourceid'                                                                                                                           => 'bron',
    'useonairguide'                                                                                                                      => 'gebruikepg',
    'videofilters'                                                                                                                       => 'videofilters',
    'visible'                                                                                                                            => 'zichtbaar',
    'xmltvid'                                                                                                                            => 'xmltvid',
// themes/default/settings/keys.php
    'Action'                => 'Actie',
    'Configure Keybindings' => 'Toetsbindingen instellen',
    'Context'               => 'Onderdeel',
    'Destination'           => 'Bestemming',
    'Edit keybindings on'   => 'Toetsbindingen bewerken op',
    'JumpPoints Editor'     => 'Snelkoppelingen bewerken',
    'Key bindings'          => 'Toetsbindingen',
    'Keybindings Editor'    => 'Toetsbindingen bewerken',
    'Set Host'              => 'Host instellen',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'Zender &quot;Ga naar&quot;',
    'Date Formats'                    => 'Weergave Datum',
    'Guide Settings'                  => 'Gidsinstellingen',
    'Hour Format'                     => 'Weergave Tijd',
    'Language'                        => 'Taal',
    'Listing &quot;Jump to&quot;'     => 'Gids &quot;Ga naar&quot;',
    'Listing Time Key'                => 'Weergave Tijd Gids',
    'MythWeb Session Settings'        => 'MythWen Sessie Instellingen',
    'MythWeb Theme'                   => 'MythWeb Thema',
    'Only display favourite channels' => 'Enkel favoriete zenders laten zien',
    'Reset'                           => 'Herstellen',
    'SI Units?'                       => 'SI eenheden?',
    'Scheduled Popup'                 => 'Geprogrammeerde Pop-up',
    'Show descriptions on new line'   => 'Beschrijvingen op nieuwe regel',
    'Status Bar'                      => 'Statusbalk',
    'Weather Icons'                   => 'Weer iconen',
    'format help'                     => 'formaat help',
// themes/default/settings/settings.php
    'settings: overview' => 'instellingen: overzicht',
// themes/default/settings/welcome.php
    'welcome: settings' => 'MythWeb en enkele MythTV instellingen bewerken',
// themes/default/status/welcome.php
    'welcome: status' => 'MythTV Logboek',
// themes/default/tv/channel.php
    'Channel Detail' => 'Zender detail',
    'Length'         => 'Duur',
    'Show'           => 'Toon',
    'Time'           => 'Tijd',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Terug naar programmagids',
    'Back to the recording schedules'     => 'Terug naar opnameschema',
    'Cast'                                => 'Acteurs',
    'Directed by'                         => 'Regisseur',
    'Don\'t record this program.'         => 'Dit programma niet opnemen',
    'Episode Number'                      => 'Aflevering nr.',
    'Exec. Producer'                      => 'Uitv. Producent',
    'Find other showings of this program' => 'Andere afleveringen van dit programma zoeken',
    'Find showings of this program'       => 'Afleveringen van dit programma zoeken',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Gastrol',
    'Guide rating'                        => 'Gids beoordeling',
    'Hosted by'                           => '',
    'MythTV Status'                       => 'MythTV status',
    'Possible conflicts with this show'   => 'Mogelijk conflict met dit programma',
    'Presented by'                        => 'Presentator',
    'Produced by'                         => 'Producent',
    'Program Detail'                      => 'Pragrammadetails',
    'Program ID'                          => 'Programma ID',
    'TV.com'                              => 'TV.com',
    'Time Stretch Default'                => 'TimeStretch Standaard',
    'What else is on at this time?'       => 'Wat wordt er nog uitgezonden op dit tijdstip?',
    'Written by'                          => 'Auteur',
// themes/default/tv/list.php
    'Jump To' => 'Ga naar',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => 'GEEN DATA',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 aflevering',
    '$1 episodes'                                         => '$1 afleveringen',
    '$1 recording'                                        => '$1 opname',
    '$1 recordings'                                       => '$1 opnames',
    'All groups'                                          => 'Alle groepen',
    'Are you sure you want to delete the following show?' => 'Bent U zeker van het verwijderen van volgend programma?',
    'Delete'                                              => 'Verwijderen',
    'Delete $1'                                           => '$1 verwijderen',
    'Delete + Rerecord'                                   => 'Verwijderen en opnieuw opnemen',
    'Delete and rerecord $1'                              => 'Verwijderen en $1 opnieuw opnemen',
    'Go'                                                  => 'Doorgaan',
    'Show group'                                          => 'Groep tonen',
    'Show recordings'                                     => 'Opnames tonen',
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
    'transcoder'                                => 'transcoder',
    'type'                                      => 'type',
// themes/default/tv/schedules_custom.php
    'Additional Tables'        => 'Aanvullende tabellen',
    'Find Date & Time Options' => 'Datum &amp; tijd zoeken, opties',
    'Find Day'                 => 'Dag zoeken',
    'Find Time'                => 'Tijd zoeken',
    'Keyword Search'           => 'Kernwoord zoeken',
    'People Search'            => 'Personen zoeken',
    'Power Search'             => 'Geavanceerd zoeken',
    'Search Phrase'            => 'Zin zoeken',
    'Search Type'              => 'Type zoeken',
    'Title Search'             => 'Titel zoeken',
// themes/default/tv/schedules_manual.php
    'Channel'      => 'Zender',
    'Length (min)' => 'Duur (min)',
    'Start Date'   => 'Start Datum',
    'Start Time'   => 'Start Tijd',
// themes/default/tv/search.php
    'No matches found'                 => 'Geen programma\'s gevonden',
    'No matching programs were found.' => 'Geen overeenkomende programma\'s gevonden',
    'Search for:  $1'                  => 'Zoeken: $1',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => 'Handige voorgeprogrammeerde zoekopdrachten',
    'handy: overview'           => 'Deze pagina bevat handige voorgeprogrammeerde complexe zoekopdrachten',
// themes/default/tv/upcoming.php
    'Commands'    => 'Opdrachten',
    'Conflicts'   => 'Conflicten',
    'Deactivated' => 'Gedeactiveerd',
    'Duplicates'  => 'Dubbels',
    'Scheduled'   => 'Geprogrammeerd',
// themes/default/tv/welcome.php
    'welcome: tv' => 'Laten zien wat er op TV is, opnames plannen en opgenomen programma\'s beheren. Keuze uit de volgende items:',
// themes/default/video/video.php
    'Edit'          => 'Bewerken',
    'Reverse Order' => 'Volgorde omkeren',
    'Videos'        => 'Films',
    'category'      => 'categorie',
    'cover'         => 'hoes',
    'director'      => 'regisseur',
    'imdb rating'   => 'imdb beoordeling',
    'plot'          => 'korte inhoud',
    'rating'        => 'beoordeling',
    'year'          => 'jaar',
// themes/default/video/welcome.php
    'welcome: video' => 'Doorheen uw filmcollectie bladeren.',
// themes/default/weather/weather.php
    ' at '               => ' aan ',
    'Current Conditions' => 'Huidige Waarnemingen',
    'Forecast'           => 'Voorspelling',
    'High'               => 'Maximum',
    'Humidity'           => 'Vochtigheid',
    'Last Updated'       => 'Laatst Vernieuwd',
    'Low'                => 'Minimum',
    'Pressure'           => 'Luchtdruk',
    'Radar'              => 'Radar',
    'Today'              => 'Vandaag',
    'Tomorrow'           => 'Morgen',
    'UV Extreme'         => 'UV Zeer Hoog',
    'UV High'            => 'UV Hoog',
    'UV Index'           => 'UV Index',
    'UV Minimal'         => 'UV Laag',
    'UV Moderate'        => 'UV Gemiddeld',
    'Visibility'         => 'Zichtbaarheid',
    'Wind'               => 'Wind',
    'Wind Chill'         => 'Voeltemp. Wind',
// themes/default/weather/welcome.php
    'welcome: weather' => 'Uw lokale weerbericht',
// themes/default/welcome.php
    'Visit $1' => ''
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

