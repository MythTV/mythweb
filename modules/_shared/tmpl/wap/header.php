<?php
/**
 * WAP header
 *
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
    <base href="<?php echo root_url; ?>">
    <title><?php echo html_entities($page_title) ?></title>
    <Link Rel="stylesheet" HRef="<?php echo skin_url ?>style.css" Type="text/css" Media="screen">
    <Link Rel="stylesheet" HRef="<?php echo skin_url ?>handheld.css" Type="text/css" Media="handheld">
    <meta name="robots" content="noindex, nofollow">
</head>

<body bgcolor="#003060" text="#DEDEDE" link="#3181B4" alink="#CC0000" vlink="#3181B4">

<center><img src="<?php echo skin_url ?>img/mythtv-logo.gif" border="0" alt="MythTV"><br />

    <span class="menu">
        <a href="<?php echo root_url ?>tv/list"><?php echo t('Listings') ?></a><br />
        <a href="<?php echo root_url ?>tv/upcoming"><?php echo t('Upcoming Recordings') ?></a><br />
        <a href="<?php echo root_url ?>tv/recorded"><?php echo t('Recorded Programs') ?></a><br />
        <a href="<?php echo root_url ?>status"><?php echo t('Backend Status') ?></a><br />
    </span>

</center><br />
<form action="<?php echo root_url ?>tv/search" method="get">
        <center><input type="text" name="s" value="<?php echo $_GET['s'] ?>"><br />
        <input type="submit" class="submit" name="search" value="<?php echo t('Search') ?>"></center><br />
</form>
