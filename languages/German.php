<?php

define ('_LANG_LANGUAGE_NAME', 'German');

/* Default date and time formats */
define('generic_date', '%e %b, %Y');
define('generic_time', '%H:%M %p');

/* Set locale to German */
setlocale(LC_ALL, 'de_DE');

/* theme.php */
define ('_LANG_BACKEND_STATUS',       'Backend Status');
define ('_LANG_SETTINGS',             'Einstellungen');
define ('_LANG_LISTINGS',             'Programm&uuml;bersicht');
define ('_LANG_FAVOURITES',           'Favoriten');
define ('_LANG_SCHEDULED_RECORDINGS', 'Aufnahmeplan');
define ('_LANG_RECORDING_SCHEDULES',  'Aufnahmemodi');
define ('_LANG_RECORDED_PROGRAMS',    'Alle Aufnahmen');
define ('_LANG_CATEGORY_LEGEND',      'Category Legend');
define ('_LANG_ACTION',               'Action');
define ('_LANG_ADULT',                'Adult');
define ('_LANG_ANIMALS',              'Tiere');
define ('_LANG_ART_MUSIC',            'Art_Music');
define ('_LANG_BUSINESS',             'Business');
define ('_LANG_CHILDREN',             'Kinder');
define ('_LANG_COMEDY',               'Comedy');
define ('_LANG_CRIME_MYSTERY',        'Crime_Mystery');
define ('_LANG_DOCUMENTARY',          'Documentary');
define ('_LANG_DRAMA',                'Drama');
define ('_LANG_EDUCATIONAL',          'Bildung');
define ('_LANG_FOOD',                 'Essen');
define ('_LANG_GAME',                 'Spiele');
define ('_LANG_HEALTH_MEDICAL',       'Health_Medical');
define ('_LANG_HISTORY',              'History');
define ('_LANG_HOWTO',                'HowTo');
define ('_LANG_HORROR',               'Horror');
define ('_LANG_MISC',                 'Misc');
define ('_LANG_NEWS',                 'Nachrichten');
define ('_LANG_REALITY',              'Reality');
define ('_LANG_ROMANCE',              'Romantik');
define ('_LANG_SCIENCE_NATURE',       'Wissenschaft_Natur');
define ('_LANG_SCIFI_FANTASY',        'SciFi_Fantasy');
define ('_LANG_SHOPPING',             'Shopping');
define ('_LANG_SOAPS',                'Soaps');
define ('_LANG_SPIRITUAL',            'Spiritual');
define ('_LANG_SPORTS',               'Sport');
define ('_LANG_TALK',                 'Talk');
define ('_LANG_TRAVEL',               'Reisen');
define ('_LANG_WAR',                  'Krieg');
define ('_LANG_WESTERN',              'Western');
define ('_LANG_MOVIES',               'Filme');
define ('_LANG_UNKNOWN',              'Unbekannt');

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
define ('_LANG_CATMATCH_NEWS',                 '\\b(?:news|nachrichten|current)');
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
define ('_LANG_SETTINGS_HEADER1',     'Dies ist die Seite f&uuml;r die Einstellungen...');
define ('_LANG_SETTINGS_HEADER2',     'Hier sollen noch ein paar Bildchen hin, aber jetzt erstmal so:');
define ('_LANG_CHANNELS',             'Sender');
define ('_LANG_THEME',                'Theme');
define ('_LANG_LANGUAGE',             'Sprache');
define ('_LANG_DATEFORMATS',          'Datum/Datums-Formate');
define ('_LANG_KEY_BINDINGS',         'Tastaturbelegung');
define ('_LANG_CONFIGURE',            'Einstellen');
define ('_LANG_GO_TO',                'Gehe zu');
define ('_LANG_ADVANCED',             'Erweitert');
define ('_LANG_SEARCH',               'Suchen');
define ('_LANG_FORMAT_HELP',          'Hilfe zum Format');
define ('_LANG_STATUS_BAR',           'Status Balken');
define ('_LANG_SCHEDULED_RECORDINGS', 'Geplante Aufnahmen');
define ('_LANG_SCHEDULED_POPUP',      'Aufnahmen Popup');
define ('_LANG_RECORDED_PROGRAMS',    'Aufgenommene Programme');
define ('_LANG_SEARCH_RESULTS',       'Suchergebnisse');
define ('_LANG_LISTING_TIME_KEY',     'Listing Time Key');
define ('_LANG_LISTING_JUMP_TO',      'Liste &quot;Springe zu&quot;');
define ('_LANG_CHANNEL_JUMP_TO',      'Sender &quot;Springe zu&quot;');
define ('_LANG_HOUR_FORMAT',          'Stunden Format');
define ('_LANG_RESET',                'Zur&uuml;cksetzen');
define ('_LANG_SAVE',                 'Speichern');
define ('_LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE', 'Zeige Beschreibungen auf neuer Zeile');

/* program_listings.php */
define ('_LANG_CURRENTLY_BROWSING', 'Zur Zeit');
define ('_LANG_JUMP_TO',            'Springe&nbsp;zu');
define ('_LANG_HOUR',               'Stunde');
define ('_LANG_DATE',               'Datum');
define ('_LANG_JUMP',               '&Auml;ndern');

/* program_detail.php */
define ('_LANG_SEARCH',                             'Suche bei ');
define ('_LANG_IMDB',                               'IMDB');
define ('_LANG_GOOGLE',                             'Google');
define ('_LANG_TVTOME',                             'TV Tome');
define ('_LANG_MINUTES',                            'Minuten');
define ('_LANG_TO',                                 'zu');
define ('_LANG_CATEGORY',                           'Kategorie');
define ('_LANG_ORIG_AIRDATE',                       'Orig. Sendezeit');
define ('_LANG_AIRDATE',                            'Sendezeit');
define ('_LANG_RECORDING_OPTIONS',                  'Aufnahme Optionen');
define ('_LANG_DONT_RECORD_THIS_PROGRAM',           'Dieses Programm nicht aufnehmen.');
define ('_LANG_CANCEL_THIS_SCHEDULE',               'Diese Aufnahme abbrechen.');
define ('_LANG_RECORDING_PROFILE',                  'Aufnahme Profil');
define ('_LANG_RECPRIORITY',                        'Aufnahmepriorit&auml;t');
define ('_LANG_CHECK_FOR_DUPLICATES_IN',            'Pr&uuml;fe auf Duplikate in');
define ('_LANG_CURRENT_RECORDINGS',                 'momentanen Aufnahmen');
define ('_LANG_PREVIOUS_RECORDINGS',                'vorherigen Aufnahmen');
define ('_LANG_ALL_RECORDINGS',                     'alle Aufnahmen');
define ('_LANG_DUPLICATE_CHECK_METHOD',             'Testmethode f&uuml;r Duplikate');
define ('_LANG_NONE',                               'keine');
define ('_LANG_SUBTITLE',                           'Untertitel');
define ('_LANG_DESCRIPTION',                        'Beschreibung');
define ('_LANG_SUBTITLE_AND_DESCRIPTION',           'Untertitel & Beschreibung');
define ('_LANG_SUB_AND_DESC',                       'Untertitel & Beschr. (Leere Ergebnisse)');
define ('_LANG_AUTO_EXPIRE_RECORDINGS',             'Automatisch L&ouml;schen?');
define ('_LANG_NO_OF_RECORDINGS_TO_KEEP',           'Wieviele Folgen behalten:');
define ('_LANG_RECORD_NEW_AND_EXPIRE_OLD',          'Neue Folgen aufnehmen und alte l&ouml;schen?');
define ('_LANG_START_EARLY',                        'fr&uuml;her Starten (in Min.)');
define ('_LANG_END_LATE',                           'sp&auml;ter Enden (in Min.)');
define ('_LANG_UPDATE_RECORDING_SETTINGS',          'Aufnahmeneinstellungen &auml;ndern');
define ('_LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME',       'Was kommt noch zu dieser Zeit?');
define ('_LANG_BACK_TO_THE_PROGRAM_LISTING',        'Zur&uuml;ck zur Prgramm&uuml;bersicht!');
define ('_LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM', 'Finde einen anderen Sendetermin dieser Sendung!');
define ('_LANG_BACK_TO_RECORDING_SCHEDULES',        'Zur&uuml;ck zur Aufnahmeplanung');

/* scheduled_recordings.php */
/* recording_schedules_php */
/* search.php */
define ('_LANG_NO_MATCHES_FOUND', 'Keine &Uuml;bereinstimmungen gefunden');
define ('_LANG_SEARCH',           'Suche');
define ('_LANG_TITLE',            'Programm');
define ('_LANG_SUBTITLE',         'Folge');
define ('_LANG_CATEGORY_TYPE',    'Kategorie');
define ('_LANG_EXACT_MATCH',      'exakte&nbsp;Treffer');
define ('_LANG_CHANNUM',          'Sender');
define ('_LANG_LENGTH',           'L&auml;nge');
define ('_LANG_COMMANDS',         'Aktion');
define ('_LANG_DONT_RECORD',      'Nicht Aufnehmen');
define ('_LANG_ACTIVATE',         'Aktivieren');
define ('_LANG_NEVER_RECORD',     'Nie Aufnehmen');
define ('_LANG_RECORD_THIS',      'Record This');
define ('_LANG_FORGET_OLD',       'Forget Old');
define ('_LANG_DEFAULT',          'Default');
define ('_LANG_RATING',           'Bewertung');
define ('_LANG_SCHEDULE',         'Modus');
define ('_LANG_DISPLAY',          'Anzeige');
define ('_LANG_SCHEDULED',        'Geplant');
define ('_LANG_DUPLICATES',       'Duplicates');
define ('_LANG_DEACTIVATED',      'Deaktiviert');
define ('_LANG_CONFLICTS',        'Konflikte');
define ('_LANG_TYPE',             'Modus');
define ('_LANG_AIRTIME',          'Sendezeit');
define ('_LANG_RERUN',            'Wiederholung');
define ('_LANG_SCHEDULE',         'Schedule');
define ('_LANG_PROFILE',          'Profil');
define ('_LANG_NOTES',            'Notizen');
define ('_LANG_DUP_METHOD',       'Dup Method');

/* recorded_programs.php */
define ('_LANG_SHOW_RECORDINGS', 'Aufnahmen zeigen');
define ('_LANG_CONFIRM_DELETE',  'Bist Du sicher das Du die folgende Show l&ouml;schen m&ouml;chtest?');
define ('_LANG_ALL_RECORDINGS',  'Alle Aufnahmen');
define ('_LANG_GO',              'Gehe');
define ('_LANG_PREVIEW',         'Vorschau');
define ('_LANG_FILE_SIZE',       'Dateigr&ouml;&szlig;e');
define ('_LANG_DELETE',          'L&ouml;schen');
define ('_LANG_PROGRAMS_USING',  'Aufnahmen, belegen');
define ('_LANG_OUT_OF',          ' von ');
define ('_LANG_EPISODES',        'Episoden');
define ('_LANG_SHOW_HAS_COMMFLAG',   'flagged commercials');
define ('_LANG_SHOW_HAS_CUTLIST',    'has cutlist');
define ('_LANG_SHOW_IS_EDITING',     'being edited');
define ('_LANG_SHOW_AUTO_EXPIRE',    'auto expire');
define ('_LANG_SHOW_HAS_BOOKMARK',   'has bookmark');
define ('_LANG_YES',                 'Yes');
define ('_LANG_NO',                  'No');

/* recordings.php */
define ('_LANG_RECTYPE_ONCE',    'Einmal');
define ('_LANG_RECTYPE_DAILY',   'T&auml;glich');
define ('_LANG_RECTYPE_CHANNEL', 'Sender');
define ('_LANG_RECTYPE_ALWAYS',  'Immer');
define ('_LANG_RECTYPE_WEEKLY',  'W&ouml;chentlich');
define ('_LANG_RECTYPE_FINDONE', 'FindOne');
define ('_LANG_RECTYPE_OVERRIDE', '[translate me] Override (record)');
define ('_LANG_RECTYPE_DONTREC', '[translate me] Do Not Record');

define ('_LANG_RECTYPE_LONG_ONCE',          'Einmalige Aufnahme.');
define ('_LANG_RECTYPE_LONG_DAILY',         'T&auml;glich zu dieser Zeit aufnehmen.');
define ('_LANG_RECTYPE_LONG_CHANNEL',       'Always record this program on channel ');
define ('_LANG_RECTYPE_LONG_ALWAYS',        'Always record this program on any channel.');
define ('_LANG_RECTYPE_LONG_WEEKLY',        'W&ouml;chentlich zu dieser Zeit aufnehmen.');
define ('_LANG_RECTYPE_LONG_FINDONE',       'Record one showing of this program at any time.');

define ('_LANG_RECSTATUS_LONG_DELETED',           'Diese Sendung wurde aufgenommen aber vorzeitig gel&ouml;scht.');
define ('_LANG_RECSTATUS_LONG_STOPPED',           'Diese Sendung wurde aufgenommen aber vorzeitig abgebrochen.');
define ('_LANG_RECSTATUS_LONG_RECORDED',          'Diese Sendung wurde aufgenommen.');
define ('_LANG_RECSTATUS_LONG_RECORDING',         'Dies Sendung wird gerade aufgenommen.');
define ('_LANG_RECSTATUS_LONG_WILLRECORD',        'Diese Sendung wird aufgenommen.');
define ('_LANG_RECSTATUS_LONG_UNKNOWN',           'Der Status dieser Sendung ist unbekannt.');
define ('_LANG_RECSTATUS_LONG_MANUALOVERRIDE',    'Diese Sendung wurde manuell blockiert.');
define ('_LANG_RECSTATUS_LONG_PREVIOUSRECORDING', 'This episode was previously recorded according to the duplicate policy chosen for this title.');
define ('_LANG_RECSTATUS_LONG_CURRENTRECORDING',  'Diese Folge wurde schon aufgenommen und noch nicht gel&ouml;scht.');
define ('_LANG_RECSTATUS_LONG_EARLIERSHOWING',    'Diese Folge wird stattdessen fr&uml;her aufgenommen.');
define ('_LANG_RECSTATUS_LONG_LATERSHOWING',      'Diese Folge wird zu einem sp&auml;teren Zeitpunkt aufgenommen.');
define ('_LANG_RECSTATUS_LONG_TOOMANYRECORDINGS', 'F&uuml;r diese Serie wurden schon zu viele Folgen aufgenommen.');
define ('_LANG_RECSTATUS_LONG_CANCELLED',         'This was scheduled to be recorded but was manually canceled.');
define ('_LANG_RECSTATUS_LONG_CONFLICT',          'Ein anderes Programm mit h&ouml;herer Priorität wird stattdessen aufgenommen.');
define ('_LANG_RECSTATUS_LONG_OVERLAP',           'Diese Aufnahme ist bereits durch eine andere Aufnahme derselben Serie abgedeckt.');
define ('_LANG_RECSTATUS_LONG_LOWDISKSPACE',      'Es stand nicht genug Plattenplatz zur Verf&uuml;gung.');
define ('_LANG_RECSTATUS_LONG_TUNERBUSY',         'The tuner card was already being used when this program was scheduled to be recorded.');
define ('_LANG_RECSTATUS_LONG_FORCE_RECORD',      'This show was manually set to record this specific instance.');

/* utils.php */
define ('_LANG_HR',              'Std');
define ('_LANG_HRS',             'Std');
define ('_LANG_MINS',            'Min');

/*
define ('_LANG_', '');
define ('_LANG_', '');
define ('_LANG_', '');
*/

/* mythweather */
define ('_LANG_CURRENT_CONDITIONS',	'Aktuelle Wetterlage');
define ('_LANG_HUMIDITY',		'Feuchtigkeit');
define ('_LANG_PRESSURE',		'Luftdruck');
define ('_LANG_WIND',			'Windrichtung');
define ('_LANG_VISIBILITY',		'Sichtweite');
define ('_LANG_AT',			'mit');
define ('_LANG_WIND_CHILL',		'Windschnelligkeit');
define ('_LANG_UV_INDEX',		'Ozonwert');
define ('_LANG_UV_MINIMAL',		'Minimal');
define ('_LANG_FORECAST',		'Vorschau');
define ('_LANG_MONDAY',			'Montag');
define ('_LANG_TUESDAY',		'Dienstag');
define ('_LANG_WEDNESDAY',		'Mittwoch');
define ('_LANG_THURSDAY',		'Donnerstag');
define ('_LANG_FRIDAY',			'Freitag');
define ('_LANG_SATURDAY',		'Samstag');
define ('_LANG_SUNDAY',			'Sonntag');
define ('_LANG_TODAY',			'Heute');
define ('_LANG_TOMORROW',		'Morgen');
define ('_LANG_LOW',			'Min');
define ('_LANG_HIGH',			'Max');
define ('_LANG_RADAR',			'Radarbild');
define ('_LANG_LAST_UPDATED',		'Zuletzt aktualisiert');

?>
