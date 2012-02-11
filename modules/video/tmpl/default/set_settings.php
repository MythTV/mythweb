<?php
/**
 * Display/save MythVideo settings
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Weather
 *
 **/
?>

<form class="form" method="post" action="<?php echo form_action ?>">
<input type="hidden" name="host" value="<?php echo html_entities($_SESSION['settings']['host']) ?>" />

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <?php
      $imdbType=setting('web_video_imdb_type', $_SESSION['settings']['host']);
    ?>

    <td><?php echo t('web_video_imdb_type'); ?>:</td>
    <td><select name="web_video_imdb_type">
           <option value="IMDB"  <?php if ($imdbType == "IMDB") echo 'SELECTED'; ?> ><?php echo t('IMDBTYPE'); ?></option>
            <option value="ALLOCINE" <?php if ($imdbType == "ALLOCINE") echo 'SELECTED'; ?> ><?php echo t('ALLOCINETYPE'); ?></option>
        </select>
    </td>
</tr>
<tr>
    <td><?php echo t('web_video_imdb_path'); ?>:</td>
    <td><input type="text" name="web_video_imdb_path" size="60" value="<?php echo $imdb_path; ?>"></td>
</tr>
<tr>
    <td><?php echo t('web_video_thumbnail_width'); ?>:</td>
    <td><input type="text" name="web_video_thumbnail_width" size="60" value="<?php echo _or(setting('web_video_thumbnail_width', $_SESSION['settings']['host']), 94); ?>"></td>
</tr>
<tr>
    <td><?php echo t('web_video_thumbnail_height'); ?>:</td>
    <td><input type="text" name="web_video_thumbnail_height" size="60" value="<?php echo _or(setting('web_video_thumbnail_height', $_SESSION['settings']['host']), 140); ?>"></td>
</tr>

<tr>
    <td><?php echo t('Default MythVideo View'); ?>:</td>
    <td><input type="text" name="DefaultMythVideoView" size="60" value="<?php echo setting('Default MythVideo View', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoAggressivePC'); ?>:</td>
    <td><input type="text" name="VideoAggressivePC" size="60" value="<?php echo setting('VideoAggressivePC', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoArtworkDir'); ?>:</td>
    <td><input type="text" name="VideoArtworkDir" size="60" value="<?php echo setting('VideoArtworkDir', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoBrowserNoDB'); ?>:</td>
    <td><input type="text" name="VideoBrowserNoDB" size="60" value="<?php echo setting('VideoBrowserNoDB', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoDefaultParentalLevel'); ?>:</td>
    <td><input type="text" name="VideoDefaultParentalLevel" size="60" value="<?php echo setting('VideoDefaultParentalLevel', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoDefaultPlayer'); ?>:</td>
    <td><input type="text" name="VideoDefaultPlayer" size="60" value="<?php echo setting('VideoDefaultPlayer', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoGalleryAspectRatio'); ?>:</td>
    <td><input type="text" name="VideoGalleryAspectRatio" size="60" value="<?php echo setting('VideoGalleryAspectRatio', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoGalleryColsPerPage'); ?>:</td>
    <td><input type="text" name="VideoGalleryColsPerPage" size="60" value="<?php echo setting('VideoGalleryColsPerPage', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoGalleryRowsPerPage'); ?>:</td>
    <td><input type="text" name="VideoGalleryRowsPerPage" size="60" value="<?php echo setting('VideoGalleryRowsPerPage', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoGalleryNoDB'); ?>:</td>
    <td><input type="text" name="VideoGalleryNoDB" size="60" value="<?php echo setting('VideoGalleryNoDB', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoGallerySubtitle'); ?>:</td>
    <td><input type="text" name="VideoGallerySubtitle" size="60" value="<?php echo setting('VideoGallerySubtitle', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoListUnknownFiletypes'); ?>:</td>
    <td><input type="text" name="VideoListUnknownFiletypes" size="60" value="<?php echo setting('VideoListUnknownFiletypes', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoNewBrowsable'); ?>:</td>
    <td><input type="text" name="VideoNewBrowsable" size="60" value="<?php echo setting('VideoNewBrowsable', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoStartupDir'); ?>:</td>
    <td><input type="text" name="VideoStartupDir" size="60" value="<?php echo setting('VideoStartupDir', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoTreeLoadMetaData'); ?>:</td>
    <td><input type="text" name="VideoTreeLoadMetaData" size="60" value="<?php echo setting('VideoTreeLoadMetaData', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('VideoTreeNoDB'); ?>:</td>
    <td><input type="text" name="VideoTreeNoDB" size="60" value="<?php echo setting('VideoTreeNoDB', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('mythvideo.sort_ignores_case'); ?>:</td>
    <td><input type="text" name="mythvideosort_ignores_case" size="60" value="<?php echo setting('mythvideo.sort_ignores_case', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('mythvideo.db_folder_view'); ?>:</td>
    <td><input type="text" name="mythvideodb_folder_view" size="60" value="<?php echo setting('mythvideo.db_folder_view', $_SESSION['settings']['host']); ?>"></td>
</tr>
<tr>
    <td><?php echo t('mythvideo.ImageCacheSize'); ?>:</td>
    <td><input type="text" name="mythvideoImageCacheSize" size="60" value="<?php echo setting('mythvideo.ImageCacheSize', $_SESSION['settings']['host']); ?>"></td>
</tr>

<tr>
    <td align="center"><input type="reset" class="submit" value="<?php echo t('Reset') ?>"></td>
    <td align="center"><input type="submit" class="submit" name="save" value="<?php echo t('Save') ?>"></td>
</tr>
</table>

</form>
