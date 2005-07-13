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
    ' at '                                                                                                                               => '&agrave;',
    '$1 B'                                                                                                                               => '$1 B',
    '$1 GB'                                                                                                                              => '$1 GB',
    '$1 KB'                                                                                                                              => '$1 KB',
    '$1 MB'                                                                                                                              => '$1 MB',
    '$1 Rating'                                                                                                                          => 'Evaluation de $1',
    '$1 TB'                                                                                                                              => '$1 TB',
    '$1 episode'                                                                                                                         => '$1 &eacute;pisode',
    '$1 episodes'                                                                                                                        => '$1 &eacute;pisodes',
    '$1 hr'                                                                                                                              => '$1 hr',
    '$1 hrs'                                                                                                                             => '$1 hrs',
    '$1 min'                                                                                                                             => '$1 Min',
    '$1 mins'                                                                                                                            => '$1 Mins',
    '$1 programs, using $2 ($3) out of $4.'                                                                                              => '$1 Emission, utilisant $2 ($3) parmis $4',
    '$1 recording'                                                                                                                       => '$1 enregistrement',
    '$1 recordings'                                                                                                                      => '$1 enregistrements',
    '$1 to $2'                                                                                                                           => 'de $1 &agrave; $2',
    'Activate'                                                                                                                           => 'Activer',
    'Advanced Options'                                                                                                                   => 'Options avancées',
    'Airtime'                                                                                                                            => 'Heure de diffusion',
    'All recordings'                                                                                                                     => 'Tous les enregistrements',
    'Any'                                                                                                                                => 'Tous',
    'Are you sure you want to delete the following show?'                                                                                => 'Etes vous s&ucirc;r d&acute;effacer cette &eacute;mission',
    'Auto-expire recordings'                                                                                                             => 'Enregistrements auto-exiprant',
    'Auto-flag commercials'                                                                                                              => 'Marquer les pubs',
    'Auto-transcode'                                                                                                                     => '',
    'Back to the program listing'                                                                                                        => 'Retourner &agrave; la liste des &eacute;missions',
    'Back to the recording schedules'                                                                                                    => 'Retourner aux programmations programm&eacute;es',
    'Backend Status'                                                                                                                     => 'Statut du Backend',
    'Cancel this schedule.'                                                                                                              => 'Annuler cette programmation',
    'Cast'                                                                                                                               => 'Acteurs',
    'Category'                                                                                                                           => 'cat&eacute;gorie',
    'Category Legend'                                                                                                                    => 'L&eacute;g&eacute;nde de Cat&eacute;gorie',
    'Category Type'                                                                                                                      => 'Type de cat&eacute;gorie',
    'Channel'                                                                                                                            => 'Cha&icirc;ne',
    'Channel &quot;Jump to&quot;'                                                                                                        => 'Cha&icirc;ne &quot;Aller &agrave;&quot;',
    'Channels'                                                                                                                           => 'Cha&icirc;nes',
    'Check for duplicates in'                                                                                                            => 'Cherche les doublons dans',
    'Commands'                                                                                                                           => 'Commandes',
    'Configure'                                                                                                                          => 'Configuration',
    'Conflicts'                                                                                                                          => 'entre en conflit',
    'Create Schedule'                                                                                                                    => 'Creer une programmation',
    'Current Conditions'                                                                                                                 => 'Conditions courantes',
    'Current recordings'                                                                                                                 => 'Enregistrements courant',
    'Currently Browsing:  $1'                                                                                                            => 'Actuellement Affich&eacute;',
    'Date'                                                                                                                               => 'Date',
    'Date Formats'                                                                                                                       => 'Formats de date',
    'Deactivated'                                                                                                                        => 'D&eacute;sactiver',
    'Default'                                                                                                                            => 'Par d&eacute;faut',
    'Delete'                                                                                                                             => 'Effacer',
    'Delete + Rerecord'                                                                                                                  => '',
    'Description'                                                                                                                        => 'Description',
    'Directed by'                                                                                                                        => 'Mis en scène par',
    'Display'                                                                                                                            => 'Afficher',
    'Don\'t Record'                                                                                                                      => 'Ne pas enregistrer',
    'Don\'t record this program.'                                                                                                        => 'Ne pas enregistrer cette &eacute;mission',
    'Dup Method'                                                                                                                         => 'm&eacute;thode de dup',
    'Duplicate Check method'                                                                                                             => 'M&eacute;thode de test des doublons',
    'Duplicates'                                                                                                                         => 'Doublonner',
    'Edit MythWeb and some MythTV settings.'                                                                                             => 'Editer les param&egrave;tres de Mythweb et certains de MythTV',
    'Edit keybindings on'                                                                                                                => 'Editer les touches sur',
    'End Late'                                                                                                                           => 'Fin tardive',
    'Episode'                                                                                                                            => 'Episode',
    'Exact Match'                                                                                                                        => 'Correspondance exacte',
    'Exec. Producer'                                                                                                                     => 'Producteur',
    'Find other showings of this program'                                                                                                => 'Trouver d&acute;autres diffusions de cette &eacute;mission',
    'Find showings of this program'                                                                                                      => 'Trouver les diffusions de cette émission',
    'Forecast'                                                                                                                           => 'Pr&eacute;visions',
    'Forget Old'                                                                                                                         => 'oublier les anciens',
    'Friday'                                                                                                                             => 'Vendredi',
    'Go'                                                                                                                                 => 'Go',
    'Google'                                                                                                                             => 'Google',
    'Guest Starring'                                                                                                                     => 'Invité d\'honneur',
    'Guide Settings'                                                                                                                     => 'Paramètres du Guide',
    'HD Only'                                                                                                                            => 'TVHD seul',
    'High'                                                                                                                               => '&eacute;lev&eacute;',
    'Hosted by'                                                                                                                          => 'Hébergé par',
    'Hour'                                                                                                                               => 'Heure',
    'Hour Format'                                                                                                                        => 'Format d&acute;heures',
    'Humidity'                                                                                                                           => 'Humidit&eacute;',
    'IMDB'                                                                                                                               => 'Allocin&eacute;',
    'Inactive'                                                                                                                           => 'Inactif',
    'Jump'                                                                                                                               => 'Aller',
    'Jump To'                                                                                                                            => 'Aller &agrave;',
    'Jump to'                                                                                                                            => 'Sauter vers',
    'Key Bindings'                                                                                                                       => 'Touches',
    'Language'                                                                                                                           => 'Langue',
    'Last Updated'                                                                                                                       => 'Derni&egrave;re mise &agrave; jour',
    'Length'                                                                                                                             => 'Dur&eacute;e',
    'Length (min)'                                                                                                                       => 'Dur&eacute;e (min)',
    'Listing &quot;Jump to&quot;'                                                                                                        => 'Lister &quot;Aller &agrave;&quot;',
    'Listing Time Key'                                                                                                                   => 'Lister Touches de temps',
    'Listings'                                                                                                                           => 'Liste',
    'Low'                                                                                                                                => 'faible',
    'Manually Schedule'                                                                                                                  => 'Programmation Manuelle',
    'Monday'                                                                                                                             => 'Lundi',
    'MythMusic on the web.'                                                                                                              => 'MythMusic sur le Web',
    'MythVideo on the web.'                                                                                                              => 'Mythvideo sur le Web',
    'MythWeb Settings'                                                                                                                   => 'Param&egrave;tres de MythWeb',
    'MythWeb Theme'                                                                                                                      => 'Th&egrave;me de Mythweb',
    'MythWeb Weather.'                                                                                                                   => 'M&eacute;t&eacute;o sur le web',
    'Never Record'                                                                                                                       => 'Ne jamais enregistrer',
    'No'                                                                                                                                 => 'Non',
    'No matches found'                                                                                                                   => 'Aucune correspondance',
    'No recording schedules have been defined.'                                                                                          => 'Aucune programmation n\'est définie',
    'No. of recordings to keep'                                                                                                          => 'Nombre d&acute;enregistrements &agrave; garder',
    'None'                                                                                                                               => 'Aucun',
    'Notes'                                                                                                                              => 'Notes',
    'Only New Episodes'                                                                                                                  => 'Seulement les nouveaux &eacute;pisodes',
    'Only display favourite channels'                                                                                                    => 'Afficher seulement vos chaînes favorites',
    'Original Airdate'                                                                                                                   => 'Heure de diffusion d&acute;origine',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Nous vous pr&eacute;venons que modifier les touches sans savoir ce que vous fa&icirc;tes peut s&eacute;rieusement endomager le fonctionnement de MythTV',
    'Please search for something.'                                                                                                       => 'Veuillez chercher quelque chose',
    'Presented by'                                                                                                                       => 'Présenté par',
    'Pressure'                                                                                                                           => 'Pression',
    'Previous recordings'                                                                                                                => 'Enregistrements pr&eacute;c&eacute;dents',
    'Produced by'                                                                                                                        => 'Produit par',
    'Profile'                                                                                                                            => 'Profil',
    'Profile Groups'                                                                                                                     => 'Groupes de profil',
    'Radar'                                                                                                                              => 'Radar',
    'Rating'                                                                                                                             => '&eacute;valuation',
    'Record This'                                                                                                                        => 'Enregistrer Ceci',
    'Record new and expire old'                                                                                                          => 'Enregistrer un nouveau et expirer l&acute;ancien',
    'Recorded Programs'                                                                                                                  => 'Programmes enregistr&eacute;s',
    'Recording Group'                                                                                                                    => 'Groupe d&acute;enregistrement',
    'Recording Options'                                                                                                                  => 'Options d&acute;enregistrement',
    'Recording Priority'                                                                                                                 => 'Priorit&eacute; d&acute;enregistrement',
    'Recording Profile'                                                                                                                  => 'Profile d&acute;enregistrement',
    'Recording Schedules'                                                                                                                => 'Programmation des enregistrements',
    'Recording profiles'                                                                                                                 => 'Profils d&acute;enregistrement',
    'Rerun'                                                                                                                              => 'Relancer',
    'Reset'                                                                                                                              => 'Reset',
    'SI Units?'                                                                                                                          => 'Unités métriques?',
    'Saturday'                                                                                                                           => 'Samedi',
    'Save'                                                                                                                               => 'Sauver',
    'Save Schedule'                                                                                                                      => 'Sauver une programmation',
    'Schedule'                                                                                                                           => 'Programmer',
    'Schedule Options'                                                                                                                   => 'Prog. Avancée',
    'Schedule Override'                                                                                                                  => 'Ecraser Prog.',
    'Schedule normally.'                                                                                                                 => 'Prog. normale',
    'Scheduled'                                                                                                                          => 'Programm&eacute;',
    'Scheduled Popup'                                                                                                                    => 'Boite de programmation',
    'Scheduled Recordings'                                                                                                               => 'Enregistrements programm&eacute;s',
    'Search'                                                                                                                             => 'Recherche',
    'Search Results'                                                                                                                     => 'R&eacute;sultats de recherche',
    'Search fields'                                                                                                                      => 'Champs de recherche',
    'Search for:  $1'                                                                                                                    => 'Chercher:    $1',
    'Search help'                                                                                                                        => 'Aide de la recherche',
    'Search help: movie example'                                                                                                         => '*** 1/2 Adventure',
    'Search help: movie search'                                                                                                          => 'movie search',
    'Search help: regex example'                                                                                                         => '/^Good Eats/',
    'Search help: regex search'                                                                                                          => 'regex search',
    'Search options'                                                                                                                     => 'Options de recherche',
    'Searches'                                                                                                                           => 'Recherches',
    'Settings'                                                                                                                           => 'param&egrave;tres',
    'Show'                                                                                                                               => 'Diffusion',
    'Show descriptions on new line'                                                                                                      => 'Afficher la description sur une nouvelle ligne',
    'Show group'                                                                                                                         => 'Monter les groupes',
    'Show recordings'                                                                                                                    => 'Monter les enregistrements',
    'Start Date'                                                                                                                         => 'Date de d&eacute;but',
    'Start Early'                                                                                                                        => 'D&eacute;marrer plus tot',
    'Start Time'                                                                                                                         => 'Heure de d&eacute;but',
    'Status Bar'                                                                                                                         => 'Barre de statut',
    'Sub and Desc (Empty matches)'                                                                                                       => 'Sub et Desc (Vide correspond)',
    'Subtitle'                                                                                                                           => 'Soustitre',
    'Subtitle and Description'                                                                                                           => 'Soustitre et description',
    'Sunday'                                                                                                                             => 'Dimanche',
    'TV functions, including recorded programs.'                                                                                         => 'Fonctions TV, inclant les enregistrements d&acute;&eacute;missions',
    'TVTome'                                                                                                                             => 'TVTome',
    'The requested recording schedule has been deleted.'                                                                                 => 'L\'enregistrement demandé a été effacé',
    'Thursday'                                                                                                                           => 'Jeudi',
    'Time'                                                                                                                               => 'Heure',
    'Title'                                                                                                                              => 'Titre',
    'Today'                                                                                                                              => 'Aujourd&acute;hui',
    'Tomorrow'                                                                                                                           => 'Demain',
    'Transcoder'                                                                                                                         => '',
    'Tuesday'                                                                                                                            => 'Mardi',
    'Type'                                                                                                                               => 'Type',
    'UV Extreme'                                                                                                                         => 'Indice UV Extr&egrave;me',
    'UV High'                                                                                                                            => 'Indice UV &eacute;lev&eacute;',
    'UV Index'                                                                                                                           => 'Index UV',
    'UV Minimal'                                                                                                                         => 'Indice UV minimal',
    'UV Moderate'                                                                                                                        => 'Indice UV mod&eacute;r&eacute;',
    'Unknown'                                                                                                                            => 'Inconnu',
    'Unknown Program.'                                                                                                                   => 'Programme inconnu',
    'Unknown Recording Schedule.'                                                                                                        => 'Programmation inconnue',
    'Update'                                                                                                                             => 'Rafraîchir',
    'Update Recording Settings'                                                                                                          => 'Actualiser les param&egrave;tres d&acute;enregistrement',
    'Visibility'                                                                                                                         => 'Visibilit&eacute;',
    'Weather Icons'                                                                                                                      => 'Icones météos',
    'Wednesday'                                                                                                                          => 'Mercredi',
    'What else is on at this time?'                                                                                                      => 'Quoi d&acute;autre &agrave; cette heure',
    'Wind'                                                                                                                               => 'Vent',
    'Wind Chill'                                                                                                                         => 'Vent Frais',
    'Written by'                                                                                                                         => 'Ecrit par',
    'Yes'                                                                                                                                => 'Oui',
    'airdate'                                                                                                                            => 'Date de diffusion',
    'auto-expire'                                                                                                                        => 'auto-expire',
    'channel'                                                                                                                            => 'Chaîne',
    'channum'                                                                                                                            => 'Chaine',
    'description'                                                                                                                        => 'Description',
    'file size'                                                                                                                          => 'taille de fichier',
    'format help'                                                                                                                        => 'Format d&acute;aide',
    'generic_date'                                                                                                                       => '%e %b, %Y',
    'generic_time'                                                                                                                       => '%I:%M %p',
    'handy: overview'                                                                                                                    => 'Cette page contient des recherches préparées dans le programme TV',
    'has bookmark'                                                                                                                       => 'a des signets',
    'has commflag'                                                                                                                       => 'a des marques de pub',
    'has cutlist'                                                                                                                        => 'a une liste de coupe',
    'is editing'                                                                                                                         => 'est &eacute;dit&eacute;',
    'length'                                                                                                                             => 'Dur&eacute;e',
    'minutes'                                                                                                                            => 'minutes',
    'preview'                                                                                                                            => 'Aper&ccedil;u',
    'profile'                                                                                                                            => 'Profil',
    'recgroup'                                                                                                                           => 'Groupe d&eacute;enr',
    'recstatus: cancelled'                                                                                                               => 'Enregistrement pr&eacute;vu mais annul&eacute;',
    'recstatus: conflict'                                                                                                                => 'Un autre programme plus prioritaire sera enregistr&eacute;',
    'recstatus: currentrecording'                                                                                                        => 'Cet &eacute;pisode &agrave; d&eacute;ja &eacute;t&eacute; enregistr&eacute; et est encore disponible pour relecture',
    'recstatus: deleted'                                                                                                                 => 'Cette &eacute;mission a &eacute;t&eacute; enregistr&eacute;e et annul&eacute; avant la fin d&acute;enregistrement',
    'recstatus: earliershowing'                                                                                                          => 'Cette &eacute;mission sera enregistr&eacute; plus tot &agrave; la place',
    'recstatus: force_record'                                                                                                            => 'Cette diffusion a &eacute;t&eacute; manuellement enregistr&eacute;e &agrave; cette heure',
    'recstatus: latershowing'                                                                                                            => 'Cette &eacute;mission sera enregistr&eacute; plus tard &agrave; la place',
    'recstatus: lowdiskspace'                                                                                                            => 'Il n&acute;y a pas assez de place sur le disque pour l&acute;enregistrement',
    'recstatus: manualoverride'                                                                                                          => 'D&eacute;j&agrave; forc&eacute; &agrave; la main &agrave; pas d&acute;enregistrement',
    'recstatus: overlap'                                                                                                                 => 'Cette &eacute;mission est d&eacute;j&agrave; couverte pas un autre enregistrement du meme programme',
    'recstatus: previousrecording'                                                                                                       => 'Cette &eacute;mission a d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute;e en raison de la gestion des doublons pour ce programme',
    'recstatus: recorded'                                                                                                                => 'Cette &eacute;mission est enregistr&eacute;e',
    'recstatus: recording'                                                                                                               => 'Cette &eacute;mission est en cours d&acute;enregistrement',
    'recstatus: repeat'                                                                                                                  => 'Cette rediffusion ne sera pas enregistr&eacute;e',
    'recstatus: stopped'                                                                                                                 => 'Cette &eacute;mission a &eacute;t&eacute; enregistr&eacute;e et Arret&eacute;e avant la fin d&acute;enregistrement',
    'recstatus: toomanyrecordings'                                                                                                       => 'trop d&acute;enregistrement de ce programmme ont &eacute;t&eacute; effectu&eacute;es',
    'recstatus: tunerbusy'                                                                                                               => 'La carte tuner &eacute;tait utilis&eacute;e pendant la programmation de l&acute;enregistrement',
    'recstatus: unknown'                                                                                                                 => 'Le statut de cette&eacute;mission est inconnu',
    'recstatus: willrecord'                                                                                                              => 'Cet &eacute;mission sera enregistr&eacute;e.',
    'rectype-long: always'                                                                                                               => 'Enregistrer tout le temps quelque soit la chaine.',
    'rectype-long: channel'                                                                                                              => 'Enregistrer tout le temps sur la chaine $1.',
    'rectype-long: daily'                                                                                                                => 'Enregistrer ce programme &agrave; cette heure chaque jour.',
    'rectype-long: dontrec'                                                                                                              => 'ne pas enregistrer cette diffusion',
    'rectype-long: finddaily'                                                                                                            => 'Trouver un enregistrement avec ce titre aujourd&acute;hui et l&acute;enregistrer',
    'rectype-long: findone'                                                                                                              => 'Trouver un enregistrement avec ce titre et l&acute;enregistrer',
    'rectype-long: findweekly'                                                                                                           => 'Trouver un enregistrement avec ce titre cette semaine et l&acute;enregistrer',
    'rectype-long: once'                                                                                                                 => 'Enregistrer seulement cette diffusion',
    'rectype-long: override'                                                                                                             => 'Enregistrer cette diffusion',
    'rectype-long: weekly'                                                                                                               => 'Enregistrer ce programme &agrave; cette heure chaque semaine',
    'rectype: always'                                                                                                                    => 'Toujours',
    'rectype: channel'                                                                                                                   => 'Chaine',
    'rectype: daily'                                                                                                                     => 'Quotidien',
    'rectype: dontrec'                                                                                                                   => 'Ne pas Rec',
    'rectype: finddaily'                                                                                                                 => 'Trouver aujourd\'hui',
    'rectype: findone'                                                                                                                   => 'Trouver Un',
    'rectype: findweekly'                                                                                                                => 'trouver cette semaine',
    'rectype: once'                                                                                                                      => 'Unique',
    'rectype: override'                                                                                                                  => 'R&eacute;&eacute;crire',
    'rectype: weekly'                                                                                                                    => 'hebdomadaire',
    'settings: overview'                                                                                                                 => 'ceci est la page d&acute;index pour les param&eacute;tres de configuration...<p>C&acute;est incomplet et pourrait &ecirc;tre mieux format&eacute;.  Pour le moment vous pouvez choisir parmis:',
    'subtitle'                                                                                                                           => 'Sous titre',
    'title'                                                                                                                              => 'Titre',
    'type'                                                                                                                               => 'Type',
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

?>
