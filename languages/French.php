<?php

define ('_LANG_LANGUAGE_NAME', 'French');

/* Default date and time formats */
define('generic_date', '%e %b, %Y');
define('generic_time', '%I:%M %p');

/* Set locale to French */
setlocale(LC_ALL, 'fr_FR');

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

define ('_LANG_CATMATCH_ACTION',               '\\b(?:action|adven)');
define ('_LANG_CATMATCH_ADULT',                '\\b(?:adult|erot|sex)');
define ('_LANG_CATMATCH_ANIMALS',              '\\b(?:animal|tiere)');
define ('_LANG_CATMATCH_ART_MUSIC',            '\\b(?:art|dance|musi[ck]|spectacle|musique|kunst|[ck]ultur|culture)');
define ('_LANG_CATMATCH_BUSINESS',             '\\b(?:divertissement)');
define ('_LANG_CATMATCH_CHILDREN',             '\\b(?:child|kin?d|infan|jeunesse|animation)');
define ('_LANG_CATMATCH_COMEDY',               '\\b(?:comed|entertain|spectacle|sitcom)');
define ('_LANG_CATMATCH_CRIME_MYSTERY',        '\\b(?:[ck]rim|myster|surprise)');
define ('_LANG_CATMATCH_DOCUMENTARY',          '\\b(?:do[ck])|mag');
define ('_LANG_CATMATCH_DRAMA',                '\\b(?:court)');
define ('_LANG_CATMATCH_EDUCATIONAL',          '\\b(?:cours|edu|bildung|interests)');
define ('_LANG_CATMATCH_FOOD',                 '\\b(?:food|cook|essen|gastro|cuisine|[dt]rink)');
define ('_LANG_CATMATCH_GAME',                 '\\b(?:game|spiele|jeu)');
define ('_LANG_CATMATCH_HEALTH_MEDICAL',       '\\b(?:health|medic|gesundheit|sant)');
define ('_LANG_CATMATCH_HISTORY',              '\\b(?:hist|geschichte)');
define ('_LANG_CATMATCH_HOWTO',                '\\b(?:th.*matique)');
define ('_LANG_CATMATCH_HORROR',               '\\b(?:horreur)');
define ('_LANG_CATMATCH_MISC',                 '\\b(?:special|variety|collect)');
define ('_LANG_CATMATCH_NEWS',                 '\\b(?:news|nachrichten|info|current)');
define ('_LANG_CATMATCH_REALITY',              '\\b(?:reality|realit.*)');
define ('_LANG_CATMATCH_ROMANCE',              '\\b(?:t.*l.*film|romance|lieb)');
define ('_LANG_CATMATCH_SCIENCE_NATURE',       '\\b(?:science|nature|environment|wissenschaft)');
define ('_LANG_CATMATCH_SCIFI_FANTASY',        '\\b(?:fantasy|fantastique|sci\\w*\\W*fi)');
define ('_LANG_CATMATCH_SHOPPING',             '\\b(?:shop)');
define ('_LANG_CATMATCH_SOAPS',                '\\b(?:s.*rie|soap|t.*l.*film|feuilleton)');
define ('_LANG_CATMATCH_SPIRITUAL',            '\\b(?:spirit|relig)');
define ('_LANG_CATMATCH_SPORTS',               '\\b(?:sport|foot|deportes|futbol)');
define ('_LANG_CATMATCH_TALK',                 '\\b(?:talk|D.*bat)');
define ('_LANG_CATMATCH_TRAVEL',               '\\b(?:travel|reisen|voyage)');
define ('_LANG_CATMATCH_WAR',                  '\\b(?:war|krieg|guerre)');
define ('_LANG_CATMATCH_WESTERN',              '\\b(?:west)');
define ('_LANG_CATMATCH_MOVIES',               '');

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
