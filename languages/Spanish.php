<?php

define ('_LANG_LANGUAGE_NAME', 'Spanish');

/* Set the locale to UTF-8 */
setlocale(LC_ALL, 'es_ES.UTF-8');

/* Default date and time formats */
define('generic_date', '%b %e, %Y');
define('generic_time', '%I:%M %p');

/* theme.php */
define ('_LANG_BACKEND_STATUS',       'Backend');
define ('_LANG_SETTINGS',             'Configurar');
define ('_LANG_LISTINGS',             'Parrilla');
define ('_LANG_FAVOURITES',           'Favoritos');
define ('_LANG_SCHEDULED_RECORDINGS', 'Ver programaciones');
define ('_LANG_RECORDING_SCHEDULES',  'Programar grabaciones');
define ('_LANG_RECORDED_PROGRAMS',    'Programas grabados');
define ('_LANG_MANUALLY_SCHEDULE',    'Programaci&oacute;n manual');
define ('_LANG_CATEGORY_LEGEND',      'Leyenda de categor&iacute;as');
define ('_LANG_ACTION',               'Acci&oacute;n');
define ('_LANG_ADULT',                'Adultos');
define ('_LANG_ANIMALS',              'Animales');
define ('_LANG_ART_MUSIC',            'Arte / M&uacute;sica');
define ('_LANG_BUSINESS',             'Profesional');
define ('_LANG_CHILDREN',             'Infantil');
define ('_LANG_COMEDY',               'Comedia');
define ('_LANG_CRIME_MYSTERY',        'Misterio / Cr&iacute;men');
define ('_LANG_DOCUMENTARY',          'Documental');
define ('_LANG_DRAMA',                'Drama');
define ('_LANG_EDUCATIONAL',          'Educativo');
define ('_LANG_FOOD',                 'Alimentaci&oacute;n');
define ('_LANG_GAME',                 'Juegos');
define ('_LANG_HEALTH_MEDICAL',       'Salud / Medicina');
define ('_LANG_HISTORY',              'Historia');
define ('_LANG_HOWTO',                'C&oacute;mo...');
define ('_LANG_HORROR',               'Terror');
define ('_LANG_MISC',                 'Varios');
define ('_LANG_NEWS',                 'Noticias');
define ('_LANG_REALITY',              'Reality Shows');
define ('_LANG_ROMANCE',              'Romance');
define ('_LANG_SCIENCE_NATURE',       'Ciencias Naturales');
define ('_LANG_SCIFI_FANTASY',        'Ciencia Ficci&oacute;n');
define ('_LANG_SHOPPING',             'Compras');
define ('_LANG_SOAPS',                'Soaps?');
define ('_LANG_SPIRITUAL',            'Espiritual');
define ('_LANG_SPORTS',               'Deportes');
define ('_LANG_TALK',                 'Debates');
define ('_LANG_TRAVEL',               'Viajar');
define ('_LANG_WAR',                  'Guerras');
define ('_LANG_WESTERN',              'Western');
define ('_LANG_MOVIES',               'Pel&iacute;culas');
define ('_LANG_UNKNOWN',              'Desconocido');

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
define ('_LANG_SETTINGS_HEADER1',              'Esta es la p&aacute;gina principal de configuraci&oacute;n...');
define ('_LANG_SETTINGS_HEADER2',              'De momento, tenemos:');
define ('_LANG_CHANNELS',                      'Canales');
define ('_LANG_THEME',                         'Tema');
define ('_LANG_LANGUAGE',                      'Lenguage');
define ('_LANG_DATEFORMATS',                   'Fechas / Formatos de Fecha');
define ('_LANG_KEY_BINDINGS',                  'Key Bindings');
define ('_LANG_CONFIGURE',                     'Configurar');
define ('_LANG_GO_TO',                         'Ir a');
define ('_LANG_ADVANCED',                      'avanzada');
define ('_LANG_FORMAT_HELP',                   'Ayuda sobre formatos');
define ('_LANG_STATUS_BAR',                    'Barra de Estado');
define ('_LANG_SCHEDULED_RECORDINGS',          'Grabaciones Programadas');
define ('_LANG_SCHEDULED_POPUP',               'Popup Programados');
define ('_LANG_RECORDED_PROGRAMS',             'Programas Grabados');
define ('_LANG_SEARCH_RESULTS',                'Resultados de la b&uacute;squeda');
define ('_LANG_LISTING_TIME_KEY',              'Listado de tiempo');
define ('_LANG_LISTING_JUMP_TO',               '&quot;Ir a&quot; Listado');
define ('_LANG_CHANNEL_JUMP_TO',               '&quot;Ir a&quot; Canal');
define ('_LANG_HOUR_FORMAT',                   'Formato Horario');
define ('_LANG_RESET',                         'Cancelar');
define ('_LANG_SAVE',                          'Guardar');
define ('_LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE', 'Mostrar la descripc&oacute;n en una nueva l&iacute;a');

/* program_listings.php */
define ('_LANG_CURRENTLY_BROWSING', 'Mostrando:');
define ('_LANG_JUMP_TO',            'Ir a');
define ('_LANG_HOUR',               'Hora');
define ('_LANG_DATE',               'Fecha');
define ('_LANG_JUMP',               'Ir');
define ('_LANG_NODATA',               'SIN DATOS');


/* program_detail.php */
define ('_LANG_SEARCH',                             'Buscar');
define ('_LANG_IMDB',                               'IMDB');
define ('_LANG_GOOGLE',                             'Google');
define ('_LANG_TVTOME',                             'TV Tome');
define ('_LANG_MINUTES',                            'minutos');
define ('_LANG_TO',                                 'De');
define ('_LANG_CATEGORY',                           'Categor&iacute;a');
define ('_LANG_EPISODE',                           'Episodio');
define ('_LANG_DESCRIPTION',                           'Descripci&oacute;n');
define ('_LANG_ORIG_AIRDATE',                       'A&ntilde;o de emisi&oacute;n');
define ('_LANG_AIRDATE',                            'Horario');
define ('_LANG_RECORDING_OPTIONS',                  'Opciones de Grabaci&oacute;n');
define ('_LANG_DONT_RECORD_THIS_PROGRAM',           'No grabar este programa.');
define ('_LANG_CANCEL_THIS_SCHEDULE',               'Cancelar esta programaci&oacute;n.');
define ('_LANG_RECORDING_PROFILE',                  'Perfil de Grabaci&oacute;n');
define ('_LANG_RECPRIORITY',                        'Prioridad de Grabaci&oacute;n');
define ('_LANG_CHECK_FOR_DUPLICATES_IN',            'Comprobar duplicidades en');
define ('_LANG_CURRENT_RECORDINGS',                 'Grabaciones actuales');
define ('_LANG_PREVIOUS_RECORDINGS',                'Grabaciones anteriores');
define ('_LANG_ALL_RECORDINGS',                     'Todas las grabaciones');
define ('_LANG_DUPLICATE_CHECK_METHOD',             'M&eacute;todo de Comprobaci&oacute;n de Duplicidades');
define ('_LANG_NONE',                               'Ninguno');
define ('_LANG_SUBTITLE',                           'Subt&iacute;tulo');
define ('_LANG_DESCRIPTION',                        'Descripci&oacute;n');
define ('_LANG_SUBTITLE_AND_DESCRIPTION',           'Subt&iacute;tulo & Descripci&oacute;n');
define ('_LANG_SUB_AND_DESC',                       'Sub & Desc (Ning&uacute;n resultado)');
define ('_LANG_AUTO_EXPIRE_RECORDINGS',             'Auto-expirar Grabaciones?');
define ('_LANG_NO_OF_RECORDINGS_TO_KEEP',           'Num. de Grabaciones a Guardar?');
define ('_LANG_RECORD_NEW_AND_EXPIRE_OLD',          'Grabar el Nuevo y Expirar el Anterior?');
define ('_LANG_START_EARLY',                        'Empezar Antes (minutos)');
define ('_LANG_END_LATE',                           'Acabar m&aacute;s Tarde (minutos)');
define ('_LANG_UPDATE_RECORDING_SETTINGS',          'Actualizar Par&aacute;metros de Grabaci&oacute;n');
define ('_LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME',       'Qu&eacute; m&aacute;s hay a esta hora?');
define ('_LANG_BACK_TO_THE_PROGRAM_LISTING',        'Volver al listado de programas!');
define ('_LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM', 'Buscar otras emisiones de este programa');
define ('_LANG_BACK_TO_RECORDING_SCHEDULES',        'Volver a la Programaci&oacute;n de Grabaciones');

/* scheduled_recordings.php */
/* recording_schedules_php */
/* search.php */
define ('_LANG_NO_MATCHES_FOUND', 'Ning&uacute;n resultado');
define ('_LANG_SEARCH',           'Buscar');
define ('_LANG_TITLE',            'Programa');
define ('_LANG_SUBTITLE',         'Subt&iacute;tulo');
define ('_LANG_CATEGORY_TYPE',    'Tipo de Categor&iacute;a');
define ('_LANG_EXACT_MATCH',      'Coincidencia exacta');
define ('_LANG_CHANNUM',          'Canal');
define ('_LANG_LENGTH',           'Duraci&oacute;n');
define ('_LANG_COMMANDS',         'comandos');
define ('_LANG_DONT_RECORD',      'No Grabar');
define ('_LANG_ACTIVATE',         'Activar');
define ('_LANG_NEVER_RECORD',     'No Grabar Nunca');
define ('_LANG_RECORD_THIS',      'Grabar este');
define ('_LANG_FORGET_OLD',       'Descartar Anteriores');
define ('_LANG_DEFAULT',          'Por Defecto');
define ('_LANG_RATING',           'Rating');
define ('_LANG_SCHEDULE',         '&Oacute;rden');
define ('_LANG_DISPLAY',          'Mostrar');
define ('_LANG_SCHEDULED',        'Programados');
define ('_LANG_DUPLICATES',       'Duplicados');
define ('_LANG_DEACTIVATED',      'Desactivados');
define ('_LANG_CONFLICTS',        'Con Conflictos');
define ('_LANG_TYPE',             'Tipo');
define ('_LANG_AIRTIME',          'Horario');
define ('_LANG_RERUN',            'Visto');
define ('_LANG_SCHEDULE',         'Programado');
define ('_LANG_PROFILE',          'Perfil');
define ('_LANG_NOTES',            'Notas');
define ('_LANG_DUP_METHOD',       'M&eacute;todo de duplicidad');
define ('_LANG_ANY',              'Cualquiera');

/* recorded_programs.php */
define ('_LANG_SHOW_RECORDINGS', 'Mostrar');
define ('_LANG_CONFIRM_DELETE',  'Est&aacute;s seguro que quieres borrar esta grabaci&oacute;n?');
define ('_LANG_ALL_RECORDINGS',  'Todas las grabaciones');
define ('_LANG_GO',              'Ir');
define ('_LANG_PREVIEW',         'previo');
define ('_LANG_FILE_SIZE',       'tama&atilde;o de fichero');
define ('_LANG_DELETE',          'Borrar');
define ('_LANG_PROGRAMS_USING',  'programas, usando');
define ('_LANG_OUT_OF',          ' de ');
define ('_LANG_EPISODES',        'episodios');
define ('_LANG_SHOW_HAS_COMMFLAG',   'anuncios marcados');
define ('_LANG_SHOW_HAS_CUTLIST',    'tiene lista de cortes');
define ('_LANG_SHOW_IS_EDITING',     'siendo editado');
define ('_LANG_SHOW_AUTO_EXPIRE',    'auto expira');
define ('_LANG_SHOW_HAS_BOOKMARK',   'tiene memoria de posici&oacute;n');
define ('_LANG_YES',                 'Si');
define ('_LANG_NO',                  'No');

/* recordings.php */
define ('_LANG_RECTYPE_ONCE',    'Esta vez');
define ('_LANG_RECTYPE_DAILY',   'Diariamente');
define ('_LANG_RECTYPE_CHANNEL', 'Canal');
define ('_LANG_RECTYPE_ALWAYS',  'Siempre');
define ('_LANG_RECTYPE_WEEKLY',  'Semanalmente');
define ('_LANG_RECTYPE_FINDONE', 'Busca Uno');

define ('_LANG_RECTYPE_LONG_ONCE',          'Grabar s&oacute;lo esta emisi&oacute;n.');
define ('_LANG_RECTYPE_LONG_DAILY',         'Grabar este programa a esta hora cada d&iacute;a.');
define ('_LANG_RECTYPE_LONG_CHANNEL',       'Grabar siempre este programa en el canal');
define ('_LANG_RECTYPE_LONG_ALWAYS',        'Grabar siempre este programa en cualquier canal.');
define ('_LANG_RECTYPE_LONG_WEEKLY',        'Grabar este programa a esta hora cada semana');
define ('_LANG_RECTYPE_LONG_FINDONE',       'Grabar una emisi&oacute;n de este programa a cualquier hora.');

define ('_LANG_RECSTATUS_LONG_DELETED',           'Este programa fu&eacute; grabado pero se borr&oacute; antes de completar la grabaci&oacute;n.');
define ('_LANG_RECSTATUS_LONG_STOPPED',           'Este programafu&eacute; grabado pero se detuvo antes de completar la grabaci&oacute;n.');
define ('_LANG_RECSTATUS_LONG_RECORDED',          'Este programa fu&eacute; grabado.');
define ('_LANG_RECSTATUS_LONG_RECORDING',         'Este programa est&aacute; siendo grabado.');
define ('_LANG_RECSTATUS_LONG_WILLRECORD',        'Este programa ser&aacute; grabado.');
define ('_LANG_RECSTATUS_LONG_UNKNOWN',           'El estado de este programa es desconocido.');
define ('_LANG_RECSTATUS_LONG_MANUALOVERRIDE',    'Este programa no se grab&oacute; expresamente');
define ('_LANG_RECSTATUS_LONG_PREVIOUSRECORDING', 'Este episodio fu&eacute; grabado anteriormente de acuerdo con la pol&iacute;tica de duplicidad elegida para este t&iacutetulo.');
define ('_LANG_RECSTATUS_LONG_CURRENTRECORDING',  'Este episodio fu&eacute; grabado anteriormente y est&aacute; disponible en la lista de grabaciones.');
define ('_LANG_RECSTATUS_LONG_EARLIERSHOWING',    'Este episodio ser&aacute; grabado en una hora anterior.');
define ('_LANG_RECSTATUS_LONG_LATERSHOWING',      'Este episodio ser&aacute; grabado en una hora posterior.');
define ('_LANG_RECSTATUS_LONG_TOOMANYRECORDINGS', 'Se han grabado ya demasiadas veces este programa.');
define ('_LANG_RECSTATUS_LONG_CANCELLED',         'Estaba programado para grabarse, pero fu&eacute; cancelado manualmente.');
define ('_LANG_RECSTATUS_LONG_CONFLICT',          'Se grabar&aacute; otro programa con mayor prioridad a este.');
define ('_LANG_RECSTATUS_LONG_OVERLAP',           'Esta solapado con una programaci&oacute;n de grabaci&oacute;n de este mismo programa.');
define ('_LANG_RECSTATUS_LONG_LOWDISKSPACE',      'No hay suficiente espacio en disco para grabar este programa.');
define ('_LANG_RECSTATUS_LONG_TUNERBUSY',         'La tarjeta sintonizadora va a estar siendo utilizada cuando este programa está programado.');
define ('_LANG_RECSTATUS_LONG_FORCE_RECORD',      'Esta emisi&oacute;n fu&eacute; programada para grabaci&oacute;n manualmente.');

/* weather.php */
define ('_LANG_HUMIDITY',		'Humedad');
define ('_LANG_PRESSURE',		'Presi&oacute;n');
define ('_LANG_WIND',			'Viento');
define ('_LANG_VISIBILITY',		'Visibilidad');
define ('_LANG_WIND_CHILL',		'Frialdad del Viento');
define ('_LANG_UV_INDEX',		'&Iacute;ndice UV');
define ('_LANG_UV_MINIMAL',		'm&iacute;nima');
define ('_LANG_UV_MODERATE',		'moderada');
define ('_LANG_UV_HIGH',		'alta');
define ('_LANG_UV_EXTREME',		'extrema');
define ('_LANG_CURRENT_CONDITIONS',	'Condiciones actuales');
define ('_LANG_FORECAST',		'Previsi&oacute;n');
define ('_LANG_LAST_UPDATED',		'&Uacute;ltima actualizaci&oacute;n');
define ('_LANG_HIGH',			'Alta');
define ('_LANG_LOW',			'Baja');
define ('_LANG_UNKNOWN',		'Desconocida');
define ('_LANG_RADAR',			'Radar');
define ('_LANG_AT',			'a');

define ('_LANG_TODAY',			'Hoy');
define ('_LANG_TOMORROW',		'Ma&ntilde;ana');
define ('_LANG_MONDAY',			'Lunes');
define ('_LANG_TUESDAY',		'Martes');
define ('_LANG_WEDNESDAY',		'Mi&eacute;rcoles');
define ('_LANG_THURSDAY',		'Jueves');
define ('_LANG_FRIDAY',			'Viernes');
define ('_LANG_SATURDAY',		'S&aacute;bado');
define ('_LANG_SUNDAY',			'Domingo');

/* utils.php */
define ('_LANG_HR',              'hr');
define ('_LANG_HRS',             'hrs');
define ('_LANG_MINS',            'mins');

/* schedule_manually.php */
define ('_LANG_STARTTIME',              'Hora');
define ('_LANG_STARTDATE',              'Fecha');

/* mythtvburn.php */
define ('_LANG_STATION',              'Canal');

/*
define ('_LANG_', '');
define ('_LANG_', '');
define ('_LANG_', '');
*/
?>