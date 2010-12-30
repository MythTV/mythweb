<?php
/**
 * WAP footer
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

</body>
</html>
