<?php
/***                                                                        ***\
    languages/Japanese.php

    Translation hash for Japanese.
\***                                                                        ***/

// Set the locale to Japanese UTF-8
setlocale(LC_ALL, 'ja_JP.UTF-8');

// Define the language lookup hash ** Do not touch the next line
$L = array(
// Add your translations below here.
// Warning, any custom comments will be lost during translation updates.
//
// Shared Terms
    '$1 min'                                             => '$1分',
    '$1 mins'                                            => '$1分',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1番組,  全$4 中 $2($3) 使用。',
    '$1 to $2'                                           => '$1 から $2',
    'Advanced Options'                                   => 'アドバンストオプション',
    'Airtime'                                            => '放送時間',
    'All recordings'                                     => '全ての録画',
    'Auto-expire recordings'                             => '自動削除',
    'Auto-flag commercials'                              => 'CM自動検知',
    'Auto-transcode'                                     => '',
    'Backend Status'                                     => 'バックエンドステータス',
    'Cancel this schedule.'                              => 'この予約をキャンセルする',
    'Category'                                           => 'カテゴリー',
    'Check for duplicates in'                            => '重複チェック対象',
    'Current recordings'                                 => '現在の録画',
    'Date'                                               => '日付',
    'Description'                                        => '内容',
    'Details for'                                        => '',
    'Display'                                            => '表示',
    'Duplicate Check method'                             => '重複チェック方法',
    'End Late'                                           => '録画延長',
    'Episode'                                            => 'サブタイトル',
    'Go'                                                 => '移動',
    'Hour'                                               => '時',
    'IMDB'                                               => '',
    'Inactive'                                           => '',
    'Jump'                                               => '移動',
    'Jump to'                                            => '移動',
    'Listings'                                           => '一覧',
    'No'                                                 => 'いいえ',
    'No. of recordings to keep'                          => '録画番組保存数',
    'None'                                               => '無し',
    'Notes'                                              => '備考',
    'Only New Episodes'                                  => '新しい番組のみ',
    'Original Airdate'                                   => '初回放送',
    'Previous recordings'                                => '以前の録画',
    'Rating'                                             => 'レーティング',
    'Record new and expire old'                          => '古い物から削除する',
    'Recorded Programs'                                  => '録画済み',
    'Recording Group'                                    => '録画グループ',
    'Recording Options'                                  => '録画オプション',
    'Recording Priority'                                 => '録画優先順位',
    'Recording Profile'                                  => '録画プロファイル',
    'Rerun'                                              => '再開',
    'Save'                                               => '保存',
    'Schedule'                                           => '予約',
    'Schedule Options'                                   => '予約オプション',
    'Schedule Override'                                  => '予約上書き',
    'Schedule normally.'                                 => '通常の予約',
    'Scheduled Recordings'                               => 'これからの録画',
    'Search'                                             => '検索',
    'Search Results'                                     => '検索結果',
    'Start Early'                                        => '早めの録画',
    'Subtitle'                                           => 'サブタイトル',
    'Subtitle and Description'                           => 'サブタイトルと内容',
    'The requested recording schedule has been deleted.' => '要求された予約は既に削除されています。',
    'Title'                                              => 'タイトル',
    'Transcoder'                                         => '',
    'Unknown'                                            => '不明',
    'Update'                                             => '更新',
    'Update Recording Settings'                          => '録画設定を保存',
    'Yes'                                                => 'はい',
    'airdate'                                            => '放送日',
    'channum'                                            => 'チャンネル',
    'description'                                        => '内容',
    'generic_date'                                       => '%Y %b %e',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => '時間',
    'minutes'                                            => '分',
    'recgroup'                                           => 'グループ',
    'rectype-long: always'                               => 'この番組をどのチャンネルでも録画する',
    'rectype-long: channel'                              => 'この番組をこのチャンネルで録画する',
    'rectype-long: daily'                                => 'この番組を毎日この時間帯に録画する',
    'rectype-long: dontrec'                              => 'この番組を録画しない',
    'rectype-long: finddaily'                            => 'この番組を一日一回録画する',
    'rectype-long: findone'                              => 'この番組を一回だけ録画する',
    'rectype-long: findweekly'                           => 'この番組を毎週一回録画する',
    'rectype-long: once'                                 => 'この放送のみ録画する',
    'rectype-long: override'                             => 'この番組を上書きで録画する',
    'rectype-long: weekly'                               => 'この番組を毎週この時間帯に録画する',
    'rectype: always'                                    => '常時',
    'rectype: channel'                                   => 'チャンネル',
    'rectype: daily'                                     => '毎日',
    'rectype: dontrec'                                   => '録画しない',
    'rectype: findone'                                   => '検索',
    'rectype: once'                                      => '1回',
    'rectype: override'                                  => '上書き',
    'rectype: weekly'                                    => '毎週',
    'subtitle'                                           => 'サブタイトル',
    'title'                                              => 'タイトル',
// includes/programs.php
    'recstatus: cancelled'         => '録画状態: キャンセル',
    'recstatus: conflict'          => '録画状態: 衝突',
    'recstatus: currentrecording'  => '録画状態: 録画中',
    'recstatus: deleted'           => '録画状態: 削除済み',
    'recstatus: earliershowing'    => '録画状態: 早い放送',
    'recstatus: force_record'      => '録画状態: 強制録画',
    'recstatus: latershowing'      => '録画状態: 遅れた放送',
    'recstatus: lowdiskspace'      => '録画状態: ディスクの空きが少ないです',
    'recstatus: manualoverride'    => '録画状態: 手動設定',
    'recstatus: overlap'           => '録画状態: オーバーラップしてます',
    'recstatus: previousrecording' => '録画状態: 前回録画',
    'recstatus: recorded'          => '録画状態: 録画済',
    'recstatus: recording'         => '録画状態: 録画中',
    'recstatus: repeat'            => '録画状態: 繰り返し',
    'recstatus: stopped'           => '録画状態: 停止',
    'recstatus: toomanyrecordings' => '録画状態: 録画が多すぎます',
    'recstatus: tunerbusy'         => '録画状態: チューナーが使用中です',
    'recstatus: unknown'           => '録画状態: 不明',
    'recstatus: willrecord'        => '録画状態: 録画されます',
// includes/recording_schedules.php
    'Dup Method'                   => '重複検知',
    'Profile'                      => 'プロファイル',
    'Sub and Desc (Empty matches)' => 'サブタイトルと内容(エンプティーマッチ)',
    'Type'                         => 'タイプ',
    'rectype: finddaily'           => '一日一回',
    'rectype: findweekly'          => '週一回',
// includes/utils.php
    '$1 B'   => '',
    '$1 GB'  => '',
    '$1 KB'  => '',
    '$1 MB'  => '',
    '$1 TB'  => '',
    '$1 hr'  => '$1 時間',
    '$1 hrs' => '$1 時間',
// program_detail.php
    'Unknown Program.'            => '不明な番組',
    'Unknown Recording Schedule.' => '不明な予約',
// search.php
    'Please search for something.' => '検索する文字を入力してください。',
// themes/.../canned_searches.php
    'handy: overview' => 'おてがる検索: 一覧',
// themes/.../channel_detail.php
    'Length' => '時間',
    'Show'   => '番組',
    'Time'   => '放送時間',
// themes/.../music.php
    'Album'               => '',
    'Album (filtered)'    => '',
    'All Music'           => '',
    'Artist'              => '',
    'Artist (filtered)'   => '',
    'Displaying'          => '',
    'Duration'            => '',
    'End'                 => '',
    'Filtered'            => '',
    'Genre'               => '',
    'Genre (filtered)'    => '',
    'Music'               => '',
    'Next'                => '',
    'No Tracks Available' => '',
    'Previous'            => '',
    'Top'                 => '',
    'Track Name'          => '',
    'Unfiltered'          => '',
// themes/.../program_detail.php
    '$1 Rating'                           => '$1 レイティング',
    'Back to the program listing'         => '番組一覧に戻る',
    'Back to the recording schedules'     => '録画予約に戻る',
    'Cast'                                => 'キャスト',
    'Directed by'                         => '監督',
    'Don\'t record this program.'         => '録画しない',
    'Exec. Producer'                      => '製作責任者',
    'Find other showings of this program' => 'この番組のほかの放送を見つける',
    'Find showings of this program'       => 'この番組を検索する',
    'Google'                              => '',
    'Guest Starring'                      => 'ゲスト出演',
    'Hosted by'                           => '主催',
    'Presented by'                        => '提供',
    'Produced by'                         => '製作',
    'Program Detail'                      => '',
    'TV.com'                              => '',
    'Time Stretch Default'                => '',
    'What else is on at this time?'       => 'この時間の番組表',
    'Written by'                          => '著者',
// themes/.../program_listing.php
    'Currently Browsing:  $1' => '表示日: $1',
    'Jump To'                 => '移動',
    'Program Listing'         => '',
// themes/.../recorded_programs.php
    '$1 episode'                                          => '$1番組',
    '$1 episodes'                                         => '$1番組',
    '$1 recording'                                        => '$1録画',
    '$1 recordings'                                       => '$1録画',
    'Are you sure you want to delete the following show?' => 'この録画を削除してよろしいですか？',
    'Delete'                                              => '削除',
    'Delete + Rerecord'                                   => '',
    'Show group'                                          => 'グループ表示',
    'Show recordings'                                     => '番組表示',
    'auto-expire'                                         => '自動削除',
    'file size'                                           => 'ファイルサイズ',
    'has bookmark'                                        => 'ブックマーク',
    'has commflag'                                        => 'CMマーク',
    'has cutlist'                                         => 'カットリスト',
    'is editing'                                          => '編集',
    'preview'                                             => 'プレビュー',
// themes/.../recording_profiles.php
    'Profile Groups'     => 'プロファイルグループ',
    'Recording profiles' => '録画プロファイル',
// themes/.../recording_schedules.php
    'Any'                                       => '全て',
    'No recording schedules have been defined.' => '予約が設定されていません',
    'channel'                                   => 'チャンネル',
    'profile'                                   => 'プロファイル',
    'transcoder'                                => '',
    'type'                                      => 'タイプ',
// themes/.../schedule_manually.php
    'Channel'           => 'チャンネル',
    'Create Schedule'   => '予約作成',
    'Length (min)'      => '時間 (分)',
    'Save Schedule'     => '保存',
    'Schedule Manually' => '',
    'Start Date'        => '開始日',
    'Start Time'        => '開始時間',
// themes/.../scheduled_recordings.php
    'Activate'      => '有効',
    'Commands'      => 'コマンド',
    'Conflicts'     => '衝突',
    'Deactivated'   => '無効',
    'Default'       => '既定',
    'Don\'t Record' => '録画停止',
    'Duplicates'    => '重複',
    'Forget Old'    => '古いのを忘れる',
    'Never Record'  => 'もう録画しない',
    'Record This'   => 'これを録画する',
    'Scheduled'     => '予約',
// themes/.../search.php
    'No matches found' => '一致する物がありませんでした',
    'Search for:  $1'  => '$1 の検索結果',
// themes/.../settings.php
    'Channels'           => 'チャンネル',
    'Configure'          => '設定',
    'Key Bindings'       => 'キーバインド',
    'MythWeb Settings'   => 'MythWeb設定',
    'settings: overview' => '設定概要',
// themes/.../settings_channels.php
    'Configure Channels'                                                                                                                 => '',
    'Please be warned that by altering this table without knowing what you are doing, you could seriously disrupt mythtv functionality.' => '設定項目の意味がわからないときは変更しないでください。MythTVが正常に動作しなくなります。',
    'brightness'                                                                                                                         => '',
    'callsign'                                                                                                                           => '',
    'colour'                                                                                                                             => '',
    'commfree'                                                                                                                           => '',
    'contrast'                                                                                                                           => '',
    'delete'                                                                                                                             => '',
    'finetune'                                                                                                                           => '',
    'freqid'                                                                                                                             => '',
    'hue'                                                                                                                                => '',
    'name'                                                                                                                               => '',
    'recpriority'                                                                                                                        => '',
    'sourceid'                                                                                                                           => '',
    'videofilters'                                                                                                                       => '',
    'visible'                                                                                                                            => '',
// themes/.../settings_keys.php
    'Action'                => '',
    'Configure Keybindings' => '',
    'Context'               => '',
    'Destination'           => '',
    'Edit keybindings on'   => 'キーバインド編集対象',
    'JumpPoints Editor'     => '',
    'Key bindings'          => '',
    'Keybindings Editor'    => '',
    'Set Host'              => '',
// themes/.../settings_mythweb.php
    'Channel &quot;Jump to&quot;'     => 'チャンネル &quot;移動&quot;',
    'Date Formats'                    => '日付書式',
    'Guide Settings'                  => 'ガイド設定',
    'Hour Format'                     => '時間書式',
    'Language'                        => '言語',
    'Listing &quot;Jump to&quot;'     => '一覧 &quot;移動&quot;',
    'Listing Time Key'                => '一覧 タイムキー',
    'MythWeb Theme'                   => 'MythWebテーマ',
    'Only display favourite channels' => 'お気に入りのチャンネルのみ表示する',
    'Reset'                           => 'リセット',
    'SI Units?'                       => 'SI単位を使用する',
    'Scheduled Popup'                 => '予約ポップアップ',
    'Show descriptions on new line'   => '内容を新しい行で表示する',
    'Status Bar'                      => 'ステータスバー',
    'Weather Icons'                   => '天気アイコン',
    'format help'                     => '書式ヘルプ',
// themes/.../theme.php
    'Category Legend'                            => 'カテゴリー凡例',
    'Category Type'                              => 'カテゴリータイプ',
    'Edit MythWeb and some MythTV settings.'     => 'MythWebとMythTVの設定',
    'Exact Match'                                => '正確に一致',
    'HD Only'                                    => 'HDのみ',
    'Manually Schedule'                          => '手動録画',
    'MythMusic on the web.'                      => 'MythMusic オンザウェブ',
    'MythVideo on the web.'                      => 'MythVideo オンザウェブ',
    'MythWeb Weather.'                           => 'MythWeb 天気',
    'Recording Schedules'                        => '録画予約',
    'Search fields'                              => '検索フィールド',
    'Search help'                                => '検索ヘルプ',
    'Search help: movie example'                 => '*** 1/2 アドベンチャー',
    'Search help: movie search'                  => '映画検索',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => '正規表現検索',
    'Search options'                             => '検索オプション',
    'Searches'                                   => '検索メニュー',
    'Settings'                                   => '設定',
    'TV functions, including recorded programs.' => 'TV 録画',
// themes/.../video.php
    'Edit'          => '',
    'Reverse Order' => '',
    'Videos'        => '',
    'category'      => '',
    'cover'         => '',
    'director'      => '',
    'imdb rating'   => '',
    'plot'          => '',
    'rating'        => '',
    'year'          => '',
// themes/.../weather.php
    ' at '               => '',
    'Current Conditions' => '現在の状況',
    'Forecast'           => '予報',
    'Friday'             => '金曜日',
    'High'               => '高',
    'Humidity'           => '湿度',
    'Last Updated'       => '最後の更新',
    'Low'                => '低',
    'Monday'             => '月曜日',
    'Pressure'           => '気圧',
    'Radar'              => 'レーダー',
    'Saturday'           => '土曜日',
    'Sunday'             => '日曜日',
    'Thursday'           => '木曜日',
    'Today'              => '今日',
    'Tomorrow'           => '明日',
    'Tuesday'            => '火曜日',
    'UV Extreme'         => 'UV 非常に強い',
    'UV High'            => 'UV 強い',
    'UV Index'           => 'UV 指数',
    'UV Minimal'         => 'UV 弱い',
    'UV Moderate'        => 'UV 穏やか',
    'Visibility'         => '視界',
    'Weather'            => '',
    'Wednesday'          => '水曜日',
    'Wind'               => '風',
    'Wind Chill'         => '体感温度'
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
$Categories['Action']         = array('アクション',             'アクション');
$Categories['Adult']          = array('アダルト',               'アダルト');
$Categories['Animals']        = array('動物',                   '動物');
$Categories['Art_Music']      = array('芸術 音楽',              '(芸術|音楽)');
$Categories['Business']       = array('ビジネス',               'ビジネス');
$Categories['Children']       = array('子供',                   '(アニメ|キッズ)');
$Categories['Comedy']         = array('コメディー',             'コメディー');
$Categories['Crime_Mystery']  = array('犯罪　ミステリー',       '(犯罪|ミステリー)');
$Categories['Documentary']    = array('ドキュメンタリー',       'ドキュメンタリー');
$Categories['Drama']          = array('ドラマ',                 'ドラマ');
$Categories['Educational']    = array('教育',                   '教育');
$Categories['Food']           = array('食事',                   '食事');
$Categories['Game']           = array('ゲーム',                 'ゲーム');
$Categories['Health_Medical'] = array('健康　医療',             '(健康|医療)');
$Categories['History']        = array('歴史',                   '歴史');
$Categories['Horror']         = array('ホラー',                 'ホラー');
$Categories['HowTo']          = array('ハウツー',               'ハウツー');
$Categories['Misc']           = array('バラエティ',             'バラエティ');
$Categories['News']           = array('報道',                   '(報道|情報)');
$Categories['Reality']        = array('リアリティー',           'リアリティー');
$Categories['Romance']        = array('ロマンス',               'ロマンス');
$Categories['SciFi_Fantasy']  = array('SF　ファンタジー',       'SF　ファンタジー');
$Categories['Science_Nature'] = array('自然　科学',             '科学　自然');
$Categories['Shopping']       = array('ショッピング',           'ショッピング');
$Categories['Soaps']          = array('メロドラマ',             'メロドラマ');
$Categories['Spiritual']      = array('趣味',                   '趣味');
$Categories['Sports']         = array('スポーツ',               'スポーツ');
$Categories['Talk']           = array('トーク',                 'トーク');
$Categories['Travel']         = array('旅行',                   '旅行');
$Categories['War']            = array('戦争',                   '戦争');
$Categories['Western']        = array('ウェスタン',             'ウェスタン');

// These are some other classes that we might want to have show up in the
//   category legend (they don't need regular expressions)
$Categories['Unknown']        = array('不明');
$Categories['movie']          = array('映画');

?>
