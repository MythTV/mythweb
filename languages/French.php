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
    'Category'         => '',
    'Description'      => '',
    'Original Airdate' => '',
    'Rerun'            => '',
    'Search'           => '',
    'Subtitle'         => '',
// includes/init.php
    'generic_date' => '%e %b, %Y',
    'generic_time' => '%I:%M %p',
// includes/utils.php
    '$1 B'    => '',
    '$1 GB'   => '',
    '$1 KB'   => '',
    '$1 MB'   => '',
    '$1 TB'   => '',
    '$1 hr'   => '',
    '$1 hrs'  => '',
    '$1 min'  => '',
    '$1 mins' => '',
// themes/.../channel_detail.php
    'Episode' => '',
    'Length'  => '',
    'Show'    => '',
    'Time'    => '',
// themes/.../program_detail.php
    'Auto-expire recordings'     => '',
    'Cancel this schedule'       => '',
    'Check for duplicates in'    => '',
    'Current Recordings'         => '',
    'Don\'t record this program' => '',
    'Duplicate Check method'     => '',
    'End Late'                   => '',
    'Google'                     => '',
    'IMDB'                       => '',
    'No. of recordings to keep'  => '',
    'None'                       => '',
    'Previous Recordings'        => '',
    'Record new and expire old'  => '',
    'Recording Group'            => '',
    'Recording Options'          => '',
    'Recording Priority'         => '',
    'Recording Profile'          => '',
    'Start Early'                => '',
    'Subtitle and Description'   => '',
    'TVTome'                     => '',
    'Update Recording Settings'  => '',
// themes/.../program_listing.php
    'Airtime'                 => '',
    'Currently Browsing:  $1' => '',
    'Date'                    => '',
    'Hour'                    => '',
    'Jump'                    => '',
    'Jump To'                 => '',
    'Notes'                   => '',
    'Rating'                  => '',
    'Schedule'                => '',
    'Title'                   => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '',
    '$1 episodes'                                         => '',
    '$1 programs, using $2 ($3) out of $4.'               => '',
    '$1 recording'                                        => '',
    '$1 recordings'                                       => '',
    'All recordings'                                      => '',
    'Are you sure you want to delete the following show?' => '',
    'Delete'                                              => '',
    'Go'                                                  => '',
    'No'                                                  => '',
    'Show group'                                          => '',
    'Show recordings'                                     => '',
    'Yes'                                                 => '',
    'preview'                                             => '',
// themes/.../theme.php
    'Backend Status'       => '',
    'Category Legend'      => '',
    'Favorites'            => '',
    'Go To'                => '',
    'Listings'             => '',
    'Manually Schedule'    => '',
    'Movies'               => '',
    'Recorded Programs'    => '',
    'Recording Schedules'  => '',
    'Scheduled Recordings' => '',
    'Settings'             => '',
    'advanced'             => ''
// End of the translation hash ** Do not touch the next line
          );


/* theme.php */
define ('_LANG_BACKEND_STATUS',       'Etat du syst&egrave;me');
define ('_LANG_SETTINGS',             'Configuration');
define ('_LANG_LISTINGS',             'Guide TV');
define ('_LANG_FAVOURITES',           'Favoris');
define ('_LANG_SCHEDULED_RECORDINGS', 'Enregistrements Programm&eacute;s');
define ('_LANG_RECORDING_SCHEDULES',  'Programmation des Enregistrements');
define ('_LANG_RECORDED_PROGRAMS',    'Programmes Enregistr&eacute;s');
define ('_LANG_CATEGORY_LEGEND',      'L&eacute;gende des Cat&eacute;gories');
define ('_LANG_ACTION',               '');
define ('_LANG_ADULT',                'Adulte');
define ('_LANG_ANIMALS',              '');
define ('_LANG_ART_MUSIC',            'Musique');
define ('_LANG_BUSINESS',             'Divertissement');
define ('_LANG_CHILDREN',             'Jeunesse');
define ('_LANG_COMEDY',               'Spectacle');
define ('_LANG_CRIME_MYSTERY',        'Surprise');
define ('_LANG_DOCUMENTARY',          'Documentaire');
define ('_LANG_DRAMA',                'Court-m&eacute;trage');
define ('_LANG_EDUCATIONAL',          'Educatif');
define ('_LANG_FOOD',                 'Cuisine');
define ('_LANG_GAME',                 'Jeu');
define ('_LANG_HEALTH_MEDICAL',       'Sant&eacute;');
define ('_LANG_HISTORY',              'Magazine');
define ('_LANG_HOWTO',                'Th&eacute;matique');
define ('_LANG_HORROR',               '');
define ('_LANG_MISC',                 'Divers');
define ('_LANG_NEWS',                 'Information');
define ('_LANG_REALITY',              'T&eacute;l&eacute;-r&eacute;alit&eacute;');
define ('_LANG_ROMANCE',              'T&eacute;l&eacute;film');
define ('_LANG_SCIENCE_NATURE',       'Nature');
define ('_LANG_SCIFI_FANTASY',        'Fantastique');
define ('_LANG_SHOPPING',             'T&eacute;l&eacute;-Shopping');
define ('_LANG_SOAPS',                'S&eacute;rie');
define ('_LANG_SPIRITUAL',            'Spirituel');
define ('_LANG_SPORTS',               'Sport');
define ('_LANG_TALK',                 'D&eacute;bat');
define ('_LANG_TRAVEL',               'Voyage');
define ('_LANG_WAR',                  '');
define ('_LANG_WESTERN',              '');
define ('_LANG_MOVIES',               'Film');
define ('_LANG_UNKNOWN',              'Inconnu');

define ('_CATMATCH_ACTION',               '\\b(?:action|adven)');
define ('_CATMATCH_ADULT',                '\\b(?:adult|erot|sex)');
define ('_CATMATCH_ANIMALS',              '\\b(?:animal|tiere)');
define ('_CATMATCH_ART_MUSIC',            '\\b(?:art|dance|musi[ck]|spectacle|musique|kunst|[ck]ultur|culture)');
define ('_CATMATCH_BUSINESS',             '\\b(?:divertissement)');
define ('_CATMATCH_CHILDREN',             '\\b(?:child|kin?d|infan|jeunesse|animation)');
define ('_CATMATCH_COMEDY',               '\\b(?:comed|entertain|spectacle|sitcom)');
define ('_CATMATCH_CRIME_MYSTERY',        '\\b(?:[ck]rim|myster|surprise)');
define ('_CATMATCH_DOCUMENTARY',          '\\b(?:do[ck])|mag');
define ('_CATMATCH_DRAMA',                '\\b(?:court)');
define ('_CATMATCH_EDUCATIONAL',          '\\b(?:cours|edu|bildung|interests)');
define ('_CATMATCH_FOOD',                 '\\b(?:food|cook|essen|gastro|cuisine|[dt]rink)');
define ('_CATMATCH_GAME',                 '\\b(?:game|spiele|jeu)');
define ('_CATMATCH_HEALTH_MEDICAL',       '\\b(?:health|medic|gesundheit|sant)');
define ('_CATMATCH_HISTORY',              '\\b(?:hist|geschichte)');
define ('_CATMATCH_HOWTO',                '\\b(?:th.*matique)');
define ('_CATMATCH_HORROR',               '\\b(?:horreur)');
define ('_CATMATCH_MISC',                 '\\b(?:special|variety|collect)');
define ('_CATMATCH_NEWS',                 '\\b(?:news|nachrichten|info|current)');
define ('_CATMATCH_REALITY',              '\\b(?:reality|realit.*)');
define ('_CATMATCH_ROMANCE',              '\\b(?:t.*l.*film|romance|lieb)');
define ('_CATMATCH_SCIENCE_NATURE',       '\\b(?:science|nature|environment|wissenschaft)');
define ('_CATMATCH_SCIFI_FANTASY',        '\\b(?:fantasy|fantastique|sci\\w*\\W*fi)');
define ('_CATMATCH_SHOPPING',             '\\b(?:shop)');
define ('_CATMATCH_SOAPS',                '\\b(?:s.*rie|soap|t.*l.*film|feuilleton)');
define ('_CATMATCH_SPIRITUAL',            '\\b(?:spirit|relig)');
define ('_CATMATCH_SPORTS',               '\\b(?:sport|foot|deportes|futbol)');
define ('_CATMATCH_TALK',                 '\\b(?:talk|D.*bat)');
define ('_CATMATCH_TRAVEL',               '\\b(?:travel|reisen|voyage)');
define ('_CATMATCH_WAR',                  '\\b(?:war|krieg|guerre)');
define ('_CATMATCH_WESTERN',              '\\b(?:west)');
define ('_CATMATCH_MOVIES',               '');

/* settings.php */
define ('_LANG_SETTINGS_HEADER1',              'Voici la page de configuration...');
define ('_LANG_SETTINGS_HEADER2',              'Il devrait y avoir de belles images pour chaque section, mais pour l\'instant, voici le choix :');
define ('_LANG_CHANNELS',                      'Cha&icirc;nes');
define ('_LANG_THEME',                         'Th&egrave;eme');
define ('_LANG_LANGUAGE',                      'Langue');
define ('_LANG_DATEFORMATS',                   'Formats des Dates');
define ('_LANG_KEY_BINDINGS',                  'Configuration des Touches');
define ('_LANG_CONFIGURE',                     'Configuration');
define ('_LANG_GO_TO',                         'Menu');
define ('_LANG_ADVANCED',                      'Avanc&eacute;e');
define ('_LANG_FORMAT_HELP',                   'Aide sur les formats');
define ('_LANG_STATUS_BAR',                    'Barre de Statut');
define ('_LANG_SCHEDULED_RECORDINGS',          'Enregistrement Programm&eacute;s');
define ('_LANG_SCHEDULED_POPUP',               'Popup Programm&eacute;');
define ('_LANG_RECORDED_PROGRAMS',             'Programmes Enregistr&eacute;s');
define ('_LANG_SEARCH_RESULTS',                'R&eacute;sultats de la recherche');
define ('_LANG_LISTING_TIME_KEY',              'Date du Guide TV');
define ('_LANG_LISTING_JUMP_TO',               'Date du changement d\'horaire');
define ('_LANG_CHANNEL_JUMP_TO',               'Cha&icric;ne du changement d\'horaire');
define ('_LANG_HOUR_FORMAT',                   'Format de l\'heure');
define ('_LANG_RESET',                         'R&eacute;initialiser');
define ('_LANG_SAVE',                          'Enregistrer');
define ('_LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE', 'Afficher les descriptions sur une nouvelle ligne');

/* program_listings.php */
define ('_LANG_CURRENTLY_BROWSING', 'Programmation du ');
define ('_LANG_JUMP_TO',            'Horaire');
define ('_LANG_HOUR',               'Heure');
define ('_LANG_DATE',               'Date');
define ('_LANG_JUMP',               'Valider');

/* program_detail.php */
define ('_LANG_SEARCH',                             'Recherche');
define ('_LANG_IMDB',                               'IMDB');
define ('_LANG_GOOGLE',                             'Google');
define ('_LANG_TVTOME',                             'TV Tome');
define ('_LANG_MINUTES',                            'minutes');
define ('_LANG_TO',                                 '-');
define ('_LANG_CATEGORY',                           'Cat&eacute;gorie');
define ('_LANG_ORIG_AIRDATE',                       'Premi&egrave;re Diffusion');
define ('_LANG_AIRDATE',                            'Diffusion');
define ('_LANG_RECORDING_OPTIONS',                  'Options d\'enregistrement');
define ('_LANG_DONT_RECORD_THIS_PROGRAM',           'Ne pas enregistrer ce programme');
define ('_LANG_CANCEL_THIS_SCHEDULE',               'Annuler cette programmation');
define ('_LANG_RECORDING_PROFILE',                  'Profil d\'enregistrement');
define ('_LANG_RECPRIORITY',                        'Priorit&eacute; d\'enregistrement');
define ('_LANG_CHECK_FOR_DUPLICATES_IN',            'V&eacute;rification des doublons avec');
define ('_LANG_CURRENT_RECORDINGS',                 'Les enregistrements courants');
define ('_LANG_PREVIOUS_RECORDINGS',                'Les enreegistrement pr&eacute;c&eacute;dents');
define ('_LANG_ALL_RECORDINGS',                     'Tous les enregistrements');
define ('_LANG_DUPLICATE_CHECK_METHOD',             'M&eacute;thode des v&eacute;rifications des doublons');
define ('_LANG_NONE',                               'Aucun');
define ('_LANG_SUBTITLE',                           'Sous-titres');
define ('_LANG_DESCRIPTION',                        'Description');
define ('_LANG_SUBTITLE_AND_DESCRIPTION',           'Sous-titres et  Description');
define ('_LANG_SUB_AND_DESC',                       'S-T & Desc. (Pas de correspondance)');
define ('_LANG_AUTO_EXPIRE_RECORDINGS',             'Expiration auto des enregistrements ?');
define ('_LANG_NO_OF_RECORDINGS_TO_KEEP',           'Nb d\'enregistrements &agrave; conserver:');
define ('_LANG_RECORD_NEW_AND_EXPIRE_OLD',          'Enregistrer le nouveau et expirer l\'ancien ?');
define ('_LANG_START_EARLY',                        'D&eacute;marrage anticip&eacute; (minutes)');
define ('_LANG_END_LATE',                           'Fin retard&eacute;e (minutes)');
define ('_LANG_UPDATE_RECORDING_SETTINGS',          'Mettre &agrave; jour les options d\'enregistrement');
define ('_LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME',       'Quels sont les autres programmes diffus&eacute;s &agrave; cette heure ?');
define ('_LANG_BACK_TO_THE_PROGRAM_LISTING',        'Retour au guide TV!');
define ('_LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM', 'Chercher les autres diffusions de ce programme');
define ('_LANG_BACK_TO_RECORDING_SCHEDULES',        'Retour &agrave; la programmations des enregistrements');

/* scheduled_recordings.php */
/* recording_schedules_php */
/* search.php */
define ('_LANG_NO_MATCHES_FOUND', 'Aucun r&eacute;sultat');
define ('_LANG_SEARCH',           'Rechercher');
define ('_LANG_TITLE',            'Programme');
define ('_LANG_SUBTITLE',         'Episode');
define ('_LANG_CATEGORY_TYPE',    'Type de Cat&eacute;gorie');
define ('_LANG_EXACT_MATCH',      'Exact');
define ('_LANG_CHANNUM',          'Cha&icirc;ne');
define ('_LANG_LENGTH',           'Dur&eacute;e');
define ('_LANG_COMMANDS',         'Action');
define ('_LANG_DONT_RECORD',      'Ne pas enregistrer');
define ('_LANG_ACTIVATE',         'Activer');
define ('_LANG_NEVER_RECORD',     'Ne jamais enregistrer');
define ('_LANG_RECORD_THIS',      'Enregistrer ce programme');
define ('_LANG_FORGET_OLD',       'Oublier l\'ancien');
define ('_LANG_DEFAULT',          'Default');
define ('_LANG_RATING',           'Appr&eacute;ciation');
define ('_LANG_SCHEDULE',         'Programmation');
define ('_LANG_DISPLAY',          'Afficher');
define ('_LANG_SCHEDULED',        'ProgrammÃ&eacute;');
define ('_LANG_DUPLICATES',       'Doublons');
define ('_LANG_DEACTIVATED',      'D&eacute;sactiv&eacute;');
define ('_LANG_CONFLICTS',        'Conflits');
define ('_LANG_TYPE',             'Type');
define ('_LANG_AIRTIME',          'Diffusion');
define ('_LANG_RERUN',            'Rediffusion');
define ('_LANG_SCHEDULE',         'Programmation');
define ('_LANG_PROFILE',          'Profil');
define ('_LANG_NOTES',            'Notes');
define ('_LANG_DUP_METHOD',       'M&eacute;thode de duplication');

/* recorded_programs.php */
define ('_LANG_SHOW_RECORDINGS', 'Afficher');
define ('_LANG_CONFIRM_DELETE',  'Confirmez-vous la suppression de l\'enregistrement ?');
define ('_LANG_ALL_RECORDINGS',  'Tous les enregistrements');
define ('_LANG_GO',              'Valider');
define ('_LANG_PREVIEW',         'Pr&eacute;visualisation');
define ('_LANG_FILE_SIZE',       'Taille du fichier');
define ('_LANG_DELETE',          'Supprimer');
define ('_LANG_PROGRAMS_USING',  'enregistrement(s) occupant ');
define ('_LANG_OUT_OF',          ' sur ');
define ('_LANG_EPISODES',        '&eacute;pisodes');
define ('_LANG_SHOW_HAS_COMMFLAG',   'flagged commercials');
define ('_LANG_SHOW_HAS_CUTLIST',    'has cutlist');
define ('_LANG_SHOW_IS_EDITING',     'being edited');
define ('_LANG_SHOW_AUTO_EXPIRE',    'auto expire');
define ('_LANG_SHOW_HAS_BOOKMARK',   'has bookmark');
define ('_LANG_YES',                 'Yes');
define ('_LANG_NO',                  'No');

/* recordings.php */
define ('_LANG_RECTYPE_ONCE',    'Unique');
define ('_LANG_RECTYPE_DAILY',   'Quotidienne');
define ('_LANG_RECTYPE_CHANNEL', 'Cha&icirc;ne');
define ('_LANG_RECTYPE_ALWAYS',  'Permanente');
define ('_LANG_RECTYPE_WEEKLY',  'Hebdomadaire');
define ('_LANG_RECTYPE_FINDONE', 'Prochain');
define ('_LANG_RECTYPE_OVERRIDE', '[translate me] Override (record)');
define ('_LANG_RECTYPE_DONTREC', '[translate me] Do Not Record');

define ('_LANG_RECTYPE_LONG_ONCE',          'Enregistrer uniquement ce programme');
define ('_LANG_RECTYPE_LONG_DAILY',         'Enregistrer ce programme &agrave; cet horaire chaque jour');
define ('_LANG_RECTYPE_LONG_CHANNEL',       'Enregistrer toujours ce programme sur cette cha&icirc;ne');
define ('_LANG_RECTYPE_LONG_ALWAYS',        'Enregistrer toujours ce programme sur n\'importe quelle cha&icirc;ne');
define ('_LANG_RECTYPE_LONG_WEEKLY',        'Enregistrer ce programme &agrave; cet horaire chaque semaine');
define ('_LANG_RECTYPE_LONG_FINDONE',       'Enregistrer une diffusion de ce programme &agrave; n\'importe quel horaire');

define ('_LANG_RECSTATUS_LONG_DELETED',           'Cette diffusion a &eacute;t&eacute; enregistr&eacute;e mais a &eacute;t&eacute; supprim&eacute;e');
define ('_LANG_RECSTATUS_LONG_STOPPED',           'Cette diffusion a &eacute;t&eacute; enregistr&eacute;e mais a &eacute;t&eacute; interrompue avant sa fin');
define ('_LANG_RECSTATUS_LONG_RECORDED',          'Cette diffusion a &eacute;t&eacute; enregistr&eacute;e');
define ('_LANG_RECSTATUS_LONG_RECORDING',         'Cette diffusion est en cours d\'enregistrement');
define ('_LANG_RECSTATUS_LONG_WILLRECORD',        'Cette diffusion sera enregistr&eacute;e');
define ('_LANG_RECSTATUS_LONG_UNKNOWN',           'Le statut de cette diffusion est inconnu');
define ('_LANG_RECSTATUS_LONG_MANUALOVERRIDE',    'L\'enregistrement a &eacute;t&eacute; d&eacute;sactiv&eacute; manuellement');
define ('_LANG_RECSTATUS_LONG_PREVIOUSRECORDING', 'Cet &eacute;pisode a d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute; selon les r&egrave;gles de doublons choisies pour ce programme');
define ('_LANG_RECSTATUS_LONG_CURRENTRECORDING',  'Cet &eacute;pisode a d&eacute;j&agrave; &eacute;t&eacute; enregistr&eacute; et est toujours disponible dans la liste des enregistrements');
define ('_LANG_RECSTATUS_LONG_EARLIERSHOWING',    'Cet &eacute;pisode sera enregistr&eacute; plus t&ocirc;t');
define ('_LANG_RECSTATUS_LONG_LATERSHOWING',      'Cet &eacute;pisode sera enregistr&eacute; plus tard');
define ('_LANG_RECSTATUS_LONG_TOOMANYRECORDINGS', 'Trop d\'enregistrements de ce programme ont d&eacute;j&agrave; &eacute;t&eacute; effectu&eacute;s');
define ('_LANG_RECSTATUS_LONG_CANCELLED',         'Ce programme devait &ecirc;tre enregistr&eacute; mais a &eacute;t&eacute; annul&eacute; manuellement');
define ('_LANG_RECSTATUS_LONG_CONFLICT',          'Un autre programme plus prioritaire sera enregistr&eacute;');
define ('_LANG_RECSTATUS_LONG_OVERLAP',           'Cet enregistrement est couvert par un autre enregistrement du m&ecirc;me programme');
define ('_LANG_RECSTATUS_LONG_LOWDISKSPACE',      'Il n\'y avait pas assez d\'espace disque pour enregistrer ce programme');
define ('_LANG_RECSTATUS_LONG_TUNERBUSY',         'La carte TV &eacute;tait en cours d\'utilisation quand ce programme devait &ecirc;tre enregistr&eacute;');
define ('_LANG_RECSTATUS_LONG_FORCE_RECORD',      'This show was manually set to record this specific instance.');

/* weather.php */
define ('_LANG_HUMIDITY',           'Humidit&eacute;');
define ('_LANG_PRESSURE',           'Pression');
define ('_LANG_WIND',               'Vent');
define ('_LANG_VISIBILITY',         'Visibilit&eacute;');
define ('_LANG_WIND_CHILL',         'Facteur Eolien');
define ('_LANG_UV_INDEX',           'Index UV');
define ('_LANG_UV_MINIMAL',         'minimal');
define ('_LANG_UV_MODERATE',        'mod&eacute;r&eacute;');
define ('_LANG_UV_HIGH',            'haut');
define ('_LANG_UV_EXTREME',         'extreme');
define ('_LANG_CURRENT_CONDITIONS', 'Conditions Courantes');
define ('_LANG_FORECAST',           'Pr&eacute;vision');
define ('_LANG_LAST_UPDATED',       'Derni&egrave;re Mise a Jour');
define ('_LANG_HIGH',               'Haut');
define ('_LANG_LOW',                'Bas');
define ('_LANG_UNKNOWN',            'Inconnu');
define ('_LANG_RADAR',              'Radar');
define ('_LANG_AT',                 '&agrave;');

define ('_LANG_TODAY',              'Aujourd hui');
define ('_LANG_TOMORROW',           'Demain');
define ('_LANG_MONDAY',             'Lundi');
define ('_LANG_TUESDAY',            'Mardi');
define ('_LANG_WEDNESDAY',          'Mercredi');
define ('_LANG_THURSDAY',           'Jeudi');
define ('_LANG_FRIDAY',             'Vendredi');
define ('_LANG_SATURDAY',           'Samedi');
define ('_LANG_SUNDAY',             'Dimanche');

/* utils.php */
define ('_LANG_HR',              'hr');
define ('_LANG_HRS',             'hrs');
define ('_LANG_MINS',            'mins');

/*
define ('_LANG_', '');
define ('_LANG_', '');
define ('_LANG_', '');
*/

?>
