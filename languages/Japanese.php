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
    '$1 Search'                                          => '$1 検索',
    '$1 hr'                                              => '$1 時間',
    '$1 hrs'                                             => '$1 時間',
    '$1 min'                                             => '$1分',
    '$1 mins'                                            => '$1分',
    '$1 programs, using $2 ($3) out of $4 ($5 free).'    => '$1番組,  $4 中 $2 ($3) 使用。 ($5 空)',
    '$1 to $2'                                           => '$1 から $2',
    'Activate'                                           => '有効',
    'Advanced Options'                                   => 'アドバンストオプション',
    'Airtime'                                            => '放送時間',
    'All recordings'                                     => '全ての録画',
    'Auto-expire recordings'                             => '自動削除',
    'Auto-flag commercials'                              => 'CM自動検知',
    'Auto-transcode'                                     => '自動トランスコード',
    'Backend Logs'                                       => 'バックエンドログ',
    'Backend Status'                                     => 'バックエンドステータス',
    'Cancel this schedule.'                              => 'この予約をキャンセルする',
    'Category'                                           => 'カテゴリー',
    'Check for duplicates in'                            => '重複チェック対象',
    'Create Schedule'                                    => '予約作成',
    'Current recordings'                                 => '現在の録画',
    'Currently Browsing:  $1'                            => '表示日: $1',
    'Custom Schedule'                                    => 'カスタム録画',
    'Date'                                               => '日付',
    'Default'                                            => '通常設定',
    'Description'                                        => '内容',
    'Details for'                                        => '詳細',
    'Display'                                            => '表示',
    'Don\'t Record'                                      => '録画停止',
    'Duplicate Check method'                             => '重複チェック方法',
    'End Late'                                           => '録画延長',
    'Episode'                                            => 'サブタイトル',
    'Forget Old'                                         => 'もう一度録画する',
    'Friday'                                             => '金曜日',
    'Hour'                                               => '時',
    'IMDB'                                               => '',
    'Inactive'                                           => '無効',
    'Jump'                                               => '移動',
    'Jump to'                                            => '移動',
    'Keyword'                                            => 'キーワード',
    'Listings'                                           => '番組表',
    'Monday'                                             => '月曜日',
    'Music'                                              => 'ミュージック',
    'Never Record'                                       => 'もう録画しない',
    'No'                                                 => 'いいえ',
    'No. of recordings to keep'                          => '録画番組保存数',
    'None'                                               => '無し',
    'Only New Episodes'                                  => '新しい番組のみ',
    'Original Airdate'                                   => '初回放送',
    'People'                                             => 'ピープル',
    'Power'                                              => 'パワー',
    'Previous recordings'                                => '以前の録画',
    'Program Listing'                                    => '番組表',
    'Rating'                                             => 'レーティング',
    'Record This'                                        => 'これを録画する',
    'Record new and expire old'                          => '古い物から削除する',
    'Recorded Programs'                                  => '録画済み',
    'Recording Group'                                    => '録画グループ',
    'Recording Options'                                  => '録画オプション',
    'Recording Priority'                                 => '録画優先順位',
    'Recording Profile'                                  => '録画プロファイル',
    'Recording Schedules'                                => '録画予約',
    'Repeat'                                             => '再開',
    'Saturday'                                           => '土曜日',
    'Save'                                               => '保存',
    'Save Schedule'                                      => '保存',
    'Schedule'                                           => '予約',
    'Schedule Manually'                                  => '手動予約',
    'Schedule Options'                                   => '予約オプション',
    'Schedule Override'                                  => '予約上書き',
    'Schedule normally.'                                 => '通常の予約',
    'Search'                                             => '検索',
    'Search Results'                                     => '検索結果',
    'Settings'                                           => '設定',
    'Start Early'                                        => '早めの録画',
    'Subtitle'                                           => 'サブタイトル',
    'Subtitle and Description'                           => 'サブタイトルと内容',
    'Sunday'                                             => '日曜日',
    'The requested recording schedule has been deleted.' => '要求された予約は既に削除されています。',
    'Thursday'                                           => '木曜日',
    'Title'                                              => 'タイトル',
    'Transcoder'                                         => 'トランスコーダー',
    'Tuesday'                                            => '火曜日',
    'Type'                                               => 'タイプ',
    'Unknown'                                            => '不明',
    'Upcoming Recordings'                                => 'これからの録画',
    'Update'                                             => '更新',
    'Update Recording Settings'                          => '録画設定を保存',
    'Weather'                                            => '天気',
    'Wednesday'                                          => '水曜日',
    'Yes'                                                => 'はい',
    'airdate'                                            => '放送日',
    'channum'                                            => 'チャンネル',
    'description'                                        => '内容',
    'generic_date'                                       => '%Y %b %e',
    'generic_time'                                       => '%I:%M %p',
    'length'                                             => '時間',
    'minutes'                                            => '分',
    'recgroup'                                           => 'グループ',
    'recpriority'                                        => '録画優先順位',
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
// config/canned_searches.php
    'All HDTV'                           => '',
    'Movies'                             => '',
    'Movies, 3&frac12; Stars or more'    => '',
    'Movies, Stinkers (2 Stars or less)' => '',
    'Music Specials'                     => '',
    'New Titles, Premieres'              => '',
    'Non-Music Specials'                 => '',
    'Non-Series HDTV'                    => '',
    'Science Fiction Movies'             => '',
// includes/programs.php
    'CC'                           => '',
    'HDTV'                         => '',
    'Notes'                        => '備考',
    'Part $1 of $2'                => '$1/$2',
    'Stereo'                       => 'ステレオ',
    'Subtitled'                    => '',
    'recstatus: cancelled'         => 'キャンセルされました',
    'recstatus: conflict'          => '衝突してます',
    'recstatus: currentrecording'  => '録画中',
    'recstatus: deleted'           => '削除済み',
    'recstatus: earliershowing'    => '早い番組が録画されます',
    'recstatus: force_record'      => '強制録画',
    'recstatus: inactive'          => '無効',
    'recstatus: latershowing'      => '後の番組が録画されます',
    'recstatus: lowdiskspace'      => 'ディスクの空きが少ないため録画できません',
    'recstatus: manualoverride'    => '手動設定',
    'recstatus: neverrecord'       => '録画しない',
    'recstatus: notlisted'         => '',
    'recstatus: previousrecording' => '以前に録画されました',
    'recstatus: recorded'          => '録画済',
    'recstatus: recording'         => '録画中',
    'recstatus: repeat'            => '繰り返し',
    'recstatus: stopped'           => '停止',
    'recstatus: toomanyrecordings' => '最大録画数になりました',
    'recstatus: tunerbusy'         => 'チューナーが使用中です',
    'recstatus: unknown'           => '不明',
    'recstatus: willrecord'        => '録画されます',
// includes/recording_schedules.php
    'Dup Method'                   => '重複検知',
    'Profile'                      => 'プロファイル',
    'Sub and Desc (Empty matches)' => 'サブタイトルと内容(エンプティーマッチ)',
    'rectype: finddaily'           => '一日一回',
    'rectype: findweekly'          => '週一回',
// includes/utils.php
    '$1 B'  => '',
    '$1 GB' => '',
    '$1 KB' => '',
    '$1 MB' => '',
    '$1 TB' => '',
// modules/backend_log/init.php
    'Logs' => 'ログ',
// modules/movietimes/init.php
    'Movie Times' => 'ムービータイムス',
// modules/settings/init.php
    'MythTV channel info'      => 'MythTVチャンネル情報',
    'MythTV key bindings'      => 'MythTVキーバインド',
    'MythWeb session settings' => 'MythWebセッション設定',
    'settings'                 => '設定',
// modules/status/init.php
    'Status' => 'ステータス',
// modules/stream/init.php
    'Streaming' => 'ストリーミング',
// modules/tv/detail.php
    'This program is already scheduled to be recorded via a $1custom search$2.' => '',
    'Unknown Program.'                                                          => '不明な番組',
    'Unknown Recording Schedule.'                                               => '不明な予約',
// modules/tv/init.php
    'Special Searches' => 'スペシャル検索',
    'TV'               => '',
// modules/tv/recorded.php
    'No matching programs found.'             => '該当する番組がありません',
    'Showing all programs from the $1 group.' => '$1のすべての番組を表示',
    'Showing all programs.'                   => 'すべての番組を表示',
// modules/tv/schedules_custom.php
    'Any Category'                               => 'いずれかのカテゴリー',
    'Any Channel'                                => 'いずれかのチャンネル',
    'Any Program Type'                           => 'いずれかのタイプ',
    'Find Time must be of the format:  HH:MM:SS' => '',
// modules/tv/schedules_manual.php
    'Use callsign'  => 'コールサインを使用する',
    'Use date/time' => '日時を使用する',
// modules/tv/search.php
    'Please search for something.' => '検索する文字を入力してください。',
// modules/video/init.php
    'Video' => 'ビデオ',
// themes/default/backend_log/welcome.php
    'welcome: backend_log' => 'バックエンドログようこそ！',
// themes/default/header.php
    'Category Legend'                            => 'カテゴリー凡例',
    'Category Type'                              => 'カテゴリータイプ',
    'Custom'                                     => 'カスタム',
    'Edit MythWeb and some MythTV settings.'     => 'MythWebとMythTVの設定',
    'Exact Match'                                => '正確に一致',
    'Fold Duplicates'                            => '',
    'HD Only'                                    => 'HDのみ',
    'Manual'                                     => '手動',
    'MythMusic on the web.'                      => 'MythMusic オンザウェブ',
    'MythVideo on the web.'                      => 'MythVideo オンザウェブ',
    'MythWeb Weather.'                           => 'MythWeb 天気',
    'Search fields'                              => '検索フィールド',
    'Search help'                                => '検索ヘルプ',
    'Search help: movie example'                 => '*** 1/2 アドベンチャー',
    'Search help: movie search'                  => '映画検索',
    'Search help: regex example'                 => '/^Good Eats/',
    'Search help: regex search'                  => '正規表現検索',
    'Search options'                             => '検索オプション',
    'Searches'                                   => '検索メニュー',
    'TV functions, including recorded programs.' => 'TV 録画',
// themes/default/movietimes/welcome.php
    'welcome: movietimes' => 'ムービータイムスようこそ！',
// themes/default/music/music.php
    'Album'               => 'アルバム',
    'Album (filtered)'    => 'アルバム（絞込み）',
    'All Music'           => '全ミュージック',
    'Artist'              => 'アーティスト',
    'Artist (filtered)'   => 'アーティスト（絞込み）',
    'Displaying'          => '表示',
    'Duration'            => '時間',
    'End'                 => '終了',
    'Filtered'            => '抽出',
    'Genre'               => 'ジャンル',
    'Genre (filtered)'    => 'ジャンル（絞込み）',
    'Next'                => '次',
    'No Tracks Available' => 'トラックがありません',
    'Previous'            => '戻る',
    'Top'                 => 'トップ',
    'Track Name'          => 'トラック名',
    'Unfiltered'          => '絞り込みなし',
// themes/default/music/welcome.php
    'welcome: music' => 'ミュージックようこそ！',
// themes/default/settings/channels.php
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
    'sourceid'                                                                                                                           => '',
    'useonairguide'                                                                                                                      => '',
    'videofilters'                                                                                                                       => '',
    'visible'                                                                                                                            => '',
    'xmltvid'                                                                                                                            => '',
// themes/default/settings/keys.php
    'Action'                => 'アクション',
    'Configure Keybindings' => 'キーバンド設定',
    'Context'               => 'コンテキスト',
    'Destination'           => '対象',
    'Edit keybindings on'   => 'キーバインド編集対象',
    'JumpPoints Editor'     => 'ジャンプポイントエディター',
    'Key bindings'          => 'キーバインド',
    'Keybindings Editor'    => 'キーバインドエディター',
    'Set Host'              => 'ホスト設定',
// themes/default/settings/session.php
    'Channel &quot;Jump to&quot;'     => 'チャンネル &quot;移動&quot;',
    'Date Formats'                    => '日付書式',
    'Guide Settings'                  => 'ガイド設定',
    'Hour Format'                     => '時間書式',
    'Language'                        => '言語',
    'Listing &quot;Jump to&quot;'     => '一覧 &quot;移動&quot;',
    'Listing Time Key'                => '一覧 タイムキー',
    'MythWeb Session Settings'        => 'MythWebセッションセッティング',
    'MythWeb Theme'                   => 'MythWebテーマ',
    'Only display favourite channels' => 'お気に入りのチャンネルのみ表示する',
    'Reset'                           => 'リセット',
    'SI Units?'                       => 'SI単位を使用する',
    'Scheduled Popup'                 => '予約ポップアップ',
    'Show descriptions on new line'   => '内容を新しい行で表示する',
    'Status Bar'                      => 'ステータスバー',
    'Weather Icons'                   => '天気アイコン',
    'format help'                     => '書式ヘルプ',
// themes/default/settings/settings.php
    'settings: overview' => '設定概要',
// themes/default/settings/welcome.php
    'welcome: settings' => '設定へようこそ！',
// themes/default/status/welcome.php
    'welcome: status' => 'ステータスへようこそ！',
// themes/default/tv/channel.php
    'Channel Detail' => 'チャンネル詳細',
    'Length'         => '時間',
    'Show'           => '番組',
    'Time'           => '放送時間',
// themes/default/tv/detail.php
    'Back to the program listing'         => '番組一覧に戻る',
    'Back to the recording schedules'     => '録画予約に戻る',
    'Cast'                                => 'キャスト',
    'Directed by'                         => '監督',
    'Don\'t record this program.'         => '録画しない',
    'Episode Number'                      => '番組番号',
    'Exec. Producer'                      => '製作責任者',
    'Find other showings of this program' => 'この番組のほかの放送を見つける',
    'Find showings of this program'       => 'この番組を検索する',
    'Google'                              => '',
    'Guest Starring'                      => 'ゲスト出演',
    'Guide rating'                        => '',
    'Hosted by'                           => '主催',
    'MythTV Status'                       => 'MythTVステータス',
    'Possible conflicts with this show'   => '',
    'Presented by'                        => '提供',
    'Produced by'                         => '製作',
    'Program Detail'                      => '番組詳細',
    'Program ID'                          => '番組ID',
    'TV.com'                              => '',
    'Time Stretch Default'                => 'タイムストレッチ設定',
    'What else is on at this time?'       => 'この時間の番組表',
    'Written by'                          => '著者',
// themes/default/tv/list.php
    'Jump To' => '移動',
// themes/default/tv/list_cell_nodata.php
    'NO DATA' => '',
// themes/default/tv/recorded.php
    '$1 episode'                                          => '$1番組',
    '$1 episodes'                                         => '$1番組',
    '$1 recording'                                        => '$1録画',
    '$1 recordings'                                       => '$1録画',
    'All groups'                                          => '全グループ',
    'Are you sure you want to delete the following show?' => 'この録画を削除してよろしいですか？',
    'Delete'                                              => '削除',
    'Delete $1'                                           => '削除:$1',
    'Delete + Rerecord'                                   => '削除+録画',
    'Delete and rerecord $1'                              => '削除と録画 $1',
    'Go'                                                  => '移動',
    'Show group'                                          => 'グループ表示',
    'Show recordings'                                     => '番組表示',
    'auto-expire'                                         => '自動削除',
    'file size'                                           => 'ファイルサイズ',
    'has bookmark'                                        => 'ブックマーク',
    'has commflag'                                        => 'CMマーク',
    'has cutlist'                                         => 'カットリスト',
    'is editing'                                          => '編集',
    'preview'                                             => 'プレビュー',
// themes/default/tv/schedules.php
    'Any'                                       => '全て',
    'No recording schedules have been defined.' => '予約が設定されていません',
    'channel'                                   => 'チャンネル',
    'profile'                                   => 'プロファイル',
    'transcoder'                                => 'トランスコーダー',
    'type'                                      => 'タイプ',
// themes/default/tv/schedules_custom.php
    'Additional Tables'        => '追加テーブル',
    'Find Date & Time Options' => '日時オプション',
    'Find Day'                 => '曜日指定',
    'Find Time'                => '時間検索',
    'Keyword Search'           => 'キーワードサーチ',
    'People Search'            => 'ピープルサーチ',
    'Power Search'             => 'パワーサーチ',
    'Search Phrase'            => 'サーチフレーズ',
    'Search Type'              => 'サーチタイプ',
    'Title Search'             => 'タイトルサーチ',
// themes/default/tv/schedules_manual.php
    'Channel'      => 'チャンネル',
    'Length (min)' => '時間 (分)',
    'Start Date'   => '開始日',
    'Start Time'   => '開始時間',
// themes/default/tv/search.php
    'No matches found'                 => '一致する物がありませんでした',
    'No matching programs were found.' => '一致する番組がありませんでした',
    'Search for:  $1'                  => '$1 の検索結果',
// themes/default/tv/searches.php
    'Handy Predefined Searches' => 'おてがるサーチ',
    'handy: overview'           => '下のメニューから簡単に検索できます。',
// themes/default/tv/upcoming.php
    'Commands'    => 'コマンド',
    'Conflicts'   => '衝突',
    'Deactivated' => '無効',
    'Duplicates'  => '重複',
    'Scheduled'   => '予約',
// themes/default/tv/welcome.php
    'welcome: tv' => 'テレビへようこそ！',
// themes/default/video/video.php
    'Edit'          => '編集',
    'Reverse Order' => '逆順',
    'Videos'        => 'ビデオ',
    'category'      => 'カテゴリー',
    'cover'         => 'カバー',
    'director'      => '監督',
    'imdb rating'   => 'imdb格付け',
    'plot'          => '脚本',
    'rating'        => '格付け',
    'year'          => '年',
// themes/default/video/welcome.php
    'welcome: video' => 'ビデオにようこそ！',
// themes/default/weather/weather.php
    ' at '               => '',
    'Current Conditions' => '現在の状況',
    'Forecast'           => '予報',
    'High'               => '高',
    'Humidity'           => '湿度',
    'Last Updated'       => '最後の更新',
    'Low'                => '低',
    'Pressure'           => '気圧',
    'Radar'              => 'レーダー',
    'Today'              => '今日',
    'Tomorrow'           => '明日',
    'UV Extreme'         => 'UV 非常に強い',
    'UV High'            => 'UV 強い',
    'UV Index'           => 'UV 指数',
    'UV Minimal'         => 'UV 弱い',
    'UV Moderate'        => 'UV 穏やか',
    'Visibility'         => '視界',
    'Wind'               => '風',
    'Wind Chill'         => '体感温度',
// themes/default/weather/welcome.php
    'welcome: weather' => '天気へようこそ！',
// themes/default/welcome.php
    'Visit $1' => ''
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

