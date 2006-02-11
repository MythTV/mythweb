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
    '$1 Search'                                          => 'Búsqueda $1',
    '$1 hr'                                              => '$1 hr',
    '$1 hrs'                                             => '$1 hrs',
    '$1 min'                                             => '$1 min',
    '$1 mins'                                            => '$1 mins',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1 programas, usando $2 ($3) de $4 ($5 libre))',
    '$1 to $2'                                           => '$1 a $2',
    'Activate'                                           => 'Activar',
    'Advanced Options'                                   => 'Opciones Avanzadas',
    'Airtime'                                            => 'Horario',
    'All recordings'                                     => 'Todas las grabaciones',
    'Auto-expire recordings'                             => 'Autoexpirar grabaciones',
    'Auto-flag commercials'                              => 'Automarcar anuncios',
    'Auto-transcode'                                     => 'Auto-recodificar',
    'Backend Logs'                                       => 'Logs Backend',
    'Backend Status'                                     => 'Estado backend',
    'Cancel this schedule.'                              => 'Cancelar programación',
    'Category'                                           => 'Categoría',
    'Check for duplicates in'                            => 'Buscar duplicados en',
    'Create Schedule'                                    => 'Crear programación',
    'Current recordings'                                 => 'Grabaciones actuales',
    'Currently Browsing:  $1'                            => 'Navegando por:  $1',
    'Custom Schedule'                                    => 'Programación Avanzada',
    'Date'                                               => 'Fecha',
    'Default'                                            => 'Por defecto',
    'Description'                                        => 'Descripción',
    'Details for'                                        => 'Detalles',
    'Display'                                            => 'Mostrar',
    'Don\'t Record'                                      => 'No grabar',
    'Duplicate Check method'                             => 'Método comprobación duplicados',
    'End Late'                                           => 'Terminar más tarde',
    'Episode'                                            => 'Episodio',
    'Forget Old'                                         => 'Olvidar antiguos',
    'Friday'                                             => 'Viernes',
    'Hour'                                               => 'Hora',
    'IMDB'                                               => 'IMDB',
    'Inactive'                                           => 'Inactivo',
    'Jump'                                               => 'Saltar',
    'Jump to'                                            => 'Saltar a',
    'Keyword'                                            => 'Palabra clave',
    'Listings'                                           => 'Listados',
    'Monday'                                             => 'Lunes',
    'Music'                                              => 'Música',
    'Never Record'                                       => 'Nunca grabar',
    'No'                                                 => 'No',
    'No. of recordings to keep'                          => 'Nº de grabaciones a guardar',
    'None'                                               => 'Ninguna',
    'Only New Episodes'                                  => 'Sólo nuevos episodios',
    'Original Airdate'                                   => 'Emisión original',
    'People'                                             => 'Gente',
    'Power'                                              => 'Avanzada',
    'Previous recordings'                                => 'Grabaciones anteriores',
    'Program Listing'                                    => 'Listado Programas',
    'Rating'                                             => 'Puntuación',
    'Record This'                                        => 'Grabar',
    'Record new and expire old'                          => 'Grabar nuevos y expirar antiguos',
    'Recorded Programs'                                  => 'Programas grabados',
    'Recording Group'                                    => 'Grupo grabación',
    'Recording Options'                                  => 'Opciones grabación',
    'Recording Priority'                                 => 'Prioridad grabación',
    'Recording Profile'                                  => 'Perfil grabación',
    'Recording Schedules'                                => 'Programaciones',
    'Repeat'                                             => 'Reejecutar',
    'Saturday'                                           => 'Sábado',
    'Save'                                               => 'Guardar',
    'Save Schedule'                                      => 'Guardar programación',
    'Schedule'                                           => 'Programar',
    'Schedule Manually'                                  => 'Programar manualmente',
    'Schedule Options'                                   => 'Opciones programación',
    'Schedule Override'                                  => 'Excepciones programación',
    'Schedule normally.'                                 => 'Programar normalmente',
    'Search'                                             => 'Buscar',
    'Search Results'                                     => 'Resultados bsqueda',
    'Settings'                                           => 'Ajustes',
    'Start Early'                                        => 'Comenzar antes',
    'Subtitle'                                           => 'Subtítulo',
    'Subtitle and Description'                           => 'Subtítulo y Descripción',
    'Sunday'                                             => 'Domingo',
    'The requested recording schedule has been deleted.' => 'La programación pedida ha sido borrada.',
    'Thursday'                                           => 'Jueves',
    'Title'                                              => 'Título',
    'Transcoder'                                         => 'Recodificador',
    'Tuesday'                                            => 'Martes',
    'Type'                                               => 'Tipo',
    'Unknown'                                            => 'Desconocido',
    'Upcoming Recordings'                                => 'Grabaciones Próximas',
    'Update'                                             => 'Actualizar',
    'Update Recording Settings'                          => 'Actualizar Ajustes Grabación',
    'Weather'                                            => 'Tiempo',
    'Wednesday'                                          => 'Miércoles',
    'Yes'                                                => 'Sí',
    'airdate'                                            => 'emisión',
    'channum'                                            => 'nºcanal',
    'description'                                        => 'descripción',
    'generic_date'                                       => '%b %e, %Y',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => 'duración',
    'minutes'                                            => 'minutos',
    'recgroup'                                           => 'grupo',
    'recpriority'                                        => 'prioridad',
    'rectype-long: always'                               => 'rectype-long: siempre',
    'rectype-long: channel'                              => 'rectype-long: canal',
    'rectype-long: daily'                                => 'rectype-long: diario',
    'rectype-long: dontrec'                              => 'rectype-long: no grabar',
    'rectype-long: finddaily'                            => 'rectype-long: buscar diario',
    'rectype-long: findone'                              => 'rectype-long: buscar uno',
    'rectype-long: findweekly'                           => 'rectype-long: buscar semana',
    'rectype-long: once'                                 => 'rectype-long: una vez',
    'rectype-long: override'                             => 'rectype-long: excepción',
    'rectype-long: weekly'                               => 'rectype-long: semanal',
    'rectype: always'                                    => 'rectype: siempre',
    'rectype: channel'                                   => 'rectype: canal',
    'rectype: daily'                                     => 'rectype: diariamente',
    'rectype: dontrec'                                   => 'rectype: no grabar',
    'rectype: findone'                                   => 'rectype: buscar uno',
    'rectype: once'                                      => 'rectype: una vez',
    'rectype: override'                                  => 'rectype: excepción',
    'rectype: weekly'                                    => 'rectype: semanal',
    'subtitle'                                           => 'subtítulo',
    'title'                                              => 'título',
// config/canned_searches.php
    'All HDTV'                           => 'Todas HDTV',
    'Movies'                             => 'Películas',
    'Movies, 3&frac12; Stars or more'    => 'Películas, 3&frac12; estrellas o más',
    'Movies, Stinkers (2 Stars or less)' => 'Películas, 2 estrellas o menos',
    'Music Specials'                     => 'Especiales Música',
    'New Titles, Premieres'              => 'Nuevos Títulos, Estrenos',
    'Non-Music Specials'                 => 'Especiales No-Música',
    'Non-Series HDTV'                    => 'No series en HDTV',
    'Science Fiction Movies'             => 'Películas Ciencia Ficción',
// includes/programs.php
    'CC'                           => '',
    'HDTV'                         => 'HDTV',
    'Notes'                        => 'Notas',
    'Part $1 of $2'                => 'Parte $1 de $2',
    'Stereo'                       => 'Estéreo',
    'Subtitled'                    => 'Subtitulado',
    'recstatus: cancelled'         => 'estado: cancelado',
    'recstatus: conflict'          => 'estado: conflicto',
    'recstatus: currentrecording'  => 'estado: grabando',
    'recstatus: deleted'           => 'estado: borrado',
    'recstatus: earliershowing'    => 'estado: programa anterior',
    'recstatus: force_record'      => 'estado: forzar grabado',
    'recstatus: inactive'          => 'estado: inactivo',
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
    'rectype: finddaily'           => 'rectype: buscar diario',
    'rectype: findweekly'          => 'rectype: buscar semanal',
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
    'MythTV channel info'      => 'Info Canal MythTV',
    'MythTV key bindings'      => 'Vínculos Teclas MythTV',
    'MythWeb session settings' => 'Ajustes sesiones MythWeb',
    'settings'                 => 'ajustes',
// modules/status/init.php
    'Status' => 'Estado',
// modules/stream/init.php
    'Streaming' => 'Transmitiendo',
// modules/tv/detail.php
    'This program is already scheduled to be recorded via a $1custom search$2.' => 'Este programa ya está programado para ser grabado mediante una $1búsqueda avanzada$2',
    'Unknown Program.'                                                          => 'Programa desconocido',
    'Unknown Recording Schedule.'                                               => 'Programación desconocida',
// modules/tv/init.php
    'Special Searches' => 'Búsquedas especiales',
    'TV'               => 'TV',
// modules/tv/recorded.php
    'No matching programs found.'             => 'No hay programas coincidentes',
    'Showing all programs from the $1 group.' => 'Mostrando todos los programas del grupo $1',
    'Showing all programs.'                   => 'Mostrando todos los programas',
// modules/tv/schedules_custom.php
    'Any Category'                               => 'Cualquier Categoría',
    'Any Channel'                                => 'Cualquier Canal',
    'Any Program Type'                           => 'Cualquier Tipo de Programa',
    'Find Time must be of the format:  HH:MM:SS' => 'Hora Búsqueda debe tener el formato: HH:MM:SS',
// modules/tv/schedules_manual.php
    'Use callsign'  => 'Usar nombre canal',
    'Use date/time' => 'Usar fecha/hora',
// modules/tv/search.php
    'Please search for something.' => 'Busque algo',
// modules/video/init.php
    'Video' => 'Vídeo',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => 'bienvenido: log backend',
// themes/default/header.php
    'Category Legend'                            => 'Leyenda Categoría',
    'Category Type'                              => 'Tipo Categoría',
    'Custom'                                     => 'Avanzada',
    'Edit MythWeb and some MythTV settings.'     => 'Editar ajustes de MythWeb y algunos de MythTV',
    'Exact Match'                                => 'Coincidencia exacta',
    'Fold Duplicates'                            => '',
    'HD Only'                                    => 'Sólo HD',
    'Manual'                                     => 'Manual',
    'MythMusic on the web.'                      => 'MythMusic en el web',
    'MythVideo on the web.'                      => 'MythVideo en el web',
    'MythWeb Weather.'                           => 'Tiempo MythWeb',
    'Search fields'                              => 'Campos búsqueda',
    'Search help'                                => 'Ayuda búsqueda',
    'Search help: movie example'                 => '*** 1/2 Aventura',
    'Search help: movie search'                  => 'buscar película',
    'Search help: regex example'                 => '/^Buenas maneras/',
    'Search help: regex search'                  => 'búsqueda regex',
    'Search options'                             => 'Opciones búsqueda',
    'Searches'                                   => 'Búsquedas',
    'TV functions, including recorded programs.' => 'Funciones TV, incluyendo programas grabados',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => 'bienvenido: movietimes',
// themes/default/music/music.php
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
// themes/default/music/welcome.php
    'welcome: music' => 'bienvenido: música',
// themes/default/settings/channels.php
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
    'useonairguide'                                                                                                                      => 'usar guía emitida',
    'videofilters'                                                                                                                       => 'filtros vídeo',
    'visible'                                                                                                                            => 'visible',
    'xmltvid'                                                                                                                            => '',
// themes/default/settings/keys.php
    'Action'                => 'Acción',
    'Configure Keybindings' => 'Configurar Teclas',
    'Context'               => 'Contexto',
    'Destination'           => 'Destino',
    'Edit keybindings on'   => 'Editar Teclas en',
    'JumpPoints Editor'     => 'Editor de Puntos de Salto',
    'Key bindings'          => 'Teclas',
    'Keybindings Editor'    => 'Editor Teclas',
    'Set Host'              => 'Ajustar Host',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'Canal &quot;Saltar a&quot;',
    'Date Formats'                    => 'Formatos Fecha',
    'Guide Settings'                  => 'Ajustes Guía',
    'Hour Format'                     => 'Formato Hora',
    'Language'                        => 'Lengua',
    'Listing &quot;Jump to&quot;'     => 'Listado &quot;Saltar a&quot;',
    'Listing Time Key'                => 'Hora Listado',
    'MythWeb Session Settings'        => 'Ajustes sesiones MythWeb',
    'MythWeb Theme'                   => 'Tema MythWeb',
    'Only display favourite channels' => 'Mostrar sólo canales favoritos',
    'Reset'                           => 'Borrar',
    'SI Units?'                       => '¿Unidades SI?',
    'Scheduled Popup'                 => 'Popup Programado',
    'Show descriptions on new line'   => 'Mostrar descripciones en linea nueva',
    'Status Bar'                      => 'Barra estado',
    'Weather Icons'                   => 'Iconos Tiempo',
    'format help'                     => 'ayuda formato',
// themes/default/settings/settings.php
    'settings: overview' => 'Ajustes: general',
// themes/default/settings/welcome.php
    'welcome: settings' => 'bienvenido: ajustes',
// themes/default/status/welcome.php
    'welcome: status' => 'bienvenido: estado',
// themes/default/tv/channel.php
    'Channel Detail' => 'Detalle Canal',
    'Length'         => 'Duración',
    'Show'           => 'Programa',
    'Time'           => 'Hora',
// themes/default/tv/detail.php
    'Back to the program listing'         => 'Volver al listado de programas',
    'Back to the recording schedules'     => 'Volver a la programación',
    'Cast'                                => 'Reparto',
    'Directed by'                         => 'Dirigido por',
    'Don\'t record this program.'         => 'No borrar este programa',
    'Episode Number'                      => 'Nº Episodio',
    'Exec. Producer'                      => 'Productor ejec.',
    'Find other showings of this program' => 'Buscar otras emisiones de este programa',
    'Find showings of this program'       => 'Buscar emisiones de este programa',
    'Google'                              => 'Google',
    'Guest Starring'                      => 'Estrellas invitadas',
    'Guide rating'                        => 'Puntuación Guía',
    'Hosted by'                           => '',
    'MythTV Status'                       => 'Estado MythTV',
    'Possible conflicts with this show'   => 'Posibles conflictos con este programa',
    'Presented by'                        => 'Presentado por',
    'Produced by'                         => 'Producido por',
    'Program Detail'                      => 'Detalle programa',
    'Program ID'                          => 'ID programa',
    'TV.com'                              => '',
    'Time Stretch Default'                => 'Ajuste de tiempo por defecto',
    'What else is on at this time?'       => 'Qué más hay a esta hora?',
    'Written by'                          => 'Escrito por',
// themes/default/tv/list.php
    'Jump To' => 'Saltar a',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => 'SIN DATOS',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1 episodio',
    '$1 episodes'                                         => '$1 episodios',
    '$1 recording'                                        => '$1 grabación',
    '$1 recordings'                                       => '$1 grabaciones',
    'All groups'                                          => 'Todos los grupos',
    'Are you sure you want to delete the following show?' => '¿Está seguro de borrar el siguiente programa?',
    'Delete'                                              => 'Borrar',
    'Delete $1'                                           => 'Borrar $1',
    'Delete + Rerecord'                                   => 'Borrar y regrabar',
    'Delete and rerecord $1'                              => 'Borrar y regrabar $1',
    'Go'                                                  => 'Ir',
    'Show group'                                          => 'Mostrar grupo',
    'Show recordings'                                     => 'Mostrar grabaciones',
    'auto-expire'                                         => 'autoexpirar',
    'file size'                                           => 'tamaño fichero',
    'has bookmark'                                        => 'tiene marcador',
    'has commflag'                                        => 'anuncios marcados',
    'has cutlist'                                         => 'lista de corte',
    'is editing'                                          => 'es editado',
    'preview'                                             => 'vista previa',
// themes/default/tv/schedules.php
    'Any'                                       => 'Cualquiera',
    'No recording schedules have been defined.' => 'No se han definido programaciones',
    'channel'                                   => 'canal',
    'profile'                                   => 'perfil',
    'transcoder'                                => 'recodificador',
    'type'                                      => 'tipo',
// themes/default/tv/schedules_custom.php
    'Additional Tables'        => 'Tablas adicionales',
    'Find Date & Time Options' => 'Opciones Búsqueda Fecha y Hora',
    'Find Day'                 => 'Buscar Día',
    'Find Time'                => 'Buscar Hora',
    'Keyword Search'           => 'Búsqueda palabras',
    'People Search'            => 'Búsqueda gente',
    'Power Search'             => 'Búsqueda avanzada',
    'Search Phrase'            => 'Buscar frase',
    'Search Type'              => 'Buscar tipo',
    'Title Search'             => 'Buscar título',
// themes/default/tv/schedules_manual.php
    'Channel'      => 'Canal',
    'Length (min)' => 'Duración (min)',
    'Start Date'   => 'Fecha comienzo',
    'Start Time'   => 'Hora comienzo',
// themes/default/tv/search.php
    'No matches found'                 => 'Sin resultados',
    'No matching programs were found.' => 'No se han encontrado programas coincidentes',
    'Search for:  $1'                  => 'Buscar: $1',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => 'Búsquedas Predefinidas Útiles',
    'handy: overview'           => 'útiles: resúmen',
// themes/default/tv/upcoming.php
    'Commands'    => 'Comandos',
    'Conflicts'   => 'Conflictos',
    'Deactivated' => 'Desactivado',
    'Duplicates'  => 'Duplicados',
    'Scheduled'   => 'Programado',
// themes/default/tv/welcome.php
    'welcome: tv' => 'bienvenido: tv',
// themes/default/video/video.php
    'Edit'          => 'Editar',
    'Reverse Order' => 'Orden Inverso',
    'Videos'        => 'Vídeos',
    'category'      => 'categoría',
    'cover'         => 'carátula',
    'director'      => 'director',
    'imdb rating'   => 'puntuación imdb',
    'plot'          => 'resúmen',
    'rating'        => 'puntuación',
    'year'          => 'año',
// themes/default/video/welcome.php
    'welcome: video' => 'bienvenido: video',
// themes/default/weather/weather.php
    ' at '               => ' a ',
    'Current Conditions' => 'Condiciones Actuales',
    'Forecast'           => 'Predicción',
    'High'               => 'Alto',
    'Humidity'           => 'Humedad',
    'Last Updated'       => 'Útima Actualización',
    'Low'                => 'Bajo',
    'Pressure'           => 'Presión',
    'Radar'              => 'Radar',
    'Today'              => 'Hoy',
    'Tomorrow'           => 'Mañana',
    'UV Extreme'         => 'UV Extremo',
    'UV High'            => 'UV Alto',
    'UV Index'           => 'Índice UV',
    'UV Minimal'         => 'UV mínimo',
    'UV Moderate'        => 'UV moderado',
    'Visibility'         => 'Visibilidad',
    'Wind'               => 'Viento',
    'Wind Chill'         => 'Sensación',
// themes/default/weather/welcome.php
    'welcome: weather' => 'bienvenido: el tiempo',
// themes/default/welcome.php
    'Visit $1' => 'Visite $1'
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
$Categories['Action']         = array('Acción',            '\\b(?:action|adven)');
$Categories['Adult']          = array('Adultos',                  '\\b(?:adult|erot)');
$Categories['Animals']        = array('Animales',                 '\\b(?:animal|tiere)');
$Categories['Art_Music']      = array('Arte / Música',     '\\b(?:art|dance|musi[ck]|kunst|[ck]ultur)');
$Categories['Business']       = array('Profesional',              '\\b(?:biz|busine|negoc|econ)');
$Categories['Children']       = array('Infantil',                 '\\b(?:child|kin?d|infan|animation|niñ)');
$Categories['Comedy']         = array('Comedia',                  '\\b(?:comed|entertain|sitcom|humor)');
$Categories['Crime_Mystery']  = array('Misterio / Crímen', '\\b(?:[ck]rim|m[yi]ster)');
$Categories['Documentary']    = array('Documental',               '\\b(?:do[ck])');
$Categories['Drama']          = array('Drama',                    '\\b(?:drama)');
$Categories['Educational']    = array('Educativo',                '\\b(?:edu|interests)');
$Categories['Food']           = array('Alimentación',      '\\b(?:food|cook|comida)');
$Categories['Game']           = array('Juegos',                   '\\b(?:game|spiele|juego)');
$Categories['Health_Medical'] = array('Salud / Medicina',         '\\b(?:health|medic|salud)');
$Categories['History']        = array('Historia',                 '\\b(?:hist)');
$Categories['Horror']         = array('Terror',                   '\\b(?:horror|terror)');
$Categories['HowTo']          = array('Cómo...',           '\\b(?:how|home|house|garden|como|casa|jardin)');
$Categories['Misc']           = array('Varios',                   '\\b(?:[e]special|variedad|info|collect)');
$Categories['News']           = array('Noticias',                 '\\b(?:news|noticias)');
$Categories['Reality']        = array('Reality Shows',            '\\b(?:reality)');
$Categories['Romance']        = array('Romance',                  '\\b(?:romance|lieb)');
$Categories['SciFi_Fantasy']  = array('Ciencias Naturales',       '\\b(?:sciencia|natur|ciencia)');
$Categories['Science_Nature'] = array('Ciencia Ficción',   '\\b(?:fantasy|sci\\w*\\W*fi|fantasia)');
$Categories['Shopping']       = array('Compras',                  '\\b(?:shop|tienda)');
$Categories['Soaps']          = array('Soaps?',                   '\\b(?:soaps)');
$Categories['Spiritual']      = array('Espiritual',               '\\b(?:spirit|relig)');
$Categories['Sports']         = array('Deportes',                 '\\b(?:sport|deportes|futbol)');
$Categories['Talk']           = array('Debates',                  '\\b(?:talk|debate)');
$Categories['Travel']         = array('Viajar',                   '\\b(?:travel|reisen|viaj)');
$Categories['War']            = array('Guerras',                  '\\b(?:war|guerra)');
$Categories['Western']        = array('Western',                  '\\b(?:west|oeste)');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('Desconocido');
$Categories['movie']          = array('Películas'  );

