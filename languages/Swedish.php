<?php

define ('_LANG_LANGUAGE_NAME', 'Svenska');

/* Set the locale to UTF-8 */
setlocale(LC_ALL, 'sv_SE.UTF-8');

/* Default date and time formats */
define('generic_date', '%a %Y-%m-%d');
define('generic_time', '%H:%M');

/* theme.php */
define ('_LANG_BACKEND_STATUS',       'Systemstatus');
define ('_LANG_SETTINGS',             'Inställningar');
define ('_LANG_LISTINGS',             'TV-tablå');
define ('_LANG_FAVOURITES',           'Favoriter');
define ('_LANG_SCHEDULED_RECORDINGS', 'Kommande inspelningar');
define ('_LANG_RECORDING_SCHEDULES',  'Inspelningsregler');
define ('_LANG_RECORDED_PROGRAMS',    'Inspelat');
define ('_LANG_CATEGORY_LEGEND',      'Kategoriförklaring');
define ('_LANG_ACTION',               'Action');
define ('_LANG_ADULT',                'Adult');
define ('_LANG_ANIMALS',              'Djur');
define ('_LANG_ART_MUSIC',            'Konst/musik');
define ('_LANG_BUSINESS',             'Aff�rer/ekonomi');
define ('_LANG_CHILDREN',             'Barnprogram');
define ('_LANG_COMEDY',               'Komedi');
define ('_LANG_CRIME_MYSTERY',        'Brott/mysterier');
define ('_LANG_DOCUMENTARY',          'Dokumentär');
define ('_LANG_DRAMA',                'Drama');
define ('_LANG_EDUCATIONAL',          'Utbildning');
define ('_LANG_FOOD',                 'Mat');
define ('_LANG_GAME',                 'Lek/spel');
define ('_LANG_HEALTH_MEDICAL',       'Medicin/hälsa');
define ('_LANG_HISTORY',              'Historia');
define ('_LANG_HOWTO',                'Gör-det-själv');
define ('_LANG_HORROR',               'Rysare');
define ('_LANG_MISC',                 'Blandat');
define ('_LANG_NEWS',                 'Nyheter');
define ('_LANG_REALITY',              'Dokusåpa');
define ('_LANG_ROMANCE',              'Romantik');
define ('_LANG_SCIENCE_NATURE',       'Natur/vetenskap');
define ('_LANG_SCIFI_FANTASY',        'SciFi/fantasy');
define ('_LANG_SHOPPING',             'Shopping');
define ('_LANG_SOAPS',                'Såpopera');
define ('_LANG_SPIRITUAL',            'Andligt');
define ('_LANG_SPORTS',               'Sport');
define ('_LANG_TALK',                 'Talkshow');
define ('_LANG_TRAVEL',               'Resor');
define ('_LANG_WAR',                  'Krig');
define ('_LANG_WESTERN',              'Western');
define ('_LANG_MOVIES',               'Film');
define ('_LANG_UNKNOWN',              'Okänd');

define ('_LANG_CATMATCH_ACTION',               '\\b(?:action|adven)');
define ('_LANG_CATMATCH_ADULT',                '\\b(?:adult|erot)');
define ('_LANG_CATMATCH_ANIMALS',              '\\b(?:animal|tiere)');
define ('_LANG_CATMATCH_ART_MUSIC',            '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)');
define ('_LANG_CATMATCH_BUSINESS',             '\\b(?:biz|busine)');
define ('_LANG_CATMATCH_CHILDREN',             '\\b(?:child|kin?d|infan|animation)');
define ('_LANG_CATMATCH_COMEDY',               '\\b(?:comed|entertain|sitcom)');
define ('_LANG_CATMATCH_CRIME_MYSTERY',        '\\b(?:[ck]rim|myster)');
define ('_LANG_CATMATCH_DOCUMENTARY',          '\\b(?:do[ck])');
define ('_LANG_CATMATCH_DRAMA',                '\\b(?:drama)');
define ('_LANG_CATMATCH_EDUCATIONAL',          '\\b(?:edu|bildung|interests)');
define ('_LANG_CATMATCH_FOOD',                 '\\b(?:food|cook|essen|[dt]rink)');
define ('_LANG_CATMATCH_GAME',                 '\\b(?:game|spiele)');
define ('_LANG_CATMATCH_HEALTH_MEDICAL',       '\\b(?:health|medic|gesundheit)');
define ('_LANG_CATMATCH_HISTORY',              '\\b(?:hist|geschichte)');
define ('_LANG_CATMATCH_HOWTO',                '\\b(?:how|home|house|garden)');
define ('_LANG_CATMATCH_HORROR',               '\\b(?:horror)');
define ('_LANG_CATMATCH_MISC',                 '\\b(?:special|variety|info|collect)');
define ('_LANG_CATMATCH_NEWS',                 '\\b(?:news|nyheter|aktuellt|rapport|(Vä|�)stnytt)');
define ('_LANG_CATMATCH_REALITY',              '\\b(?:reality)');
define ('_LANG_CATMATCH_ROMANCE',              '\\b(?:romance|lieb)');
define ('_LANG_CATMATCH_SCIENCE_NATURE',       '\\b(?:science|nature|environment|wissenschaft)');
define ('_LANG_CATMATCH_SCIFI_FANTASY',        '\\b(?:fantasy|sci\\w*\\W*fi)');
define ('_LANG_CATMATCH_SHOPPING',             '\\b(?:shop)');
define ('_LANG_CATMATCH_SOAPS',                '\\b(?:soaps)');
define ('_LANG_CATMATCH_SPIRITUAL',            '\\b(?:spirit|relig)');
define ('_LANG_CATMATCH_SPORTS',               '\\b(?:sport|deportes|futbol)');
define ('_LANG_CATMATCH_TALK',                 '\\b(?:talk)');
define ('_LANG_CATMATCH_TRAVEL',               '\\b(?:travel|reisen)');
define ('_LANG_CATMATCH_WAR',                  '\\b(?:war|krieg)');
define ('_LANG_CATMATCH_WESTERN',              '\\b(?:west)');
define ('_LANG_CATMATCH_MOVIES',               '');

/* settings.php */
define ('_LANG_SETTINGS_HEADER1',              'Detta är startsidan för inställningar...');
define ('_LANG_SETTINGS_HEADER2',              'Sidan borde ha små söta bilder till länkarna till de olika avdelningarna, men detta är vad som finns för tillfället:');
define ('_LANG_CHANNELS',                      'Kanaler');
define ('_LANG_THEME',                         'Tema');
define ('_LANG_LANGUAGE',                      'Språk');
define ('_LANG_DATEFORMATS',                   'Datumformat');
define ('_LANG_KEY_BINDINGS',                  'Knappar');
define ('_LANG_CONFIGURE',                     'Konfigurera');
define ('_LANG_GO_TO',                         'Gå till');
define ('_LANG_ADVANCED',                      'Avancerad sökning');
define ('_LANG_FORMAT_HELP',                   'Format-hjälp');
define ('_LANG_STATUS_BAR',                    'Menyrad');
define ('_LANG_SCHEDULED_RECORDINGS',          'Kommande inspelningar');
define ('_LANG_SCHEDULED_POPUP',               'Inspelningsregler, popup:er');
define ('_LANG_RECORDED_PROGRAMS',             'Inspelningar');
define ('_LANG_SEARCH_RESULTS',                'Sökresultat');
define ('_LANG_LISTING_TIME_KEY',              'TV-tablå');
define ('_LANG_LISTING_JUMP_TO',               'TV-tablå, &quot;gå till&quot;');
define ('_LANG_CHANNEL_JUMP_TO',               'Kanal, &quot;gå till&quot;');
define ('_LANG_HOUR_FORMAT',                   'Tidsformat');
define ('_LANG_RESET',                         '�terställ');
define ('_LANG_SAVE',                          'Spara');
define ('_LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE', 'Visa beskrivningar på ny rad');

/* program_listings.php */
define ('_LANG_CURRENTLY_BROWSING', 'Aktuell tablå:');
define ('_LANG_JUMP_TO',            'Gå&nbsp;till');
define ('_LANG_HOUR',               'Tid');
define ('_LANG_DATE',               'Datum');
define ('_LANG_JUMP',               'Gå till');

/* program_detail.php */
define ('_LANG_SEARCH',                             'Sök');
define ('_LANG_IMDB',                               'IMDB');
define ('_LANG_GOOGLE',                             'Google');
define ('_LANG_TVTOME',                             'TV Tome');
define ('_LANG_MINUTES',                            'min.');
define ('_LANG_TO',                                 'till');
define ('_LANG_CATEGORY',                           'Kategori');
define ('_LANG_ORIG_AIRDATE',                       'Först sänt');
define ('_LANG_AIRDATE',                            'Sändningsdatum');
define ('_LANG_RECORDING_OPTIONS',                  'Inspelningsinställningar');
define ('_LANG_DONT_RECORD_THIS_PROGRAM',           'Spela inte in detta program.');
define ('_LANG_CANCEL_THIS_SCHEDULE',               'Avbryt denna inspelning.');
define ('_LANG_RECORDING_PROFILE',                  'Profil');
define ('_LANG_RECPRIORITY',                        'Prioritet');
define ('_LANG_CHECK_FOR_DUPLICATES_IN',            'Sök dubletter i');
define ('_LANG_CURRENT_RECORDINGS',                 'Aktuella inspelningar');
define ('_LANG_PREVIOUS_RECORDINGS',                'Gamla inspelningar');
define ('_LANG_ALL_RECORDINGS',                     'Alla inspelningar');
define ('_LANG_DUPLICATE_CHECK_METHOD',             'Dublettmatchning');
define ('_LANG_NONE',                               'Inget');
define ('_LANG_SUBTITLE',                           'Underrubrik');
define ('_LANG_DESCRIPTION',                        'Beskrivning');
define ('_LANG_SUBTITLE_AND_DESCRIPTION',           'Underrubrik & beskrivning');
define ('_LANG_SUB_AND_DESC',                       'Underrubr. & beskr. (tomma träffar)');
define ('_LANG_AUTO_EXPIRE_RECORDINGS',             'Radera gamla inspelningar?');
define ('_LANG_NO_OF_RECORDINGS_TO_KEEP',           'Antal inspelningar att behålla?');
define ('_LANG_RECORD_NEW_AND_EXPIRE_OLD',          'Rotera ut gamla inspelningar?');
define ('_LANG_START_EARLY',                        'Starta tidigare (minuter)');
define ('_LANG_END_LATE',                           'Sluta senare (minuter)');
define ('_LANG_UPDATE_RECORDING_SETTINGS',          'Uppdatera');
define ('_LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME',       'Vad mer visas vid denna tid?');
define ('_LANG_BACK_TO_THE_PROGRAM_LISTING',        'Tillbaka till TV-tablån!');
define ('_LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM', 'Sök andra sändningar av detta program');
define ('_LANG_BACK_TO_RECORDING_SCHEDULES',        'Tillbaka till inspelningsreglerna');

/* scheduled_recordings.php */
/* recording_schedules_php */
/* search.php */
define ('_LANG_NO_MATCHES_FOUND', 'Inga träffar');
define ('_LANG_SEARCH',           'Sök');
define ('_LANG_TITLE',            'Rubrik');
define ('_LANG_SUBTITLE',         'Underrubrik');
define ('_LANG_CATEGORY_TYPE',    'Kategorityp');
define ('_LANG_EXACT_MATCH',      'Exakt&nbsp;matchning');
define ('_LANG_CHANNUM',          'Station');
define ('_LANG_LENGTH',           'Längd');
define ('_LANG_COMMANDS',         'commands');
define ('_LANG_DONT_RECORD',      'Spela inte in');
define ('_LANG_ACTIVATE',         'Aktivera');
define ('_LANG_NEVER_RECORD',     'Spela aldrig in');
define ('_LANG_RECORD_THIS',      'Spela in');
define ('_LANG_FORGET_OLD',       'Glöm gamla');
define ('_LANG_DEFAULT',          'Default');
define ('_LANG_RATING',           'Betyg');
define ('_LANG_SCHEDULE',         'Schema');
define ('_LANG_DISPLAY',          'Visa');
define ('_LANG_SCHEDULED',        'Schemalagda');
define ('_LANG_DUPLICATES',       'Dubletter');
define ('_LANG_DEACTIVATED',      'Deaktiverade');
define ('_LANG_CONFLICTS',        'Konflikter');
define ('_LANG_TYPE',             'Typ');
define ('_LANG_AIRTIME',          'Sändningsdatum');
define ('_LANG_RERUN',            'Repris');
define ('_LANG_SCHEDULE',         'Schema');
define ('_LANG_PROFILE',          'Profil');
define ('_LANG_NOTES',            'Noteringar');
define ('_LANG_DUP_METHOD',       'Dublett-metod');

/* recorded_programs.php */
define ('_LANG_SHOW_RECORDINGS', 'Visa inspelningar');
define ('_LANG_CONFIRM_DELETE',  'Vill du verkligen radera denna inspelning?');
define ('_LANG_ALL_RECORDINGS',  'Alla inspelningar');
define ('_LANG_GO',              'Gå');
define ('_LANG_PREVIEW',         'Förhandsgranskning');
define ('_LANG_FILE_SIZE',       'Filstorlek');
define ('_LANG_DELETE',          'Radera');
define ('_LANG_PROGRAMS_USING',  'inspelningar, använder ');
define ('_LANG_OUT_OF',          ' av ');
define ('_LANG_EPISODES',        'episodes');

/* recordings.php */
define ('_LANG_RECTYPE_ONCE',    'Enstaka');
define ('_LANG_RECTYPE_DAILY',   'Dagligen');
define ('_LANG_RECTYPE_CHANNEL', 'Kanal');
define ('_LANG_RECTYPE_ALWAYS',  'Alltid');
define ('_LANG_RECTYPE_WEEKLY',  'Veckovis');
define ('_LANG_RECTYPE_FINDONE', 'Bästa tillfälle');

define ('_LANG_RECTYPE_LONG_ONCE',          'Spela enbart in denna visning.');
define ('_LANG_RECTYPE_LONG_DAILY',         'Spela in detta program vid denna tid varje dag.');
define ('_LANG_RECTYPE_LONG_CHANNEL',       'Spela alltid in detta program på kanal ');
define ('_LANG_RECTYPE_LONG_ALWAYS',        'Spela alltid in detta program på alla kanaler.');
define ('_LANG_RECTYPE_LONG_WEEKLY',        'Spela in detta program vid denna tid varje vecka.');
define ('_LANG_RECTYPE_LONG_FINDONE',       'Spela in detta program vid bästa tillfälle.');

define ('_LANG_RECSTATUS_LONG_DELETED',           'This showing was recorded but was deleted before recording was completed.');
define ('_LANG_RECSTATUS_LONG_STOPPED',           'This showing was recorded but was stopped before recording was completed.');
define ('_LANG_RECSTATUS_LONG_RECORDED',          'This showing was recorded.');
define ('_LANG_RECSTATUS_LONG_RECORDING',         'This showing is being recorded.');
define ('_LANG_RECSTATUS_LONG_WILLRECORD',        'This showing will be recorded.');
define ('_LANG_RECSTATUS_LONG_UNKNOWN',           'The status of this showing is unknown.');
define ('_LANG_RECSTATUS_LONG_MANUALOVERRIDE',    'This was manually set to not record');
define ('_LANG_RECSTATUS_LONG_PREVIOUSRECORDING', 'This episode was previously recorded according to the duplicate policy chosen for this title.');
define ('_LANG_RECSTATUS_LONG_CURRENTRECORDING',  'This episode was previously recorded and is still available in the list of recordings.');
define ('_LANG_RECSTATUS_LONG_EARLIERSHOWING',    'This episode will be recorded at an earlier time instead.');
define ('_LANG_RECSTATUS_LONG_LATERSHOWING',      'This episode will be recorded at a later time instead.');
define ('_LANG_RECSTATUS_LONG_TOOMANYRECORDINGS', 'Too many recordings of this program have already been recorded.');
define ('_LANG_RECSTATUS_LONG_CANCELLED',         'This was scheduled to be recorded but was manually canceled.');
define ('_LANG_RECSTATUS_LONG_CONFLICT',          'Another program with a higher recording priority will be recorded.');
define ('_LANG_RECSTATUS_LONG_OVERLAP',           'This is covered by another scheduled recording for the same program.');
define ('_LANG_RECSTATUS_LONG_LOWDISKSPACE',      'There wasn\'t enough disk space available to record this program.');
define ('_LANG_RECSTATUS_LONG_TUNERBUSY',         'The tuner card was already being used when this program was scheduled to be recorded.');
define ('_LANG_RECSTATUS_LONG_FORCE_RECORD',      'This show was manually set to record this specific instance.');

/* utils.php */
define ('_LANG_HR',              'h');
define ('_LANG_HRS',             'h');
define ('_LANG_MINS',            'min.');

/*
define ('_LANG_', '');
define ('_LANG_', '');
define ('_LANG_', '');
*/

?>
