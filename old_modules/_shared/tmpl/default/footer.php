<?php
/**
 * This footer file is shared by all MythWeb modules.
 *
 * @license     GPL
 *
 * @package     MythWeb
 *
/**/

// Display footnotes
    global $Footnotes;
    if (is_array($Footnotes)) {
        foreach ($Footnotes as $note) {
            echo $note;
        }
    }
?>

<div id="ajax_working" class="hidden">
 <?php echo t('$1 requests pending.', '<span id="ajax_num_requests">0</span>'); ?>
</div>

</body>
</html>

<?php
    flush();
