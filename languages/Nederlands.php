<?php
/***                                                                        ***\
    languages/Nederlands.php

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
    'Category'         => '',
    'Description'      => '',
    'Original Airdate' => '',
    'Rerun'            => '',
    'Search'           => '',
    'Subtitle'         => '',
    'Unknown'          => '',
// includes/init.php
    'generic_date' => '%b %e, %Y',
    'generic_time' => '%H:%M',
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
    'advanced'             => '',
// themes/.../weather.php
    ' at '               => '',
    'Current Conditions' => '',
    'Forecast'           => '',
    'Friday'             => '',
    'High'               => '',
    'Humidity'           => '',
    'Last Updated'       => '',
    'Low'                => '',
    'Monday'             => '',
    'Pressure'           => '',
    'Radar'              => '',
    'Saturday'           => '',
    'Sunday'             => '',
    'Thursday'           => '',
    'Today'              => '',
    'Tomorrow'           => '',
    'Tuesday'            => '',
    'UV Extreme'         => '',
    'UV High'            => '',
    'UV Index'           => '',
    'UV Minimal'         => '',
    'UV Moderate'        => '',
    'Visibility'         => '',
    'Wednesday'          => '',
    'Wind'               => '',
    'Wind Chill'         => ''
// End of the translation hash ** Do not touch the next line
          );


/* theme.php */
define ('_LANG_BACKEND_STATUS',				'Systeemstatus');
define ('_LANG_SETTINGS',       			'Instellingen');
define ('_LANG_LISTINGS',       			'Programmagids');
define ('_LANG_FAVOURITES',         			'Voorkeuren');
define ('_LANG_SCHEDULED_RECORDINGS',   		'Geplande Opnames');
define ('_LANG_RECORDING_SCHEDULES',    		'Opname Schema');
define ('_LANG_RECORDED_PROGRAMS',  			'Opnames');
define ('_LANG_MANUALLY_SCHEDULE',    			'Handmatige Opname');
define ('_LANG_CATEGORY_LEGEND',    			'Categorie Legenda');
define ('_LANG_ACTION',               			'Actie');
define ('_LANG_ADULT',                			'Erotisch');
define ('_LANG_ANIMALS',              			'Dieren');
define ('_LANG_ART_MUSIC',            			'Kunst_Muziek');
define ('_LANG_BUSINESS',             			'Zakelijk');
define ('_LANG_CHILDREN',             			'Kinderen');
define ('_LANG_COMEDY',               			'Komisch');
define ('_LANG_CRIME_MYSTERY',        			'Misdaad_Crimi');
define ('_LANG_DOCUMENTARY',          			'Documentaire');
define ('_LANG_DRAMA',                			'Drama');
define ('_LANG_EDUCATIONAL',          			'Educatie');
define ('_LANG_FOOD',                 			'Eten');
define ('_LANG_GAME',                 			'Spel');
define ('_LANG_HEALTH_MEDICAL',       			'Gezondheid_Medisch');
define ('_LANG_HISTORY',              			'Geschiedenis');
define ('_LANG_HOWTO',                			'Hulp');
define ('_LANG_HORROR',               			'Horror');
define ('_LANG_MISC',                 			'Divers');
define ('_LANG_NEWS',                 			'Nieuws');
define ('_LANG_REALITY',              			'Reality');
define ('_LANG_ROMANCE',              			'Romantiek');
define ('_LANG_SCIENCE_NATURE',       			'Wetenschap_Natuur');
define ('_LANG_SCIFI_FANTASY',        			'SciFi_Fantasy');
define ('_LANG_SHOPPING',             			'Shopping');
define ('_LANG_SOAPS',                			'Soaps');
define ('_LANG_SPIRITUAL',            			'Religie');
define ('_LANG_SPORTS',               			'Sport');
define ('_LANG_TALK',                 			'Praat');
define ('_LANG_TRAVEL',               			'Reis');
define ('_LANG_WAR',                  			'Oorlog');
define ('_LANG_WESTERN',              			'Films');
define ('_LANG_MOVIES',               			'Films');
define ('_LANG_UNKNOWN',              			'Onbekend');
define ('_CATMATCH_ACTION',               		'\\b(?:action|avon|actie)');
define ('_CATMATCH_ADULT',                		'\\b(?:adult|erot|sex)');
define ('_CATMATCH_ANIMALS',              		'\\b(?:animal|dier)');
define ('_CATMATCH_ART_MUSIC',            		'\\b(?:art|kunst|dans|musi[ck]|muziek|kunst|[ck]ultur)');
define ('_CATMATCH_BUSINESS',             		'\\b(?:biz|busine|zake)');
define ('_CATMATCH_CHILDREN',             		'\\b(?:child|jeugd|animatie|kin?d|infan)');
define ('_CATMATCH_COMEDY',               		'\\b(?:comed|entertain|sitcom|serie)');
define ('_CATMATCH_CRIME_MYSTERY',        		'\\b(?:[ck]rim|myster|misdaad)');
define ('_CATMATCH_DOCUMENTARY',          		'\\b(?:informatief|docu)');
define ('_CATMATCH_DRAMA',                		'\\b(?:drama)');
define ('_CATMATCH_EDUCATIONAL',          		'\\b(?:edu|interes)');
define ('_CATMATCH_FOOD',                 		'\\b(?:food|cook|[dt]rink|kook|eten|kok)');
define ('_CATMATCH_GAME',                 		'\\b(?:game|spel|quiz)');
define ('_CATMATCH_HEALTH_MEDICAL',       		'\\b(?:medisch|gezond)');
define ('_CATMATCH_HISTORY',              		'\\b(?:hist|geschied)');
define ('_CATMATCH_HOWTO',                		'\\b(?:how|home|house|garden|huis|tuin|woning)');
define ('_CATMATCH_HORROR',               		'\\b(?:horror)');
define ('_CATMATCH_MISC',                 		'\\b(?:special|variety|info|collect)');
define ('_CATMATCH_NEWS',                 		'\\b(?:news|current|nieuws|duiding|actua)');
define ('_CATMATCH_REALITY',              		'\\b(?:reality|leven)');
define ('_CATMATCH_ROMANCE',              		'\\b(?:romance|lief)');
define ('_CATMATCH_SCIENCE_NATURE',       		'\\b(?:fantasy|sci\\w*\\W*fi|natuur|wetenschap)');
define ('_CATMATCH_SCIFI_FANTASY',        		'\\b(?:science|natuur|environment|wetenschap)');
define ('_CATMATCH_SHOPPING',             		'\\b(?:shop|koop)');
define ('_CATMATCH_SOAPS',                		'\\b(?:soap)');
define ('_CATMATCH_SPIRITUAL',            		'\\b(?:spirit|relig)');
define ('_CATMATCH_SPORTS',               		'\\b(?:sport|deportes|voetbal|tennis)');
define ('_CATMATCH_TALK',                 		'\\b(?:talk|praat)');
define ('_CATMATCH_TRAVEL',               		'\\b(?:travel|reis)');
define ('_CATMATCH_WAR',                  		'\\b(?:war|oorlog)');
define ('_CATMATCH_WESTERN',              		'\\b(?:west|film)');
define ('_CATMATCH_MOVIES',               		'\\b(?:film|movie)');

/* settings.php */
define ('_LANG_SETTINGS_HEADER1',			'Dit is de indexpagina voor de configuratie-instellingen...');
define ('_LANG_SETTINGS_HEADER2', 			'Hier moeten nog mooie plaatjes komen die naar de verschillende secties verwijzen, maar voorlopig hebben we dit:');
define ('_LANG_CHANNELS',           			'Kanalen');
define ('_LANG_THEME',              			'Thema');
define ('_LANG_LANGUAGE',           			'Taal');
define ('_LANG_DATEFORMATS',            		'Datum/Datum Formaat');
define ('_LANG_KEY_BINDINGS',           		'Toetsbindingen');
define ('_LANG_CONFIGURE',          			'Instellen');
define ('_LANG_GO_TO',              			'Ga Naar');
define ('_LANG_ADVANCED',           			'Geavanceerd');
define ('_LANG_FORMAT_HELP',            		'Formaat help');
define ('_LANG_STATUS_BAR',             		'Status Balk');
define ('_LANG_SCHEDULED_RECORDINGS',       		'Geplande Opnames');
define ('_LANG_SCHEDULED_POPUP',        		'Geplande Popup');
define ('_LANG_RECORDED_PROGRAMS',      		'Opgenomen Programmas');
define ('_LANG_SEARCH_RESULTS',         		'Zoek Resultaten');
define ('_LANG_LISTING_TIME_KEY',       		'Gids Tijd Toets');
define ('_LANG_LISTING_JUMP_TO',        		'Gids &quot;Spring naar&quot;');
define ('_LANG_CHANNEL_JUMP_TO',        		'Zender &quot;Spring naar&quot;');
define ('_LANG_HOUR_FORMAT',            		'Tijdweergave');
define ('_LANG_RESET',              			'Annuleren');
define ('_LANG_SAVE',               			'Opslaan');
define ('_LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE',  	'Programmabeschrijving op nieuwe regel?');

/* program_listings.php */
define ('_LANG_CURRENTLY_BROWSING',     		'Tijdstip:');
define ('_LANG_JUMP_TO',        			'Spring&nbsp;naar');
define ('_LANG_HOUR',           			'Uur');
define ('_LANG_DATE',           			'Datum');
define ('_LANG_JUMP',           			'Ga Naar');

/* program_detail.php */
define ('_LANG_SEARCH',                         	'Zoek');
define ('_LANG_IMDB',                           	'IMDB');
define ('_LANG_GOOGLE',                         	'Google');
define ('_LANG_TVTOME',                         	'TVTome');
define ('_LANG_MINUTES',                         	'minuten');
define ('_LANG_TO',                             	'tot');
define ('_LANG_CATEGORY',                         	'Categorie');
define ('_LANG_ORIG_AIRDATE',                  		'Oorspronkelijke Uitzenddatum');
define ('_LANG_AIRDATE',                        	'Uitgezonden');
define ('_LANG_RECORDING_OPTIONS',              	'Opname Opties');
define ('_LANG_DONT_RECORD_THIS_PROGRAM',       	'Niet opnemen.');
define ('_LANG_CANCEL_THIS_SCHEDULE',           	'Deze vertoning niet opnemen.');
define ('_LANG_RECORDING_PROFILE',              	'Opname Profiel');
define ('_LANG_RECPRIORITY',                    	'Opnameprioriteit');
define ('_LANG_CHECK_FOR_DUPLICATES_IN',        	'Kijk voor dubbele opnames in');
define ('_LANG_CURRENT_RECORDINGS',             	'Huidige Opnames');
define ('_LANG_PREVIOUS_RECORDINGS',            	'Oude Opnames');
define ('_LANG_ALL_RECORDINGS',                 	'Alle Opnames');
define ('_LANG_DUPLICATE_CHECK_METHOD',         	'Manier om dubbele opnames te zoeken');
define ('_LANG_NONE',                           	'Geen');
define ('_LANG_SUBTITLE',                       	'Subtitel');
define ('_LANG_DESCRIPTION',                    	'Beschrijving');
define ('_LANG_SUBTITLE_AND_DESCRIPTION',       	'Subtitel & Beschrijving');
define ('_LANG_SUB_AND_DESC',                   	'Sub & Besch (Leeg)');
define ('_LANG_AUTO_EXPIRE_RECORDINGS',         	'Automatisch laten vervallen?');
define ('_LANG_NO_OF_RECORDINGS_TO_KEEP',       	'Aantal opnames om te bewaren?');
define ('_LANG_RECORD_NEW_AND_EXPIRE_OLD',      	'Nieuwe opnemen en oude laten vervallen?');
define ('_LANG_START_EARLY',                    	'Begin vroeger (minuten)');
define ('_LANG_END_LATE',                       	'Stop later (minuten)');
define ('_LANG_UPDATE_RECORDING_SETTINGS',      	'Bewaar opname instellingen');
define ('_LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME',   	'Wat wordt er nog uitgezonden op dit moment?');
define ('_LANG_BACK_TO_THE_PROGRAM_LISTING',    	'Terug naar de programmagids!');
define ('_LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM',	'Zoek heruitzendingen van dit programma');
define ('_LANG_BACK_TO_RECORDING_SCHEDULES',         	'Terug naar opnameschema');

/* scheduled_recordings.php */
/* recording_schedules_php */
/* search.php */
define ('_LANG_NO_MATCHES_FOUND', 			'Niets gevonden');
define ('_LANG_SEARCH',           			'Zoek');
define ('_LANG_TITLE',            			'Titel (programma)');
define ('_LANG_SUBTITLE',         			'Subtitel (aflevering)');
define ('_LANG_CATEGORY_TYPE',    			'Categorietype');
define ('_LANG_EXACT_MATCH',      			'Exacte zoekterm');
define ('_LANG_CHANNUM',          			'Zender');
define ('_LANG_LENGTH',           			'Lengte');
define ('_LANG_COMMANDS',         			'Wijzig');
define ('_LANG_DONT_RECORD',      			'Niet Opnemen');
define ('_LANG_ACTIVATE',         			'Activeren');
define ('_LANG_NEVER_RECORD',     			'Nooit&nbsp;Openemen');
define ('_LANG_RECORD_THIS',      			'Neem dit op');
define ('_LANG_FORGET_OLD',       			'Negeer oude opname');
define ('_LANG_DEFAULT',          			'Default');
define ('_LANG_RATING',          			'Waardering');
define ('_LANG_SCHEDULE',        			'Schema');
define ('_LANG_DISPLAY',         			'Display');
define ('_LANG_SCHEDULED',        			'Gepland');
define ('_LANG_DUPLICATES',       			'Dubbele opnames');
define ('_LANG_DEACTIVATED',      			'Gedeactiveerd');
define ('_LANG_CONFLICTS',        			'Conflicten');
define ('_LANG_TYPE',             			'Type');
define ('_LANG_AIRTIME',          			'Uitzenduur');
define ('_LANG_RERUN',            			'Herhaling');
define ('_LANG_SCHEDULE',         			'Schema');
define ('_LANG_PROFILE',          			'Profiel');
define ('_LANG_NOTES',            			'Notities');
define ('_LANG_DUP_METHOD',       			'Heruitzending detectie');
define ('_LANG_ANY',      	  			'Alle');

/* recorded_programs.php */
define ('_LANG_SHOW_RECORDINGS',     			'Overzicht opnames');
define ('_LANG_CONFIRM_DELETE',      			'Bent u zeker dat u deze opname wil verwijderen?');
define ('_LANG_ALL_RECORDINGS',      			'Alle opnames');
define ('_LANG_GO',                  			'Start');
define ('_LANG_PREVIEW',             			'Beeld');
define ('_LANG_FILE_SIZE',           			'bestand&nbsp;grootte');
define ('_LANG_DELETE',              			'Wis');
define ('_LANG_PROGRAMS_USING',      			'opnames, gebruiken ');
define ('_LANG_OUT_OF',              			' van de ');
define ('_LANG_EPISODES',            			'afleveringen');
define ('_LANG_SHOW_HAS_COMMFLAG',   			'gemarkeerde reclames');
define ('_LANG_SHOW_HAS_CUTLIST',    			'heeft snijlijst');
define ('_LANG_SHOW_IS_EDITING',     			'wordt bewerkt');
define ('_LANG_SHOW_AUTO_EXPIRE',    			'auto expire');
define ('_LANG_SHOW_HAS_BOOKMARK',   			'heeft bookmark');
define ('_LANG_YES',                 			'Ja');
define ('_LANG_NO',                  			'Nee');

/* recordings.php */
define ('_LANG_RECTYPE_ONCE',        			'Eenmalig');
define ('_LANG_RECTYPE_DAILY',       			'Dagelijks');
define ('_LANG_RECTYPE_CHANNEL',     			'Kanaal');
define ('_LANG_RECTYPE_ALWAYS',      			'Altijd');
define ('_LANG_RECTYPE_WEEKLY',      			'Wekelijks');
define ('_LANG_RECTYPE_FINDONE',     			'Eens');
define ('_LANG_RECTYPE_OVERRIDE',    			'Overschrijf opname');
define ('_LANG_RECTYPE_DONTREC',     			'Niet opnemen');

define ('_LANG_RECTYPE_LONG_ONCE',      		'Enkel deze vertoning opnemen.');
define ('_LANG_RECTYPE_LONG_DAILY',     		'Neem dagelijks op in dit tijdsslot.');
define ('_LANG_RECTYPE_LONG_CHANNEL',   		'Neem dit programma altijd op op deze zender: ');
define ('_LANG_RECTYPE_LONG_ALWAYS',    		'Neem dit programma altijd op, op alle zenders.');
define ('_LANG_RECTYPE_LONG_WEEKLY',    		'Neem wekelijks op in dit tijdsslot.');
define ('_LANG_RECTYPE_LONG_FINDONE',   		'Neem dit programma eenmalig op.');

define ('_LANG_RECSTATUS_LONG_DELETED',             	'Deze uitzending werd opgenomen maar verwijderd voordat ze voltooid was.');
define ('_LANG_RECSTATUS_LONG_STOPPED',             	'Deze uitzending werd opgenomen maar is stopgezet voor ze voltooid was.');
define ('_LANG_RECSTATUS_LONG_RECORDED',            	'Deze uitzending was opgenomen.');
define ('_LANG_RECSTATUS_LONG_RECORDING',           	'Deze uitzending wordt momenteel opgenomen.');
define ('_LANG_RECSTATUS_LONG_WILLRECORD',         	'Deze uitzending wordt opgenomen.');
define ('_LANG_RECSTATUS_LONG_UNKNOWN',            	'De status van deze uitzending is onbekend.');
define ('_LANG_RECSTATUS_LONG_MANUALOVERRIDE',      	'Manueel ingesteld om niet op te nemen.');
define ('_LANG_RECSTATUS_LONG_PREVIOUSRECORDING',   	'Deze aflevering werd reeds opgenomen.');
define ('_LANG_RECSTATUS_LONG_CURRENTRECORDING',    	'Deze aflevering werd reeds opgenomen en is nog steeds beschikbaar in de lijst met opnames.');
define ('_LANG_RECSTATUS_LONG_EARLIERSHOWING',      	'Deze aflevering word op een vroeger moment opgenomen.');
define ('_LANG_RECSTATUS_LONG_LATERSHOWING',        	'Deze aflevering word op een later moment opgenomen.');
define ('_LANG_RECSTATUS_LONG_TOOMANYRECORDINGS',   	'Er zijn al te veel afleveringen van deze dit programma opgenomen.');
define ('_LANG_RECSTATUS_LONG_CANCELLED',           	'Dit was een geplande opnamen maar is manueel uitgeschakeld.');
define ('_LANG_RECSTATUS_LONG_CONFLICT',            	'Een ander programma is automatisch gekozen om opgenomen te worden.');
define ('_LANG_RECSTATUS_LONG_OVERLAP',             	'Dit wordt reeds op een andere tijdstip opgenomen.');
define ('_LANG_RECSTATUS_LONG_LOWDISKSPACE',        	'Er was onvoldoende schijfruimte om dit programma op te nemen.');
define ('_LANG_RECSTATUS_LONG_TUNERBUSY',           	'De tvkaart was al in gebruik op het moment dat deze opname gepland stond.');
define ('_LANG_RECSTATUS_LONG_FORCE_RECORD',        	'This show was manually set to record this specific instance.');

/* weather.php */
define ('_LANG_HUMIDITY',		            	'Luchtvochtigheid');
define ('_LANG_PRESSURE',		            	'Luchtdruk');
define ('_LANG_WIND',			            	'Wind');
define ('_LANG_VISIBILITY',		            	'Zichtbaarheid');
define ('_LANG_WIND_CHILL',           		    	'Gevoelstemperatuur');
define ('_LANG_UV_INDEX',	           	    	'UV Index');
define ('_LANG_UV_MINIMAL',		            	'minimaal');
define ('_LANG_UV_MODERATE',		            	'gemiddeld');
define ('_LANG_UV_HIGH',		            	'hoog');
define ('_LANG_UV_EXTREME',		            	'extreem');
define ('_LANG_CURRENT_CONDITIONS',	            	'Huidige situatie');
define ('_LANG_FORECAST',		            	'Vooruitzicht');
define ('_LANG_LAST_UPDATED',		            	'Laatst bijgewerkt');
define ('_LANG_HIGH',			            	'Hoog');
define ('_LANG_LOW',			            	'Laag');
define ('_LANG_UNKNOWN',		            	'Unknown');
define ('_LANG_RADAR',			            	'Radar');
define ('_LANG_AT',			            	'at');

define ('_LANG_TODAY',			            	'Vandaag');
define ('_LANG_TOMORROW',		            	'Morgen');
define ('_LANG_MONDAY',			            	'Maandag');
define ('_LANG_TUESDAY',		            	'Dinsdag');
define ('_LANG_WEDNESDAY',		            	'Woensdag');
define ('_LANG_THURSDAY',		            	'Donderdag');
define ('_LANG_FRIDAY',			            	'Vrijdag');
define ('_LANG_SATURDAY',		            	'Zaterdag');
define ('_LANG_SUNDAY',			            	'Zondag');

/* utils.php */
define ('_LANG_HR',                                 	'u');
define ('_LANG_HRS',                                	'u');
define ('_LANG_MINS',                               	'min');




/*
define ('_LANG_',					'');
define ('_LANG_', 					'');
define ('_LANG_', 					'');
*/

?>
