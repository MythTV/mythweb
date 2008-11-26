<?php
/**
 * Initialization routines for the MythFrontend Remote Control
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  Remote
 *
/**/

    if (tmpl == 'default' || tmpl == 'iPod') {
    // Load the list of known frontends, since other areas of MythWeb might
    // want to use them, too.
        require_once 'includes/mythfrontend.php';
    // Add the module
        $Modules['remote'] = array('path'        => 'remote',
                                   'sort'        => 6,
                                   'name'        => t('Remote'),
                                   'links'       => array(#'jump' => t('Jump Points'),
                                                          'keys' => t('Key Controls'),
                                                          #'play' => t('Play'),
                                                         ),
                                  );
    }
