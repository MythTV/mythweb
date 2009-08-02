<?php
/***                                                                        ***\
    css.php                                  Last Updated: 2005.01.23 (xris)

    a test file for viewing the css settings
\***                                                                        ***/


?>

<html>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<head>
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">

    <Link Rel="stylesheet" HRef="style.css" Type="text/css" Media="screen">

    <title>CSS Test</title>

    <script type="text/javascript" src="js/init.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/mouseovers.js"></script>
    <script type="text/javascript" src="js/visibility.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
</head>

<table width="400" bgcolor="#003060" border="1" cellpadding="0" cellspacing="0">
<tr>
    <td><table width="400" bgcolor="#003060" class="small" cellpadding="5" cellspacing="5">
        <tr>
            <td colspan="3">Category Legend:</td><?php
    $categories = array('Action',
                        'Adult',
                        'Animals',
                        'Art_Music',
                        'Business',
                        'Children',
                        'Comedy',
                        'Crime_Mystery',
                        'Documentary',
                        'Drama',
                        'Educational',
                        'Food',
                        'Game',
                        'Health_Medical',
                        'History',
                        'HowTo',
                        'Horror',
                        'Misc',
                        'News',
                        'Reality',
                        'Romance',
                        'Science_Nature',
                        'SciFi_Fantasy',
                        'Shopping',
                        'Soaps',
                        'Spiritual',
                        'Sports',
                        'Talk',
                        'Travel',
                        'War',
                        'Western',
                        'Unknown');
    $count = 0;
    foreach ($categories as $cat) {
        if ($count++ % 3 == 0)
            echo "\n\t\t</tr><tr>\n";
        echo "\t\t\t<td class=\"cat_$cat\" align=\"center\"><b>$cat</b></td>\n";
    }
        ?>
            <td class="type_movie" align="center"><b>Movies</b></td>
        </tr>
        </table></td>
</tr>
</table>

</body>

</html>
