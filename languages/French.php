<?php
/***                                                                        ***\
    languages/French.php

    Translation hash for French.
\***                                                                        ***/

// Set locale to French
setlocale(LC_ALL, 'fr_FR');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 Search'                                          => '',
    '$1 hr'                                              => '$1 hr',
    '$1 hrs'                                             => '$1 hrs',
    '$1 min'                                             => '$1 Min',
    '$1 mins'                                            => '$1 Mins',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 Emission, utilisant $2 ($3) parmis $4',
    '$1 to $2'                                           => 'de $1 &agrave; $2',
    'Activate'                                           => 'Activer',
    'Advanced Options'                                   => 'Options avancées',
    'Airtime'                                            => 'Heure de diffusion',
    'All recordings'                                     => 'Tous les enregistrements',
    'Auto-expire recordings'                             => 'Enregistrements auto-exiprant',
    'Auto-flag commercials'                              => 'Marquer les pubs',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'Statut du Backend',
    'Cancel this schedule.'                              => 'Annuler cette programmation',
    'Category'                                           => 'cat&eacute;gorie',
    'Check for duplicates in'                            => 'Cherche les doublons dans',
    'Create Schedule'                                    => 'Creer une programmation',
    'Current recordings'                                 => 'Enregistrements courant',
    'Currently Browsing:  $1'                            => 'Actuellement Affich&eacute;',
    'Custom Schedule'                                    => '',
    'Date'                                               => 'Date',
    'Default'                                            => 'Par d&eacute;faut',
    'Description'                                        => 'Description',
    'Details for'                                        => '',
    'Display'                                            => 'Afficher',
    'Don\'t Record'                                      => 'Ne pas enregistrer',
    'Duplicate Check method'                             => 'M&eacute;thode de test des doublons',
    'End Late'                                           => 'Fin tardive',
    'Episode'                                            => 'Episode',
    'Forget Old'                                         => 'oublier les anciens',
    'Friday'                                             => 'Vendredi',
    'Hour'                                               => 'Heure',
    'IMDB'                                               => 'Allocin&eacute;',
    'Inactive'                                           => 'Inactif',
    'Jump'                                               => 'Aller',
    'Jump to'                                            => 'Sauter vers',
    'Keyword'                                            => '',
    'Listings'                                           => 'Liste',
    'Monday'                                             => 'Lundi',
    'Music'                                              => '',
    'Never Record'                                       => 'Ne jamais enregistrer',
    'No'                                                 => 'Non',
    'No. of recordings to keep'                          => 'Nombre d&acute;enregistrements &agrave; garder',
    'None'                                               => 'Aucun',
    'Only New Episodes'                                  => 'Seulement les nouveaux &eacute;pisodes',
    'Original Airdate'                                   => 'Heure de diffusion d&acute;origine',
    'People'                                             => '',
    'Power'                                              => '',
    'Previous recordings'                                => 'Enregistrements pr&eacute;c&eacute;dents',
    'Program Listing'                                    => '',
    'Rating'                                             => '&eacute;valuation',
    'Record This'                                        => 'Enregistrer Ceci',
    'Record new and expire old'                          => 'Enregistrer un nouveau et expirer l&acute;ancien',
    'Recorded Programs'                                  => 'Programmes enregistr&eacute;s',
    'Recording Group'                                    => 'Groupe d&acute;enregistrement',
    'Recording Options'                                  => 'Options d&acute;enregistrement',
    'Recording Priority'                                 => 'Priorit&eacute; d&acute;enregistrement',
    'Recording Profile'                                  => 'Profile d&acute;enregistrement',
    'Recording Schedules'                                => 'Programmation des enregistrements',
    'Repeat'                                             => 'Relancer',
    'Saturday'                                           => 'Samedi',
    'Save'                                               => 'Sauver',
    'Save Schedule'                                      => 'Sauver une programmation',
    'Schedule'                                           => 'Programmer',
    'Schedule Manually'                                  => '',
    'Schedule Options'                                   => 'Prog. Avancée',
    'Schedule Override'                                  => 'Ecraser Prog.',
    'Schedule normally.'                                 => 'Prog. normale',
    'Search'                                             => 'Recherche',
    'Search Results'                                     => 'R&eacute;sultats de recherche',
    'Settings'                                           => 'param&egrave;tres',
    'Start Early'                                        => 'D&eacute;marrer plus tot',
    'Subtitle'                                           => 'Soustitre',
    'Subtitle and Description'                           => 'Soustitre et description',
    'Sunday'                                             => 'Dimanche',
    'The requested recording schedule has been deleted.' => 'L\'enregistrement demandé a été effacé',
    'Thursday'                                           => 'Jeudi',
    'Title'                                              => 'Titre',
    'Transcoder'                                         => '',
    'Tuesday'                                            => 'Mardi',
    'Type'                                               => 'Type',
    'Unknown'                                            => 'Inconnu',
    'Upcoming Recordings'                                => '',
    'Update'                                             => 'Rafraîchir',
    'Update Recording Settings'                          => 'Actualiser les param&egrave;tres d&acute;enregistrement',
    'Weather'                                            => '',
    'Wednesday'                                          => 'Mercredi',
    'Yes'                                                => 'Oui',
    'airdate'                                            => 'Date de diffusion',
    'channum'                                            => 'Chaine',
    'description'                                        => 'Description',
    'generic_date'                                       => '%e %b, %Y',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => 'Dur&eacute;e',
    'minutes'                                            => 'minutes',
    'recgroup'                                           => 'Groupe d&eacute;enr',
    'recpriority'                                        => '',
    'rectype-long: always'                               => 'Enregistrer tout le temps quelque soit la chaine.',
    'rectype-long: channel'                              => 'Enregistrer tout le temps sur la chaine $1.',
    'rectype-long: daily'                                => 'Enregistrer ce programme &agrave; cette heure chaque jour.',
    'rectype-long: dontrec'                              => 'ne pas enregistrer cette diffusion',
    'rectype-long: finddaily'                            => 'Trouver un enregistrement avec ce titre aujourd&acute;hui et l&acute;enregistrer',
    'rectype-long: findone'                              => 'Trouver un enregistrement avec ce titre et l&acute;enregistrer',
    'rectype-long: findweekly'                           => 'Trouver un enregistrement avec ce titre cette semaine et l&acute;enregistrer',
    'rectype-long: once'                                 => 'Enregistrer seulement cette diffusion',
    'rectype-long: override'                             => 'Enregistrer cette diffusion',
    'rectype-long: weekly'                               => 'Enregistrer ce programme &agrave; cette heure chaque semaine',
    'rectype: always'                                    => 'Toujours',
    'rectype: channel'                                   => 'Chaine',
    'rectype: daily'                                     => 'Quotidien',
    'rectype: dontrec'                                   => 'Ne pas Rec',
    'rectype: findone'                                   => 'Trouver Un',
    'rectype: once'                                      => 'Unique',
    'rectype: override'                                  => 'R&eacute;&eacute;crire',
    'rectype: weekly'                                    => 'hebdomadaire',
    'subtitle'                                           => 'Sous titre',
    'title'                                              => 'Titre',
// includes/programs.php
    'CC'                           => '',
    'HDTV'                         => '',
    'Notes'                        => 'Notes',
    'Part $1 of $2'                => '',
    'Stereo'                       => '',
    'Subtitled'                    => '',
    'recstatus: cancelled'         => 'Enregistrement pr&eacute;vu mais annul&eacute;',
    'recstatus: conflict'          => 'Un autre programme plus prioritaire sera enregistr&eacute;',
    'recstatus: currentrecording'  => 'Cet &eacute;pisode &agrave; d&eacute;ja &eacute;t&eacute; enregistr&eacute; et est encore disponible pour relecture',
    'recstatus: deleted'           => 'Cette &eacute;mission a &eacute;t&eacute; enregistr&eacute;e et annul&eacute; avant la fin d&acute;enregistrement',
    'recstatus: earliershowing'    => 'Cette &eacute;mission sera enregistr&eacute; plus tot &agrave; la place',
    'recstatus: force_record'      => 'Cette diffusion a &eacute;t&eacute; manuellement enregistr&eacute;e &agrave; cette heure',
    'recstatus: inactive'          => '',
    'recstatus: latershowing'      => 'Cette &eacute;mission sera enregistr&eacute; plus tard &agrave; la place',
    'recstatus: lowdiskspace'      => 'Il n&acute;y a pas assez de place sur le disque pour l&acute;enregistrement',
    'recstatus: manualoverride'    => 'D&eacute;j&agrave; forc&eacute; &agrave; la main &agrave; pas d&acute;enregistrement',
    'recstatus: neverrecord'       => '',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => 'Cette &eacute;mission a d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute;e en raison de la gestion des doublons pour ce programme',
    'recstatus: recorded'          => 'Cette &eacute;mission est enregistr&eacute;e',
    'recstatus: recording'         => 'Cette &eacute;mission est en cours d&acute;enregistrement',
    'recstatus: repeat'            => 'Cette rediffusion ne sera pas enregistr&eacute;e',
    'recstatus: stopped'           => 'Cette &eacute;mission a &eacute;t&eacute; enregistr&eacute;e et Arret&eacute;e avant la fin d&acute;enregistrement',
    'recstatus: toomanyrecordings' => 'trop d&acute;enregistrement de ce programmme ont &eacute;t&eacute; effectu&eacute;es',
    'recstatus: tunerbusy'         => 'La carte tuner &eacute;tait utilis&eacute;e pendant la programmation de l&acute;enregistrement',
    'recstatus: unknown'           => 'Le statut de cette&eacute;mission est inconnu',
    'recstatus: willrecord'        => 'Cet &eacute;mission sera enregistr&eacute;e.',
// includes/recording_schedules.php
    'Dup Method'                   => 'm&eacute;thode de dup',
    'Profile'                      => 'Profil',
    'Sub and Desc (Empty matches)' => 'Sub et Desc (Vide correspond)',
    'rectype: finddaily'           => 'Trouver aujourd\'hui',
    'rectype: findweekly'          => 'trouver cette semaine',
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
    'Unknown Program.'                                                          => 'Programme inconnu',
    'Unknown Recording Schedule.'                                               => 'Programmation inconnue',
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
    'Please search for something.' => 'Veuillez chercher quelque chose',
// modules/video/init.php
    'Video' => '',
// themes/default/backend_log/backend_log.php
    'Backend Logs' => '',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => '',
// themes/default/header.php
    'Category Legend'                            => 'L&eacute;g&eacute;nde de Cat&eacute;gorie',
    'Category Type'                              => 'Type de cat&eacute;gorie',
    'Custom'                                     => '',
    'Edit MythWeb and some MythTV settings.'     => 'Editer les param&egrave;tres de Mythweb et certains de MythTV',
    'Exact Match'                                => 'Correspondance exacte',
    'HD Only'                                    => 'TVHD seul',
    'Manual'                                     => '',
    'MythMusic on the web.'                      => 'MythMusic sur le Web',
    'MythVideo on the web.'                      => 'Mythvideo sur le Web',
    'MythWeb Weather.'                           => 'M&eacute;t&eacute;o sur le web',
    'Search fields'                              => 'Champs de recherche',
    'Search help'                                => 'Aide de la recherche',
    'Search help: movie example'                 => '*** 1/2 Adventure',
    'Search help: movie search'                  => 'movie search',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => 'regex search',
    'Search options'                             => 'Options de recherche',
    'Searches'                                   => 'Recherches',
    'TV functions, including recorded programs.' => 'Fonctions TV, inclant les enregistrements d&acute;&eacute;missions',
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
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Nous vous pr&eacute;venons que modifier les touches sans savoir ce que vous fa&icirc;tes peut s&eacute;rieusement endomager le fonctionnement de MythTV',
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
    'Edit keybindings on'   => 'Editer les touches sur',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'Cha&icirc;ne &quot;Aller &agrave;&quot;',
    'Date Formats'                    => 'Formats de date',
    'Guide Settings'                  => 'Paramètres du Guide',
    'Hour Format'                     => 'Format d&acute;heures',
    'Language'                        => 'Langue',
    'Listing &quot;Jump to&quot;'     => 'Lister &quot;Aller &agrave;&quot;',
    'Listing Time Key'                => 'Lister Touches de temps',
    'MythWeb Session Settings'        => '',
    'MythWeb Theme'                   => 'Th&egrave;me de Mythweb',
    'Only display favourite channels' => 'Afficher seulement vos chaînes favorites',
    'Reset'                           => 'Reset',
    'SI Units?'                       => 'Unités métriques?',
    'Scheduled Popup'                 => 'Boite de programmation',
    'Show descriptions on new line'   => 'Afficher la description sur une nouvelle ligne',
    'Status Bar'                      => 'Barre de statut',
    'Weather Icons'                   => 'Icones météos',
    'format help'                     => 'Format d&acute;aide',
// themes/default/settings/settings.php
    'settings: overview' => 'ceci est la page d&acute;index pour les param&eacute;tres de configuration...<p>C&acute;est incomplet et pourrait &ecirc;tre mieux format&eacute;.  Pour le moment vous pouvez choisir parmis:',
// themes/default/settings/welcome.php
    'welcome: settings' => '',
// themes/default/status/welcome.php
    'welcome: status' => '',
// themes/default/tv/channel.php
    'Channel Detail' => '',
    'Length'         => 'Dur&eacute;e',
    'Show'           => 'Diffusion',
    'Time'           => 'Heure',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Retourner &agrave; la liste des &eacute;missions',
    'Back to the recording schedules'     => 'Retourner aux programmations programm&eacute;es',
    'Cast'                                => 'Acteurs',
    'Directed by'                         => 'Mis en scène par',
    'Don\'t record this program.'         => 'Ne pas enregistrer cette &eacute;mission',
    'Episode Number'                      => '',
    'Exec. Producer'                      => 'Producteur',
    'Find other showings of this program' => 'Trouver d&acute;autres diffusions de cette &eacute;mission',
    'Find showings of this program'       => 'Trouver les diffusions de cette émission',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Invité d\'honneur',
    'Guide rating'                        => '',
    'Hosted by'                           => 'Hébergé par',
    'MythTV Status'                       => '',
    'Possible conflicts with this show'   => '',
    'Presented by'                        => 'Présenté par',
    'Produced by'                         => 'Produit par',
    'Program Detail'                      => '',
    'Program ID'                          => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'Quoi d&acute;autre &agrave; cette heure',
    'Written by'                          => 'Ecrit par',
// themes/default/tv/list.php
    'Jump To' => 'Aller &agrave;',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 &eacute;pisode',
    '$1 episodes'                                         => '$1 &eacute;pisodes',
    '$1 recording'                                        => '$1 enregistrement',
    '$1 recordings'                                       => '$1 enregistrements',
    'All groups'                                          => '',
    'Are you sure you want to delete the following show?' => 'Etes vous s&ucirc;r d&acute;effacer cette &eacute;mission',
    'Delete'                                              => 'Effacer',
    'Delete $1'                                           => '',
    'Delete + Rerecord'                                   => '',
    'Delete and rerecord $1'                              => '',
    'Go'                                                  => 'Go',
    'Show group'                                          => 'Monter les groupes',
    'Show recordings'                                     => 'Monter les enregistrements',
    'auto-expire'                                         => 'auto-expire',
    'file size'                                           => 'taille de fichier',
    'has bookmark'                                        => 'a des signets',
    'has commflag'                                        => 'a des marques de pub',
    'has cutlist'                                         => 'a une liste de coupe',
    'is editing'                                          => 'est &eacute;dit&eacute;',
    'preview'                                             => 'Aper&ccedil;u',
// themes/default/tv/schedules.php
    'Any'                                       => 'Tous',
    'No recording schedules have been defined.' => 'Aucune programmation n\'est définie',
    'channel'                                   => 'Chaîne',
    'profile'                                   => 'Profil',
    'transcoder'                                => '',
    'type'                                      => 'Type',
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
    'Channel'      => 'Cha&icirc;ne',
    'Length (min)' => 'Dur&eacute;e (min)',
    'Start Date'   => 'Date de d&eacute;but',
    'Start Time'   => 'Heure de d&eacute;but',
// themes/default/tv/search.php
    'No matches found'                 => 'Aucune correspondance',
    'No matching programs were found.' => '',
    'Search for:  $1'                  => 'Chercher:    $1',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => '',
    'handy: overview'           => 'Cette page contient des recherches préparées dans le programme TV',
// themes/default/tv/upcoming.php
    'Commands'    => 'Commandes',
    'Conflicts'   => 'entre en conflit',
    'Deactivated' => 'D&eacute;sactiver',
    'Duplicates'  => 'Doublonner',
    'Scheduled'   => 'Programm&eacute;',
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
    ' at '               => '&agrave;',
    'Current Conditions' => 'Conditions courantes',
    'Forecast'           => 'Pr&eacute;visions',
    'High'               => '&eacute;lev&eacute;',
    'Humidity'           => 'Humidit&eacute;',
    'Last Updated'       => 'Derni&egrave;re mise &agrave; jour',
    'Low'                => 'faible',
    'Pressure'           => 'Pression',
    'Radar'              => 'Radar',
    'Today'              => 'Aujourd&acute;hui',
    'Tomorrow'           => 'Demain',
    'UV Extreme'         => 'Indice UV Extr&egrave;me',
    'UV High'            => 'Indice UV &eacute;lev&eacute;',
    'UV Index'           => 'Index UV',
    'UV Minimal'         => 'Indice UV minimal',
    'UV Moderate'        => 'Indice UV mod&eacute;r&eacute;',
    'Visibility'         => 'Visibilit&eacute;',
    'Wind'               => 'Vent',
    'Wind Chill'         => 'Vent Frais',
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
$Categories['Action']         = array('Action',                                   '\\b(?:action|adven)');
$Categories['Adult']          = array('Adulte',                                   '\\b(?:adult|erot|sex)');
$Categories['Animals']        = array('Animals',                                  '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Musique',                                  '\\b(?:art|dance|musi[ck]|spectacle|musique|kunst|[ck]ultur|culture)');
$Categories['Business']       = array('Divertissement',                           '\\b(?:divertissement)');
$Categories['Children']       = array('Jeunesse',                                 '\\b(?:child|kin?d|infan|jeunesse|animation)');
$Categories['Comedy']         = array('Spectacle',                                '\\b(?:comed|entertain|spectacle|sitcom)');
$Categories['Crime_Mystery']  = array('Surprise',                                 '\\b(?:[ck]rim|myster|surprise)');
$Categories['Documentary']    = array('Documentaire',                             '\\b(?:do[ck])|mag');
$Categories['Drama']          = array('Court-m&eacute;trage',                     '\\b(?:court)');
$Categories['Educational']    = array('Educatif',                                 '\\b(?:cours|edu|bildung|interests)');
$Categories['Food']           = array('Cuisine',                                  '\\b(?:food|cook|essen|gastro|cuisine|[dt]rink)');
$Categories['Game']           = array('Jeu',                                      '\\b(?:game|spiele|jeu)');
$Categories['Health_Medical'] = array('Sant&eacute;',                             '\\b(?:health|medic|gesundheit|sant)');
$Categories['History']        = array('Magazine',                                 '\\b(?:hist|geschichte)');
$Categories['Horror']         = array('Horreur',                                  '\\b(?:horreur)');
$Categories['HowTo']          = array('Th&eacute;matique',                        '\\b(?:th.*matique)');
$Categories['Misc']           = array('Divers',                                   '\\b(?:special|variety|collect)');
$Categories['News']           = array('Information',                              '\\b(?:news|nachrichten|info|current)');
$Categories['Reality']        = array('T&eacute;l&eacute;-r&eacute;alit&eacute;', '\\b(?:reality|realit.*)');
$Categories['Romance']        = array('T&eacute;l&eacute;film',                   '\\b(?:t.*l.*film|romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Nature',                                   '\\b(?:science|nature|environment|wissenschaft)');
$Categories['Science_Nature'] = array('Fantastique',                              '\\b(?:fantasy|fantastique|sci\\w*\\W*fi)');
$Categories['Shopping']       = array('T&eacute;l&eacute;-Shopping',              '\\b(?:shop)');
$Categories['Soaps']          = array('S&eacute;rie',                             '\\b(?:s.*rie|soap|t.*l.*film|feuilleton)');
$Categories['Spiritual']      = array('Spirituel',                                '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Sport',                                    '\\b(?:sport|foot|deportes|futbol)');
$Categories['Talk']           = array('D&eacute;bat',                             '\\b(?:talk|D.*bat)');
$Categories['Travel']         = array('Voyage',                                   '\\b(?:travel|reisen|voyage)');
$Categories['War']            = array('Guerre',                                   '\\b(?:war|krieg|guerre)');
$Categories['Western']        = array('Western',                                  '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Inconnu');
$Categories['movie']          = array('Film'  );

