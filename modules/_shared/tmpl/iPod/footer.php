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
?>

    <script type="text/javascript" language="javascript">
    // Images to preload!
    // Once iSafari starts a new page load,
    // it refuses to load other images
    // so background-images changes fail
        var Image1 = new Image();
        Image1.src = '<?php echo skin_url; ?>/img/chevron_touched.png';
        var Image2 = new Image();
        Image2.src = '<?php echo skin_url; ?>/img/item_background_touched.png';
        var Image3 = new Image();
        Image3.src = '<?php echo skin_url; ?>/img/back_button_clicked.png';
        var Image4 = new Image();
        Image4.src = '<?php echo skin_url; ?>/img/button_darkgray_pressed.png';
    </script>

</body>
</html>
