<?php

class Video {

    var $intid;
    var $plot;
    var $category;
    var $rating;
    var $title;
    var $director;
    var $inetref;
    var $year;
    var $userrating;
    var $length;
    var $showlevel;
    var $filename;
    var $coverfile;
    var $childid;
    var $url;
    var $cover_url;
    var $browse;
    var $genres;

    function Video($intid) {
        $this->__construct($intid);
    }

    function __construct($intid) {
        global $db;
        global $mythvideo_dir;
        $video = $db->query_assoc('SELECT videometadata.*
                                   FROM videometadata
                                  WHERE videometadata.intid = ?',
                                 $intid
                                 );
        $this->intid        = $intid;
        $this->plot         = $video['plot'];
        $this->category     = $video['category'];
        $this->rating       = $video['rating'];
        $this->title        = $video['title'];
        $this->director     = $video['director'];
        $this->inetref      = $video['inetref'];
        $this->year         = $video['year'] ? $video['year'] : 'Unknown';
        $this->userrating   = $video['userrating'] ? $video['userrating'] : 'Unknown';
        $this->length       = $video['length'];
        $this->showlevel    = $video['showlevel'];
        $this->filename     = $video['filename'];
        $this->coverfile    = $video['coverfile'];
        $this->browse       = $video['browse'];
    // And the artwork URL
        if ($this->coverfile != 'No Cover')
            $this->cover_url = 'data/video_covers/'.substr($this->coverfile, strlen(setting('VideoArtworkDir', hostname)));
        $this->childid      = $video['childid'];
    // Figure out the URL
        $this->url = '#';
        if (file_exists('data/video/'))
            $this->url = root . implode('/', array_map('rawurlencode',
                                             array_map('utf8tolocal',
                                             explode('/',
                                             'data/video/' . preg_replace('#^'.$mythvideo_dir.'/?#', '', $this->filename)
                                       ))));
        $genre = $db->query('SELECT videometadatagenre.idgenre
                               FROM videometadatagenre
                              WHERE videometadatagenre.idvideo = ?',
                            $this->intid
                            );
        while( $id = $genre->fetch_col())
            $this->genres[] = $id;
        $genre->finish();
    }

// This function returns metadata preped for 'ajax' requests to update
    function metadata() {
        global $Category_String;
        $string  = '';
        $string .= 'intid|'.$this->intid            ."\n";
        if (show_video_covers && file_exists($this->cover_url))
            $string .= 'img|<img width="'.video_img_width.'" height="'.video_img_height.'" src="'.root.'data/video_covers/'.basename($this->coverfile).'">'."\n";
        else
            $string .= 'img|<img width="'.video_img_width.'" height="'.video_img_height.'">'."\n";
        $string .= 'title|<a href="'.$this->url.'">'.$this->title.'</a>'."\n".
                   'playtime|'.nice_length($this->length * 60)."\n";

        if (strlen($Category_String[$this->category]))
            $string .= 'category|'.$Category_String[$this->category]."\n";
        else
            $string .= 'category|Uncategorized'."\n";

        if ($this->inetref != '00000000')
            $string .= 'imdb|<a href="http://www.imdb.com/Title?'.$this->inetref.'">'.$this->inetref.'</a>'."\n";
        else
            $string .= 'imdb|'."\n";
        $string .= 'plot|'.$this->plot              ."\n";
        $string .= 'rating|'.$this->rating          ."\n";
        $string .= 'director|'.$this->director      ."\n";
        $string .= 'inetref|'.$this->inetref        ."\n";
        $string .= 'year|'.$this->year              ."\n";
        $string .= 'userrating|'.$this->userrating  ."\n";
        $string .= 'length|'.$this->length          ."\n";
        $string .= 'showlevel|'.$this->showlevel    ."\n";
        return $string;
    }

    function save() {
        global $db;
        $db->query('UPDATE videometadata
                       SET videometadata.plot         = ?,
                           videometadata.category     = ?,
                           videometadata.rating       = ?,
                           videometadata.title        = ?,
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
                    $this->director,
                    $this->inetref,
                    $this->year,
                    $this->userrating,
                    $this->length,
                    $this->showlevel,
                    $this->filename,
                    ( @filesize($this->coverfile) > 0 ? $this->coverfile : 'No Cover' ),
                    $this->browse,
                    $this->intid
                    );

        $db->query('DELETE FROM videometadatagenre
                          WHERE videometadatagenre.idvideo = ?',
                    $this->intid
                    );
        foreach ($this->genres as $genre)
            $db->query('INSERT INTO videometadatagenre ( idvideo, idgenre )
                                                VALUES (       ?,       ? )',
                       $this->intid,
                       $genre
                       );

    }
}
