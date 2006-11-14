<?php
/**
 * Class to hold a list of channels, along with
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

class Channel_List {

/** protected @var array   Channel objects for each channel */
    var $channels = array();

/** protected @var array   Channel objects for each channel, by callsign */
    var $callsigns = array();

/**
 * Constructor, duh
/**/
    /* public */
    function __construct() {
        // Don't really have much to do here.  Most stuff is loaded on demand.
    }

/**
 * Legacy constructor
/**/
    /** @deprecated */ function Channel_List() {
        return $this->__construct();
    }




/**
 * Look up a channel by its callsign
/**/
    /* static */
    function &callsign($callsign) {
        #if (empty($this->callsigns)
    }

/**
 * Look up a channel by its chanid
/**/
    /* static */
    function &chanid($chanid) {
    }

}
