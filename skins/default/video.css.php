<?php header("Content-type: text/css"); ?>
    .video {
        position:           relative;
        padding:            1em;
        float:              left;
        background-color:   #003366;
        margin-top:         1em;
        margin-left:        1em;
        width:              <?php echo (_or(setting('web_video_thumbnail_width',  hostname),  96)+106); ?>px;
        height:             <?php echo (_or(setting('web_video_thumbnail_height', hostname), 140)+28 ); ?>px;
        border:             1px solid black;
    }

    .video .title {
        font-weight:        bold;
        margin-bottom:      .5em;
        height:             2.25em;
        overflow:           hidden;
    }

    .video img {
        float:              left;
        padding-right:      1em;
    }

    .video .command {
        position:           absolute;
        bottom:             1em;
        right:              1em;
    }

    #path {
        position:           relative;
        padding:            1em;
        float:              left;
        background-color:   #102923;
        margin-top:         1em;
        margin-left:        1em;
        border:             1px solid black;
        min-width:          <?php echo (_or(setting('web_video_thumbnail_width',  hostname),  96)+106); ?>px;
        min-height:         <?php echo (_or(setting('web_video_thumbnail_height', hostname), 140)+28 ); ?>px;
    }

    #path .active {
        color:              yellow;
    }

    #window {
        position:           fixed;
        left:               40%;
        top:                35%;
        background-color:   green;
        width:              20%;
        padding:            1em;
        z-index:            10;
        border:             2px solid gray;
    }

    #window_title {
        position:           absolute;
        top:                1px;
        left:               1em;
        font-weight:        bold;
    }

    .vpopup {
        position:           absolute;
        bottom:             0px;
        right:              0px;
        background-color:   green;
    }
