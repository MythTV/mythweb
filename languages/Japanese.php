<?php
/***                                                                        ***\
    languages/Japanese.php

    Translation hash for Japanese.
\***                                                                        ***/

// Set the locale to Japanese UTF-8
setlocale(LC_ALL, 'ja_JP.utf-8');

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
define ('_LANG_BACKEND_STATUS',         'バックエンドステータス');
define ('_LANG_SETTINGS',               'セッティング');
define ('_LANG_LISTINGS',               '一覧');
define ('_LANG_FAVOURITES',             'お気に入り');
define ('_LANG_SCHEDULED_RECORDINGS',   '録画予定');
define ('_LANG_RECORDING_SCHEDULES',    '録画予約');
define ('_LANG_RECORDED_PROGRAMS',      '録画番組');
define ('_LANG_MANUALLY_SCHEDULE',    'マニュアル予約');
define ('_LANG_CATEGORY_LEGEND',        'カテゴリー凡例');
define ('_LANG_ACTION',                 'アクション');
define ('_LANG_ADULT',                  'アダルト');
define ('_LANG_ANIMALS',                '動物');
define ('_LANG_ART_MUSIC',              '芸術 音楽');
define ('_LANG_BUSINESS',               'ビジネス');
define ('_LANG_CHILDREN',               '子供');
define ('_LANG_COMEDY',                 'コメディー');
define ('_LANG_CRIME_MYSTERY',          '犯罪　ミステリー');
define ('_LANG_DOCUMENTARY',            'ドキュメンタリー');
define ('_LANG_DRAMA',                  'ドラマ');
define ('_LANG_EDUCATIONAL',            '教育');
define ('_LANG_FOOD',                   '食事');
define ('_LANG_GAME',                   '');
define ('_LANG_HEALTH_MEDICAL',         '健康　医療');
define ('_LANG_HISTORY',                '歴史');
define ('_LANG_HOWTO',                  'ハウツー');
define ('_LANG_HORROR',                 'ホラー');
define ('_LANG_MISC',                   'バラエティー');
define ('_LANG_NEWS',                   'ニュース');
define ('_LANG_REALITY',                'リアリティー');
define ('_LANG_ROMANCE',                'ロマンス');
define ('_LANG_SCIENCE_NATURE',         '科学　自然');
define ('_LANG_SCIFI_FANTASY',          'SF ファンタジー');
define ('_LANG_SHOPPING',               'ショッピング');
define ('_LANG_SOAPS',                  'メロドラマ');
define ('_LANG_SPIRITUAL',              '趣味');
define ('_LANG_SPORTS',                 'スポーツ');
define ('_LANG_TALK',                   'トーク');
define ('_LANG_TRAVEL',                 '旅行');
define ('_LANG_WAR',                    '戦争');
define ('_LANG_WESTERN',                'ウェスタン');
define ('_LANG_MOVIES',                 '映画');
define ('_LANG_UNKNOWN',                '不明');

define ('_CATMATCH_ACTION',            'アクション');
define ('_CATMATCH_ADULT',             'アダルト');
define ('_CATMATCH_ANIMALS',           '動物');
define ('_CATMATCH_ART_MUSIC',         '(芸術|音楽)');
define ('_CATMATCH_BUSINESS',          'ビジネス');
define ('_CATMATCH_CHILDREN',          'アニメ');
define ('_CATMATCH_COMEDY',            'コメディー');
define ('_CATMATCH_CRIME_MYSTERY',     '(犯罪|ミステリー)');
define ('_CATMATCH_DOCUMENTARY',       'ドキュメンタリー');
define ('_CATMATCH_DRAMA',             'ドラマ');
define ('_CATMATCH_EDUCATIONAL',       '教養');
define ('_CATMATCH_FOOD',              '食事');
define ('_CATMATCH_GAME',              'ゲーム');
define ('_CATMATCH_HEALTH_MEDICAL',    '(健康|医療)');
define ('_CATMATCH_HISTORY',           '歴史');
define ('_CATMATCH_HOWTO',             'ハウツー');
define ('_CATMATCH_HORROR',            'ホラー');
define ('_CATMATCH_MISC',              'バラエティー');
define ('_CATMATCH_NEWS',              '報道');
define ('_CATMATCH_REALITY',           'リアリティー');
define ('_CATMATCH_ROMANCE',           'ロマンス');
define ('_CATMATCH_SCIENCE_NATURE',    '科学　自然');
define ('_CATMATCH_SCIFI_FANTASY',     'SF ファンタジー');
define ('_CATMATCH_SHOPPING',          'ショッピング');
define ('_CATMATCH_SOAPS',             'メロドラマ');
define ('_CATMATCH_SPIRITUAL',         '趣味');
define ('_CATMATCH_SPORTS',            'スポーツ');
define ('_CATMATCH_TALK',              'トーク');
define ('_CATMATCH_TRAVEL',            '旅行');
define ('_CATMATCH_WAR',               '戦争');
define ('_CATMATCH_WESTERN',           'ウェスタン');
define ('_CATMATCH_MOVIES',            '映画');

/* settings.php */
define ('_LANG_SETTINGS_HEADER1', 'これは設定のインデックスページです...');
define ('_LANG_SETTINGS_HEADER2', 'It should get some nifty images to link to the various sections, but for now, we get:');
define ('_LANG_CHANNELS', 'チャンネル');
define ('_LANG_THEME', 'テーマ');
define ('_LANG_LANGUAGE', '言語');
define ('_LANG_DATEFORMATS', '日付書式');
define ('_LANG_KEY_BINDINGS', 'キーバインド');
define ('_LANG_CONFIGURE', '設定');
define ('_LANG_GO_TO', '移動');
define ('_LANG_ADVANCED', 'アドバンスト');
define ('_LANG_FORMAT_HELP', 'フォーマットヘルプ');
define ('_LANG_STATUS_BAR', 'ステータスバー');
define ('_LANG_SCHEDULED_RECORDINGS', '予約録画');
define ('_LANG_SCHEDULED_POPUP', '予約ポップアップ');
define ('_LANG_RECORDED_PROGRAMS', '録画番組');
define ('_LANG_SEARCH_RESULTS', '検索結果');
define ('_LANG_LISTING_TIME_KEY', '一覧タイムキー');
define ('_LANG_LISTING_JUMP_TO', '一覧 &quot;移動&quot;');
define ('_LANG_CHANNEL_JUMP_TO', 'チャンネル &quot;移動&quot;');
define ('_LANG_HOUR_FORMAT', '時間書式');
define ('_LANG_RESET', 'リセット');
define ('_LANG_SAVE', '保存');
define ('_LANG_SHOW_DESCRIPTIONS_ON_NEW_LINE', '内容を新しい行に表示する');

/* program_listings.php */
define ('_LANG_CURRENTLY_BROWSING', '表示日');
define ('_LANG_JUMP_TO', '移動先');
define ('_LANG_HOUR', '時');
define ('_LANG_DATE', '日付');
define ('_LANG_JUMP', '移動');

/* program_detail.php */
define ('_LANG_SEARCH',                                 '検索');
define ('_LANG_IMDB',                                   'IMDB');
define ('_LANG_GOOGLE',                                 'Google');
define ('_LANG_TVTOME',                                 'TV Tome');
define ('_LANG_MINUTES',                                '分');
define ('_LANG_TO',                                     'から');
define ('_LANG_CATEGORY',                               'カテゴリー');
define ('_LANG_ORIG_AIRDATE',                           '放送日');
define ('_LANG_RECORDING_OPTIONS',                      '録画オプション');
define ('_LANG_DONT_RECORD_THIS_PROGRAM',               '録画しない');
define ('_LANG_CANCEL_THIS_SCHEDULE',               	'この予約を取り消す');
define ('_LANG_RECORDING_PROFILE',                      '録画プロファイル');
define ('_LANG_RECPRIORITY',                            '録画優先順位');
define ('_LANG_CHECK_FOR_DUPLICATES_IN',                '重複チェック先');
define ('_LANG_CURRENT_RECORDINGS',                     '現在の録画');
define ('_LANG_PREVIOUS_RECORDINGS',                    '以前の録画');
define ('_LANG_ALL_RECORDINGS',                         '全ての録画');
define ('_LANG_DUPLICATE_CHECK_METHOD',                 '重複チェック方法');
define ('_LANG_NONE',                                   '無し');
define ('_LANG_SUBTITLE',                               'サブタイトル');
define ('_LANG_DESCRIPTION',                            '内容');
define ('_LANG_SUBTITLE_AND_DESCRIPTION',               'サブタイトルと内容');
define ('_LANG_SUB_AND_DESC',                           'サブタイトルと内容(無しも一致)');
define ('_LANG_AUTO_EXPIRE_RECORDINGS',                 '自動削除?');
define ('_LANG_NO_OF_RECORDINGS_TO_KEEP',               '録画保存数?');
define ('_LANG_RECORD_NEW_AND_EXPIRE_OLD',              '新しく録画して古いのを削除する?');
define ('_LANG_START_EARLY',                            '開始先行 (分)');
define ('_LANG_END_LATE',                               '終了遅れ (分)');
define ('_LANG_UPDATE_RECORDING_SETTINGS',              '録画設定を更新');
define ('_LANG_WHAT_ELSE_IS_ON_AT_THIS_TIME',           'この時間の他の放送');
define ('_LANG_BACK_TO_THE_PROGRAM_LISTING',            '番組一覧に戻る');
define ('_LANG_FIND_OTHER_SHOWING_OF_THIS_PROGRAM',     '他の放送を検索する');
define ('_LANG_BACK_TO_RECORDING_SCHEDULES',            '録画予約に戻る');

/* scheduled_recordings.php */
/* recording_schedules_php */
/* search.php */
define ('_LANG_NO_MATCHES_FOUND', '一致する物が有りませんでした');
define ('_LANG_SEARCH',           '検索');
define ('_LANG_TITLE',            'タイトル');
define ('_LANG_SUBTITLE',         'サブタイトル');
define ('_LANG_CATEGORY',         'カテゴリタイプ');
define ('_LANG_CHANNUM',          'ステーション');
define ('_LANG_AIRDATE',          '放送日');
define ('_LANG_LENGTH',           '時間');
define ('_LANG_COMMANDS',         'コマンド');
define ('_LANG_DONT_RECORD',      '録画中止');
define ('_LANG_ACTIVATE',         '有効にする');
define ('_LANG_NEVER_RECORD',     'もう録画しない');
define ('_LANG_RECORD_THIS',      '録画する');
define ('_LANG_FORGET_OLD',       'Forget Old');
define ('_LANG_DEFAULT',          'Default');
define ('_LANG_RATING',           'Rating');
define ('_LANG_SCHEDULE',         '予約');
define ('_LANG_DISPLAY',          '表示');
define ('_LANG_SCHEDULED',        '予約済');
define ('_LANG_DUPLICATES',       '重複');
define ('_LANG_DEACTIVATED',      '停止');
define ('_LANG_CONFLICTS',        '衝突');
define ('_LANG_TYPE',             'タイプ');
define ('_LANG_AIRTIME',          '放送時間');
define ('_LANG_RERUN',            'Rerun');
define ('_LANG_PROFILE',          'プロファイル');
define ('_LANG_NOTES',            '注釈');
define ('_LANG_DUP_METHOD',       '重複検知');
define ('_LANG_CATEGORY_TYPE',    'カテゴリータイプ');
define ('_LANG_EXACT_MATCH',      '正確一致');

/* recorded_programs.php */
define ('_LANG_SHOW_RECORDINGS', '録画表示');
define ('_LANG_CONFIRM_DELETE', '個の録画を削除してもよろしいですか?');
define ('_LANG_ALL_RECORDINGS', '全ての録画');
define ('_LANG_GO', '移動');
define ('_LANG_PREVIEW', 'プレビュー');
define ('_LANG_FILE_SIZE', 'ファイルサイズ');
define ('_LANG_DELETE', '削除');
define ('_LANG_PROGRAMS_USING', '番組, 使用');
define ('_LANG_OUT_OF', ' 全');
define ('_LANG_EPISODES',        '番組');
define ('_LANG_SHOW_HAS_COMMFLAG',   'コマーシャル検出');
define ('_LANG_SHOW_HAS_CUTLIST',    'カットリスト');
define ('_LANG_SHOW_IS_EDITING',     '編集済み');
define ('_LANG_SHOW_AUTO_EXPIRE',    '自動削除');
define ('_LANG_SHOW_HAS_BOOKMARK',   'ブックマーク');
define ('_LANG_YES',                 'はい');
define ('_LANG_NO',                  'いいえ');

/* recordings.php */
define ('_LANG_RECTYPE_ONCE',    '一回');
define ('_LANG_RECTYPE_DAILY',   '毎日');
define ('_LANG_RECTYPE_CHANNEL', 'チャンネル');
define ('_LANG_RECTYPE_ALWAYS',  '常に');
define ('_LANG_RECTYPE_WEEKLY',  '週間');
define ('_LANG_RECTYPE_FINDONE', '検索');
define ('_LANG_RECTYPE_OVERRIDE', '[translate me] Override (record)');
define ('_LANG_RECTYPE_DONTREC', '[translate me] Do Not Record');

define ('_LANG_RECTYPE_LONG_ONCE',      'この放送のみ録画する');
define ('_LANG_RECTYPE_LONG_DAILY',     'この番組を毎日この時間帯に録画する');
define ('_LANG_RECTYPE_LONG_WEEKLY',    'この番組を毎週この時間帯に録画する');
define ('_LANG_RECTYPE_LONG_CHANNEL',   'この番組をこのチャンネルで録画する');
define ('_LANG_RECTYPE_LONG_ALWAYS',    'この番組をどのチャンネルでも録画する');
define ('_LANG_RECTYPE_LONG_FINDONE',   'この番組を一回だけ録画する');

define ('_LANG_RECSTATUS_LONG_DELETED',             '録画を開始しましたが終了前に削除されました。');
define ('_LANG_RECSTATUS_LONG_STOPPED',             '録画を開始しましたが終了前に停止されました。');
define ('_LANG_RECSTATUS_LONG_RECORDED',            '録画されました。');
define ('_LANG_RECSTATUS_LONG_RECORDING',           '録画を開始しました。');
define ('_LANG_RECSTATUS_LONG_WILLRECORD',          'この番組は録画されます');
define ('_LANG_RECSTATUS_LONG_UNKNOWN',             '個の番組のステータスは不明です。');
define ('_LANG_RECSTATUS_LONG_MANUALOVERRIDE',      '手動で録画市内を設定されました。');
define ('_LANG_RECSTATUS_LONG_PREVIOUSRECORDING',   '以前録画されています。重複ポリシーで設定されています。');
define ('_LANG_RECSTATUS_LONG_CURRENTRECORDING',    '以前録画されています。録画リストから利用できます。');
define ('_LANG_RECSTATUS_LONG_EARLIERSHOWING',      '他の時間の変わりにこの番組が録画されます。');
define ('_LANG_RECSTATUS_LONG_LATERSHOWING',        '他の時間の変わりにこの番組が録画されます。');
define ('_LANG_RECSTATUS_LONG_TOOMANYRECORDINGS',   '既に数多く録画されています。');
define ('_LANG_RECSTATUS_LONG_CANCELLED',           '手動でキャンセルされました。');
define ('_LANG_RECSTATUS_LONG_CONFLICT',            '他の録画優先順位の高い番組が録画されます。');
define ('_LANG_RECSTATUS_LONG_OVERLAP',             '他の予約で同じ番組も録画されます。');
define ('_LANG_RECSTATUS_LONG_LOWDISKSPACE',        '個の番組を録画するのに必要なディスクの空き容量が有りません。');
define ('_LANG_RECSTATUS_LONG_TUNERBUSY',           '利用可能なチューナーが有りません。');
define ('_LANG_RECSTATUS_LONG_FORCE_RECORD',      'This show was manually set to record this specific instance.');

/* in theme wap */
define ('_LANG_RECORDED',       '録画済');
define ('_LANG_CHANNEL',        'チャンネル');
define ('_LANG_RECORD_DUPS',    '重複録画');
define ('_LANG_AUTO_EXPIRE',    '自動削除');
define ('_LANG_UPDATE_SETTINGS','更新');
define ('_LANG_RECORDINGS',     '録画');

/* utils.php */
define ('_LANG_HR',              '時間');
define ('_LANG_HRS',             '時間');
define ('_LANG_MINS',            '分');


?>
