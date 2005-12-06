<?php
/***                                                                        ***\
    languages/Spanish.php

    Translation hash for Spanish.
\***                                                                        ***/

// Set the locale to Spanish UTF-8
setlocale(LC_ALL, 'es_ES.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    ' at '                                                => ' a ',
    '$1 Rating'                                           => 'Puntuación $1',
    '$1 episode'                                          => '$1 episodio',
    '$1 episodes'                                         => '$1 episodios',
    '$1 hr'                                               => '$1 hr',
    '$1 hrs'                                              => '$1 hrs',
    '$1 min'                                              => '$1 min',
    '$1 mins'                                             => '$1 mins',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'     => '$1 programas, usando $2 ($3) de $4 ($5 libre))',
    '$1 recording'                                        => '$1 grabación',
    '$1 recordings'                                       => '$1 grabaciones',
    '$1 to $2'                                            => '$1 a $2',
    'Activate'                                            => 'Activar',
    'Advanced Options'                                    => 'Opciones Avanzadas',
    'Airtime'                                             => 'Horario',
    'All recordings'                                      => 'Todas las grabaciones',
    'Are you sure you want to delete the following show?' => 'Está seguro de borrar el siguiente programa?',
    'Auto-expire recordings'                              => 'Autoexpirar grabaciones',
    'Auto-flag commercials'                               => 'Automarcar anuncios',
    'Auto-transcode'                                      => 'Auto-recodificar',
    'Back to the program listing'                         => 'Volver al listado de programas',
    'Back to the recording schedules'                     => 'Volver a la programación',
    'Backend Logs'                                        => '',
    'Backend Status'                                      => 'Estado backend',
    'Cancel this schedule.'                               => 'Cancelar programación',
    'Cast'                                                => 'Reparto',
    'Category'                                            => 'Categoría',
    'Category Legend'                                     => 'Leyenda Categoría',
    'Category Type'                                       => 'Tipo Categoría',
    'Channel'                                             => 'Canal',
    'Check for duplicates in'                             => 'Buscar duplicados en',
    'Commands'                                            => 'Comandos',
    'Conflicts'                                           => 'Conflictos',
    'Create Schedule'                                     => 'Crear programación',
    'Current Conditions'                                  => 'Condiciones Actuales',
    'Current recordings'                                  => 'Grabaciones actuales',
    'Currently Browsing:  $1'                             => 'Navegando por:  $1',
    'Date'                                                => 'Fecha',
    'Deactivated'                                         => 'Desactivado',
    'Default'                                             => 'Por defecto',
    'Delete'                                              => 'Borrar',
    'Delete $1'                                           => 'Borrar $1',
    'Delete + Rerecord'                                   => 'Borrar y regrabar',
    'Delete and rerecord $1'                              => 'Borrar y regrabar $1',
    'Description'                                         => 'Descripción',
    'Details for'                                         => 'Detalles',
    'Directed by'                                         => 'Dirigido por',
    'Display'                                             => 'Mostrar',
    'Don\'t Record'                                       => 'No grabar',
    'Don\'t record this program.'                         => 'No borrar este programa',
    'Duplicate Check method'                              => 'Método comprobación duplicados',
    'Duplicates'                                          => 'Duplicados',
    'Edit MythWeb and some MythTV settings.'              => 'Editar ajustes de MythWeb y algunos de MythTV',
    'End Late'                                            => 'Terminar más tarde',
    'Episode'                                             => 'Episodio',
    'Exact Match'                                         => 'Coincidencia exacta',
    'Exec. Producer'                                      => 'Productor ejec.',
    'Find other showings of this program'                 => 'Buscar otras emisiones de este programa',
    'Find showings of this program'                       => 'Buscar emisiones de este programa',
    'Forecast'                                            => 'Predicción',
    'Forget Old'                                          => 'Olvidar antiguos',
    'Friday'                                              => 'Viernes',
    'Go'                                                  => 'Ir',
    'Google'                                              => 'Google',
    'Guest Starring'                                      => 'Estrellas invitadas',
    'Guide rating'                                        => '',
    'HD Only'                                             => 'Sólo HD',
    'High'                                                => 'Alto',
    'Hosted by'                                           => '',
    'Hour'                                                => 'Hora',
    'Humidity'                                            => 'Humedad',
    'IMDB'                                                => 'IMDB',
    'Inactive'                                            => 'Inactivo',
    'Jump'                                                => 'Saltar',
    'Jump To'                                             => 'Saltar a',
    'Jump to'                                             => 'Saltar a',
    'Last Updated'                                        => 'Útima Actualización',
    'Length (min)'                                        => 'Duración (min)',
    'Listings'                                            => 'Listados',
    'Low'                                                 => 'Bajo',
    'Manually Schedule'                                   => 'Programar manualmente',
    'Monday'                                              => 'Lunes',
    'Music'                                               => 'Msica',
    'MythMusic on the web.'                               => 'MythMusic en el web',
    'MythVideo on the web.'                               => 'MythVideo en el web',
    'MythWeb Weather.'                                    => 'Tiempo MythWeb',
    'Never Record'                                        => 'Nunca grabar',
    'No'                                                  => 'No',
    'No. of recordings to keep'                           => 'N de grabaciones a guardar',
    'None'                                                => 'Ninguna',
    'Notes'                                               => 'Notas',
    'Only New Episodes'                                   => 'Sólo nuevos episodios',
    'Original Airdate'                                    => 'Emisión original',
    'Please search for something.'                        => 'Busque algo',
    'Presented by'                                        => 'Presentado por',
    'Pressure'                                            => 'Presión',
    'Previous recordings'                                 => 'Grabaciones anteriores',
    'Produced by'                                         => 'Producido por',
    'Program Detail'                                      => 'Detalle programa',
    'Program Listing'                                     => 'Listado Programas',
    'Radar'                                               => 'Radar',
    'Rating'                                              => 'Puntuación',
    'Record This'                                         => 'Grabar',
    'Record new and expire old'                           => 'Grabar nuevos y expirar antiguos',
    'Recorded Programs'                                   => 'Programas grabados',
    'Recording Group'                                     => 'Grupo grabación',
    'Recording Options'                                   => 'Opciones grabación',
    'Recording Priority'                                  => 'Prioridad grabación',
    'Recording Profile'                                   => 'Perfil grabación',
    'Recording Schedules'                                 => 'Programaciones',
    'Rerun'                                               => 'Reejecutar',
    'Saturday'                                            => 'Sáado',
    'Save'                                                => 'Guardar',
    'Schedule'                                            => 'Programar',
    'Schedule Options'                                    => 'Opciones programación',
    'Schedule Override'                                   => 'Excepciones programación',
    'Schedule normally.'                                  => 'Programar normalmente',
    'Scheduled'                                           => 'Programado',
    'Scheduled Recordings'                                => 'Grabaciones programadas',
    'Search'                                              => 'Buscar',
    'Search Results'                                      => 'Resultados bsqueda',
    'Search fields'                                       => 'Campos bsqueda',
    'Search help'                                         => 'Ayuda bsqueda',
    'Search help: movie example'                          => '*** 1/2 Aventura',
    'Search help: movie search'                           => 'buscar película',
    'Search help: regex example'                          => '/^Buenas maneras/',
    'Search help: regex search'                           => 'bsqueda regex',
    'Search options'                                      => 'Opciones bsqueda',
    'Searches'                                            => 'Búsquedas',
    'Settings'                                            => 'Ajustes',
    'Show group'                                          => 'Mostrar grupo',
    'Show recordings'                                     => 'Mostrar grabaciones',
    'Start Date'                                          => 'Fecha comienzo',
    'Start Early'                                         => 'Comenzar antes',
    'Start Time'                                          => 'Hora comienzo',
    'Subtitle'                                            => 'Subtítulo',
    'Subtitle and Description'                            => 'Subtítulo y Descripción',
    'Sunday'                                              => 'Domingo',
    'TV functions, including recorded programs.'          => 'Funciones TV, incluyendo programas grabados',
    'TV.com'                                              => '',
    'The requested recording schedule has been deleted.'  => 'La programación pedida ha sido borrada.',
    'Thursday'                                            => 'Jueves',
    'Time Stretch Default'                                => 'Ajuste de tiempo por defecto',
    'Title'                                               => 'Título',
    'Today'                                               => 'Hoy',
    'Tomorrow'                                            => 'Mañana',
    'Transcoder'                                          => 'Recodificador',
    'Tuesday'                                             => 'Martes',
    'UV Extreme'                                          => 'UV Extremo',
    'UV High'                                             => 'UV Alto',
    'UV Index'                                            => 'Índice UV',
    'UV Minimal'                                          => 'UV mínimo',
    'UV Moderate'                                         => 'UV moderado',
    'Unknown'                                             => 'Desconocido',
    'Unknown Program.'                                    => 'Programa desconocido',
    'Unknown Recording Schedule.'                         => 'Programación desconocida',
    'Upcoming Recordings'                                 => '',
    'Update'                                              => 'Actualizar',
    'Update Recording Settings'                           => 'Actualizar Ajustes Grabación',
    'Visibility'                                          => 'Visibilidad',
    'Weather'                                             => 'Tiempo',
    'Wednesday'                                           => 'Miércoles',
    'What else is on at this time?'                       => 'Qué más hay a esta hora?',
    'Wind'                                                => 'Viento',
    'Wind Chill'                                          => 'Sensación',
    'Written by'                                          => 'Escrito por',
    'Yes'                                                 => 'Sí',
    'airdate'                                             => 'emisión',
    'auto-expire'                                         => 'autoexpirar',
    'channum'                                             => 'nºcanal',
    'description'                                         => 'descripción',
    'file size'                                           => 'tamaño fichero',
    'generic_date'                                        => '%b %e, %Y',
    'generic_time'                                        => '%I:%M %p',
    'has bookmark'                                        => 'tiene marcador',
    'has commflag'                                        => 'anuncios marcados',
    'has cutlist'                                         => 'lista de corte',
    'is editing'                                          => 'es editado',
    'length'                                              => 'duración',
    'minutes'                                             => 'minutos',
    'preview'                                             => 'vista previa',
    'recgroup'                                            => 'grupo',
    'recpriority'                                         => 'prioridad',
    'rectype-long: always'                                => 'rectype-long: siempre',
    'rectype-long: channel'                               => 'rectype-long: canal',
    'rectype-long: daily'                                 => 'rectype-long: diario',
    'rectype-long: dontrec'                               => 'rectype-long: no grabar',
    'rectype-long: finddaily'                             => 'rectype-long: buscar diario',
    'rectype-long: findone'                               => 'rectype-long: buscar uno',
    'rectype-long: findweekly'                            => 'rectype-long: buscar semana',
    'rectype-long: once'                                  => 'rectype-long: una vez',
    'rectype-long: override'                              => 'rectype-long: excepción',
    'rectype-long: weekly'                                => 'rectype-long: semanal',
    'rectype: always'                                     => 'rectype: siempre',
    'rectype: channel'                                    => 'rectype: canal',
    'rectype: daily'                                      => 'rectype: diariamente',
    'rectype: dontrec'                                    => 'rectype: no grabar',
    'rectype: findone'                                    => 'rectype: buscar uno',
    'rectype: once'                                       => 'rectype: una vez',
    'rectype: override'                                   => 'rectype: excepción',
    'rectype: weekly'                                     => 'rectype: semanal',
    'subtitle'                                            => 'subtítulo',
    'title'                                               => 'título',
// includes/programs.php
    'recstatus: cancelled'         => 'estado: cancelado',
    'recstatus: conflict'          => 'estado: conflicto',
    'recstatus: currentrecording'  => 'estado: grabando',
    'recstatus: deleted'           => 'estado: borrado',
    'recstatus: earliershowing'    => 'estado: programa anterior',
    'recstatus: force_record'      => 'estado: forzar grabado',
    'recstatus: inactive'          => '',
    'recstatus: latershowing'      => 'estado: programa despues',
    'recstatus: lowdiskspace'      => 'estado: casi sin espacio',
    'recstatus: manualoverride'    => 'estado: excepción manual',
    'recstatus: neverrecord'       => 'estado: nunca grabar',
    'recstatus: notlisted'         => 'estado: sin listar',
    'recstatus: previousrecording' => 'estado: anterior grabación',
    'recstatus: recorded'          => 'estado: grabado',
    'recstatus: recording'         => 'estado: grabando',
    'recstatus: repeat'            => 'estado: repetir',
    'recstatus: stopped'           => 'estado: parado',
    'recstatus: toomanyrecordings' => 'estado: demasiadas grabaciones',
    'recstatus: tunerbusy'         => 'estado: sintonizador ocupado',
    'recstatus: unknown'           => 'estado: desconocido',
    'recstatus: willrecord'        => 'estado: se grabará',
// includes/recording_schedules.php
    'Dup Method'                   => 'Método duplicado',
    'Profile'                      => 'Perfil',
    'Sub and Desc (Empty matches)' => 'Sub y Desc (Coincidencias vacías)',
    'Type'                         => 'Tipo',
    'rectype: finddaily'           => 'rectype: buscar diario',
    'rectype: findweekly'          => 'rectype: buscar semanal',
// includes/utils.php
    '$1 B'  => '',
    '$1 GB' => '',
    '$1 KB' => '',
    '$1 MB' => '',
    '$1 TB' => '',
// modules/movietimes/init.php
    'Movie Times' => '',
// modules/settings/init.php
    'settings' => '',
// modules/status/init.php
    'Status' => '',
// modules/tv/init.php
    'Search TV'        => '',
    'Special Searches' => '',
    'TV'               => '',
// modules/video/init.php
    'Video' => '',
// themes/.../canned_searches.php
    'handy: overview' => '',
// themes/.../channel_detail.php
    'Length' => 'Duración',
    'Show'   => 'Programa',
    'Time'   => 'Hora',
// themes/.../music.php
    'Album'               => 'Álbum',
    'Album (filtered)'    => 'Álbum (filtrado)',
    'All Music'           => 'Toda la msica',
    'Artist'              => 'Artista',
    'Artist (filtered)'   => 'Artista (filtrado)',
    'Displaying'          => 'Mostrando',
    'Duration'            => 'Duración',
    'End'                 => 'Fin',
    'Filtered'            => 'Filtrado',
    'Genre'               => 'Género',
    'Genre (filtered)'    => 'Género (filtrado)',
    'Next'                => 'Siguiente',
    'No Tracks Available' => 'No hay pistas disponibles',
    'Previous'            => 'Anterior',
    'Top'                 => 'Arriba',
    'Track Name'          => 'Nombre Pista',
    'Unfiltered'          => 'Sin filtrar',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'Grupos de Perfiles',
    'Recording profiles' => 'Perfiles de Grabaci�',
// themes/.../recording_schedules.php
    'Any'                                       => 'Cualquiera',
    'No recording schedules have been defined.' => 'No se han definido programaciones',
    'channel'                                   => 'canal',
    'profile'                                   => 'perfil',
    'transcoder'                                => 'recodificador',
    'type'                                      => 'tipo',
// themes/.../schedule_manually.php
    'Save Schedule'     => 'Guardar programaci�',
    'Schedule Manually' => 'Programar manualmente',
// themes/.../search.php
    'No matches found' => 'Sin resultados',
    'Search for:  $1'  => 'Buscar: $1',
// themes/.../settings.php
    'Channels'           => 'Canales',
    'Configure'          => 'Configurar',
    'Key Bindings'       => 'Controles',
    'MythWeb Settings'   => 'Ajustes MythWeb',
    'settings: overview' => 'Ajustes: general',
// themes/.../settings_channels.php
    'Configure Channels'                                                                                                                 => 'Configurar canales',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => 'Tenga cuidado al alterar esta tabla sin saber lo que hace, puede romper el funcionamiento de MythTV',
    'brightness'                                                                                                                         => 'brillo',
    'callsign'                                                                                                                           => '',
    'colour'                                                                                                                             => 'color',
    'commfree'                                                                                                                           => 'sin anuncios',
    'contrast'                                                                                                                           => 'contraste',
    'delete'                                                                                                                             => 'borrar',
    'finetune'                                                                                                                           => 'sintonía fina',
    'freqid'                                                                                                                             => 'id frecuencia',
    'hue'                                                                                                                                => 'tono',
    'name'                                                                                                                               => 'nombre',
    'sourceid'                                                                                                                           => 'id fuente',
    'useonairguide'                                                                                                                      => '',
    'videofilters'                                                                                                                       => 'filtros vídeo',
    'visible'                                                                                                                            => 'visible',
// themes/.../settings_keys.php
    'Action'                => 'Acción',
    'Configure Keybindings' => 'Configurar Teclas',
    'Context'               => 'Contexto',
    'Destination'           => 'Destino',
    'Edit keybindings on'   => 'Editar Teclas en',
    'JumpPoints Editor'     => 'Editor de Puntos de Salto',
    'Key bindings'          => 'Teclas',
    'Keybindings Editor'    => 'Editor Teclas',
    'Set Host'              => 'Ajustar Host',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'Canal $quot;Saltar a&quot;',
    'Date Formats'                    => 'Formatos Fecha',
    'Guide Settings'                  => 'Ajustes Guía',
    'Hour Format'                     => 'Formato Hora',
    'Language'                        => 'Lengua',
    'Listing &quot;Jump to&quot;'     => 'Listado &quot;Saltar a&quot;',
    'Listing Time Key'                => 'Hora Listado',
    'MythWeb Theme'                   => 'Tema MythWeb',
    'Only display favourite channels' => 'Mostrar sólo canales favoritos',
    'Reset'                           => 'Borrar',
    'SI Units?'                       => 'Unidades SI?',
    'Scheduled Popup'                 => 'Popup Programado',
    'Show descriptions on new line'   => 'Mostrar descripciones en linea nueva',
    'Status Bar'                      => 'Barra estado',
    'Weather Icons'                   => 'Iconos Tiempo',
    'format help'                     => 'ayuda formato',
// themes/.../video.php
    'Edit'          => 'Editar',
    'Reverse Order' => 'Orden Inverso',
    'Videos'        => 'Vídeos',
    'category'      => 'categoría',
    'cover'         => 'carátula',
    'director'      => 'director',
    'imdb rating'   => 'puntuación imdb',
    'plot'          => '',
    'rating'        => 'puntuación',
    'year'          => 'año',
// themes/default/backend_log/welcome.php
    'Show the server logs.' => '',
// themes/default/movietimes/welcome.php
    'Get listings for movies playing at local theatres.' => '',
// themes/default/music/welcome.php
    'Browse your music collection.' => '',
// themes/default/settings/welcome.php
    'Configure MythWeb.' => '',
// themes/default/status/welcome.php
    'Show the backend status page.' => '',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/welcome.php
    'See what\'s on tv, schedule recordings and manage shows that you\'ve already recorded.  Please see the following choices:' => '',
// themes/default/video/welcome.php
    'Browse your video collection.' => '',
// themes/default/weather/welcome.php
    'Get the local weather forecast.' => ''
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
$Categories['Action']         = array('Acci&oacute;n',            '\\b(?:action|adven)');
$Categories['Adult']          = array('Adultos',                  '\\b(?:adult|erot)');
$Categories['Animals']        = array('Animales',                 '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Arte / M&uacute;sica',     '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)');
$Categories['Business']       = array('Profesional',              '\\b(?:biz|busine)');
$Categories['Children']       = array('Infantil',                 '\\b(?:child|kin?d|infan|animation)');
$Categories['Comedy']         = array('Comedia',                  '\\b(?:comed|entertain|sitcom)');
$Categories['Crime_Mystery']  = array('Misterio / Cr&iacute;men', '\\b(?:[ck]rim|myster)');
$Categories['Documentary']    = array('Documental',               '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',                    '\\b(?:drama)');
$Categories['Educational']    = array('Educativo',                '\\b(?:edu|interests)');
$Categories['Food']           = array('Alimentaci&oacute;n',      '\\b(?:food|cook|comida)');
$Categories['Game']           = array('Juegos',                   '\\b(?:game|spiele)');
$Categories['Health_Medical'] = array('Salud / Medicina',         '\\b(?:health|medic)');
$Categories['History']        = array('Historia',                 '\\b(?:hist)');
$Categories['Horror']         = array('Terror',                   '\\b(?:horror)');
$Categories['HowTo']          = array('C&oacute;mo...',           '\\b(?:how|home|house|garden)');
$Categories['Misc']           = array('Varios',                   '\\b(?:special|variedad|info|collect)');
$Categories['News']           = array('Noticias',                 '\\b(?:news|noticias)');
$Categories['Reality']        = array('Reality Shows',            '\\b(?:reality)');
$Categories['Romance']        = array('Romance',                  '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Ciencias Naturales',       '\\b(?:sciencia|natur)');
$Categories['Science_Nature'] = array('Ciencia Ficci&oacute;n',   '\\b(?:fantasy|sci\\w*\\W*fi)');
$Categories['Shopping']       = array('Compras',                  '\\b(?:shop)');
$Categories['Soaps']          = array('Soaps?',                   '\\b(?:soaps)');
$Categories['Spiritual']      = array('Espiritual',               '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Deportes',                 '\\b(?:sport|deportes|futbol)');
$Categories['Talk']           = array('Debates',                  '\\b(?:talk)');
$Categories['Travel']         = array('Viajar',                   '\\b(?:travel|reisen)');
$Categories['War']            = array('Guerras',                  '\\b(?:war|guerra)');
$Categories['Western']        = array('Western',                  '\\b(?:west)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Desconocido');
$Categories['movie']          = array('Pel&iacute;culas'  );

