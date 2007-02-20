<?php
/**
 * This footer file is shared by all MythWeb modules.
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

// Display footnotes
    global $Footnotes;
    if (is_array($Footnotes)) {
        foreach ($Footnotes as $note) {
            echo $note;
        }
    }
?>

<div id="ajax_working" class="hidden">
 <?php echo t('<span id=\'ajax_num_requests\'>0</span> requests pending.'); ?>
</div>

</body>
</html>
