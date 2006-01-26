<?php
/**
 * This header file is shared by all MythWeb modules.
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// UTF-8 content
    header("Content-Type: text/html; charset=utf-8");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <title><?php echo htmlentities($page_title) ?></title>
    <Link Rel="stylesheet" HRef="<?php echo theme_dir ?>style.css" Type="text/css" Media="screen">
    <Link Rel="stylesheet" HRef="<?php echo theme_dir ?>handheld.css" Type="text/css" Media="handheld">
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<center><img src="<?php echo theme_url ?>img/mythtv-logo.gif" border="0" alt="MythTV" style="behavior: url('<?php echo theme_dir ?>pngbehavior.htc');"><br />

    <span class="menu">
        <a href="<?php echo root ?>tv/list"><?php echo t('Listings') ?></a><br />
        <a href="<?php echo root ?>tv/upcoming"><?php echo t('Upcoming Recordings') ?></a><br />
        <a href="<?php echo root ?>tv/recorded"><?php echo t('Recorded Programs') ?></a><br />
        <a href="<?php echo root ?>status"><?php echo t('Backend Status') ?></a><br />
    </span>

</center><br />
<form action="<?php echo root ?>tv/search" method="post">
        <center><input type="text" name="searchstr" value="<?php echo $_GET['searchstr'] ?>"><br />
        <input type="submit" class="submit" value="search"></center><br />
</form>

