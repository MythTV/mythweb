<?php

class Video {

    var $intid;
    var $plot;
    var $category;
    var $rating;
    var $title;
    var $subtitle;
    var $season;
    var $episode;
    var $director;
    var $inetref;
    var $year;
    var $userrating;
    var $length;
    var $showlevel;
    var $filename;
    var $cover_file;
    var $cover_url;
    var $cover_scaled_width     = video_img_width;
    var $cover_scaled_height    = video_img_height;
    var $childid;
    var $url;
    var $browse;
    var $genres;

    function Video($intid) {
        $this->__construct($intid);
    }

    function __construct($intid) {
        global $db;
        global $mythvideo_dir;

    // Video storage directories
        $video_dirs = $db->query_list('
            SELECT  dirname
            FROM    storagegroup
            WHERE   groupname="Coverart"
        ');

        $video = $db->query_assoc('
            SELECT  *
            FROM    videometadata
            WHERE   intid = ?',
            $intid);
        $this->intid        = $intid;
        $this->plot         = $video['plot'];
        $this->category     = $video['category'];
        $this->rating       = $video['rating'];
        $this->title        = $video['title'];
        $this->subtitle     = $video['subtitle'];
        $this->season       = $video['season'];
        $this->episode      = $video['episode'];
        $this->director     = $video['director'];
        $this->inetref      = $video['inetref'];
        $this->year         = $video['year'] ? $video['year'] : t('Unknown');
        $this->userrating   = $video['userrating'] ? $video['userrating'] : t('Unknown');
        $this->length       = $video['length'];
        $this->showlevel    = $video['showlevel'];
        $this->filename     = $video['filename'];
        $this->cover_file   = $video['coverfile'];
        $this->browse       = $video['browse'];
    // And the artwork URL
        $this->cover_url = '';
        if ($this->cover_file && $this->cover_file != 'No Cover') {
            $exists = false;
            foreach ($video_dirs as $dir) {
                $path = preg_replace('#/+#', '/', "$dir/$this->cover_file");
                if (file_exists($path) && is_executable(dirname($path))) {
                    $exists = true;
                    break;
                }
            }
            if ($exists) {
                $this->cover_url = 'pl/coverart/'.$this->cover_file;
                $this->cover_file = $path;
                list($width, $height) = @getimagesize($this->cover_file);
                if ($width > 0 && $height > 0) {
                    $wscale = video_img_width / $width;
                    $hscale = video_img_height / $height;
                    $scale = $wscale < $hscale ? $wscale : $hscale;
                    $this->cover_scaled_width  = floor($width * $scale);
                    $this->cover_scaled_height = floor($height * $scale);
                }
            }
        }
        $this->childid = $video['childid'];
    // Figure out the URL
        $this->url = '#';
    //// all junk, replacing
//        if (file_exists('data/video/'))
//            $this->url = implode('/', array_map('rawurlencode',
//                                             array_map('utf8tolocal',
//                                             explode('/',
//                                             'data/video/' . preg_replace('#^'.$mythvideo_dir.'/?#', '', $this->filename)
//                                       ))));
        $this->url = 'video/stream?Id=' . $this->intid;
        $genre = $db->query('SELECT idgenre
                               FROM videometadatagenre
                              WHERE idvideo = ?',
                            $this->intid
                            );
        while( $id = $genre->fetch_col()) {
            $this->genres[] = $id;
        }
        $genre->finish();
    }

// This function returns metadata preped for 'ajax' requests to update
    function metadata() {
        global $Category_String;
        return array( 'intid'       => $this->intid,
                      'img'         => '<img width="'.$this->cover_scaled_width.'" height="'.$this->cover_scaled_height.'" alt="'.t('Missing Cover').'"'
                                       .(($_SESSION["show_video_covers"] && file_exists($this->cover_url)) ? ' src="data/video_covers/'.basename($this->cover_file).'"' : '')
                                       .'>',
                      'title'       => '<a href="'.$this->url.'">'.$this->title.'</a>',
                      'subtitle'    => $this->subtitle,
                      'season'      => $this->season,
                      'episode'     => $this->episode,
                      'playtime'    => nice_length($this->length * 60),
                      'category'    => strlen($Category_String[$this->category]) ? $Category_String[$this->category] : t('Uncategorized'),
                      'imdb'        => ($this->inetref != '00000000') ? '<a href="http://www.imdb.com/Title?'.$this->inetref.'">'.$this->inetref.'</a>' : '',
                      'plot'        => $this->plot,
                      'rating'      => $this->rating,
                      'director'    => $this->director,
                      'inetref'     => $this->inetref,
                      'year'        => $this->year,
                      'userrating'  => $this->userrating,
                      'length'      => $this->length,
                      'showlevel'   => $this->showlevel
                    );
    }

    function save() {
        global $db;
        $db->query('UPDATE videometadata
                       SET videometadata.plot         = ?,
                           videometadata.category     = ?,
                           videometadata.rating       = ?,
                           videometadata.title        = ?,
                           videometadata.subtitle     = ?,
                           videometadata.season       = ?,
                           videometadata.episode      = ?,
                           videometadata.director     = ?,
                           videometadata.inetref      = ?,
                           videometadata.year         = ?,
                           videometadata.userrating   = ?,
                           videometadata.length       = ?,
                           videometadata.showlevel    = ?,
                           videometadata.filename     = ?,
                           videometadata.coverfile    = ?,
                           videometadata.browse       = ?
                     WHERE videometadata.intid        = ?',
                    $this->plot,
                    $this->category,
                    $this->rating,
                    $this->title,
                    $this->subtitle,
                    $this->season,
                    $this->episode,
                    $this->director,
                    $this->inetref,
                    $this->year,
                    $this->userrating,
                    $this->length,
                    $this->showlevel,
                    $this->filename,
                    ( @filesize($this->cover_file) > 0 ? $this->cover_file : 'No Cover' ),
                    $this->browse,
                    $this->intid
                    );

        $db->query('DELETE FROM videometadatagenre
                          WHERE videometadatagenre.idvideo = ?',
                    $this->intid
                    );
        if (count($this->genres) > 0)
            foreach ($this->genres as $genre)
                $db->query('INSERT INTO videometadatagenre ( idvideo, idgenre )
                                                    VALUES (       ?,       ? )',
                           $this->intid,
                           $genre
                           );

    }
}
?>
