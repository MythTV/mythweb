<?php
/**
 * Should contain one variable, a hash of the 'advanced' searches.
 * Each of these searches will show up as an advanced search
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

$Canned_Searches = array(

    t('New Titles, Premieres')                              // See proglist.cpp
        => 'program.manualid = 0'
         . ' AND ('
         . '   (program.previouslyshown = 0'
         . '     AND (program.category = "Special"'
         . '       OR program.programid LIKE "EP%0001"'
         . '       OR (program.category_type = "series"'
         . '         AND program.subtitle = "Pilot"))'
         . '     AND DAYOFYEAR(program.originalairdate) ='
         . '         DAYOFYEAR(program.starttime))'
         . '   OR (program.category_type="movie"'
         . '     AND program.stars > 0.5'
         . '     AND program.airdate >= YEAR(NOW()) - 3)'
         . ' )',

    t('Movies')
        => 'category_type="movie"',

    t('Movies, 3&frac12; Stars or more')
        => 'category_type="movie" AND program.stars > 0.8',

    t('Movies, Stinkers (2 Stars or less)')
        => 'category_type="movie" AND program.stars < 0.5625'
          .' AND program.stars > 0.0',

    t('Children\'s Movies')
        => 'category="children" AND category_type="movie"',

    t('Non-Series HDTV')
        => 'hdtv & 1 AND category_type != "series"',

    t('All HDTV')
        => 'hdtv & 1',

    t('Non-Music Specials')
        => 'showtype="special" AND program.category NOT LIKE "music%"',

    t('Music Specials')
        => 'showtype="special" AND program.category LIKE "music%"',

    t('Science Fiction Movies')
        => 'category_type="movie" AND program.category="science fiction"',

    );
