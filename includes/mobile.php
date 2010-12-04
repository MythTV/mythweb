<?php
/**
 * Copyright (C) 2005 Jerome Rannikko <jeromer@hotpop.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *
 * This file contains functions to detect mobile user agents and to get
 * information about their screen sizes. This information enables the
 * development of very detailed themes/layouts for mobile devices. This
 * code is intented to be easily re-usable in different applications.
 *
 * @license     GPL
 *
 * @package     MythWeb
/**/


/**
 * Return true if the user agent is mobile device. Otherwise return false.
 * The user agent is determined based on the return value of getScreenSize()
 * which is false if the user agent is not a mobile device.
 *
 * @return true or false
 */
function isMobileUser() {
  return (getScreenSize() === false) ? false : true;
}


/**
 * Return the screen size of the mobile user agent. This can be used to do very
 * detailed modifications to the web site's layout for the mobile user agents.
 * If the user is not regocnized to be a mobile device then return false. If the
 * user is a known mobile device but the screen size is unknown then return
 * an empty array. Mobile users are detected based on $_SERVER['HTTP_USER_AGENT']
 * and a list of known mobile user agent identification strings.
 *
 * @return array(width, height) or false
 */
function getScreenSize() {
  static $isChecked = false;
  static $screen = false;

  if (!$isChecked) {
    /*
     * The $mobiles array contains a list of known mobile phone user agent
     * identification strings. Each key of the array is a substring of the
     * actual UA string and the corresponding value is an array that stores
     * the width and the height of the mobile device's screen size.
     *
     * If you want to add more mobile phone models just add new lines following
     * the same structure than in the existing ones. The more specific substring
     * you use to match the UA string, the higher up in the list it should be.
     * If it's very generic then add it at the end of the array.
     *
     * If you don't know the screensize of some mobile terminal then use
     * an empty array or approximate dimensions.
     */
    $mobiles = array(
                /* Phones using the Series 60 platform, e.g. Nokia 3650 and 6600. */
                    'Series 60'  => array('width' => 176, 'height' => 208),
                    'Series60'   => array('width' => 176, 'height' => 208),
                    'C500'       => array('width' => 176, 'height' => 220), // SPV C500
                /* Phones using the Series 90 platform, e.g. Nokia 7710. */
                    'Series 90'  => array('width' => 640, 'height' => 320),
                    'Series90'   => array('width' => 640, 'height' => 320),
                /* HTC Tornado */
                    '176x220'    => array('width' => 176, 'height' => 220),
                /* The following strings are added for the Palm browser WebPro
                 * WebPro sometimes supplies the screen dimensions, but sometimes not
                /* but we try to detect the best as possible */
                    '240x320'    => array('width' => 240, 'height' => 320), // PocketPC IE
                    '320x320'    => array('width' => 320, 'height' => 320), // For all Palm Tungsten models
                    '320x480'    => array('width' => 320, 'height' => 480), // For Palm Tungsten T
                    '480x320'    => array('width' => 480, 'height' => 320), // For Palm Tungsten T
                    '320x480x16' => array('width' => 320, 'height' => 480), // For Palm Tungsten T
                    '480x320x16' => array('width' => 480, 'height' => 320), // For Palm Tungsten T
                    '320x320x16' => array('width' => 320, 'height' => 320),
                    'WebPro'     => array('width' => 320, 'height' => 320), // For all Palm Tungsten models

                /* Opera for mobile devices. */
                    'Opera Mini' => array(),

                /* Minimo - Mozilla Firefox mobile browser */
                    'Minimo'     => array(),

                /* A generic mobile phone using Symbian OS. All Symbian phones don't
                 * necessarily have the same screen size so if you want to include
                /* some specific Symbian phones then place them above this line. */
                    'Symbian'    => array('width' => 176, 'height' => 208),

                /* A generic entry for Windows Mobile 5 and possible other
                 * Windows Mobile and CE versions.  Several browsers all sent this
                /* in their connection strings. */
                    'Windows CE' => array(),

                /* Lots of other random mobile browsers */
                    'Nokia' => array(), // Nokia phones and emulators
                    'Eric'  => array(), // Ericsson WAP phones and emulators
                    'WapI'  => array(), // Ericsson WapIDE 2.0
                    'MC21'  => array(), // Ericsson MC218
                    'AUR '  => array(), // Ericsson R320
                    'R380'  => array(), // Ericsson R380
                    'UP.B'  => array(), // UP.Browser
                    'WinW'  => array(), // WinWAP browser
                    'UPG1'  => array(), // UP.SDK 4.0
                    'upsi'  => array(), // another kind of UP.Browser ??
                    'QWAP'  => array(), // unknown QWAPPER browser
                    'Jigs'  => array(), // unknown JigSaw browser
                    'Java'  => array(), // unknown Java based browser
                    'Alca'  => array(), // unknown Alcatel-BE3 browser (UP based?)
                    'MITS'  => array(), // unknown Mitsubishi browser
                    'MOT-'  => array(), // unknown browser (UP based?)
                    'My S'  => array(), // unknown Ericsson devkit browser ?
                    'WAPJ'  => array(), // Virtual WAPJAG www.wapjag.de
                    'fetc'  => array(), // fetchpage.cgi Perl script from www.wapcab.de
                    'ALAV'  => array(), // yet another unknown UP based browser ?
                    'Wapa'  => array(), // another unknown browser (Web based "Wapalyzer"?)
                    'LGE-'  => array(), // LG phones

                 /* For debugging: you can try out the mobile mode without a mobile phone.
                  * Replace 'Opera' with your browser. Comment out for release version. */
                     //'Opera' => array('width' => 176, 'height' => 208)
             );

    /* Scan through $mobiles and try to find matching user agent. */
    foreach (array_keys($mobiles) as $needle) {
      /* Check if user agent matches this screen size key. */
      if (strpos($_SERVER['HTTP_USER_AGENT'], $needle) !== false) {
        $screen = $mobiles[$needle];
        break;
      }
    }

// If the user agent was not in our list, check if the terminal accepts WAP.
    if ($screen === false) {
      if (browserAcceptsMediaType(array('WAP'))) {
        $screen = array();
      }
    }

    $isChecked = true;
  }
  return $screen;
}


/**
 * Check if the browser accepts any of the media types given in the parameter array.
 * The media types can be either in the form of 'text/html' or just 'html'. All parameter
 * values are turned upper case.
 *
 * @return true if the browser accepts any of the media types, false if none,
 * and null if $mediaTypes is not an array
 */
function browserAcceptsMediaType($mediaTypes) {
  if (!is_array($mediaTypes)) {
    return null;
  }

  $mediaTypes = strtoupper(implode('|', $mediaTypes));
  return preg_match("#$mediaTypes#", strtoupper($_SERVER['HTTP_ACCEPT'])) ? true : false;
}


/**
 * Return the width of the screen in pixels. Meant to be called if isMobileUser()
 * returns true. See also getScreensize().
 *
 * @return width of the screen in pixels if known or null
 */
function getScreenWidth() {
  $screen = getScreenSize();
  return isset($screen['width']) ? $screen['width'] : null;
}


/**
 * Return the height of the screen in pixels. Meant to be called if isMobileUser()
 * returns true. See also getScreensize().
 *
 * @return height of the screen in pixels
 */
function getScreenHeight() {
  $screen = getScreenSize();
  return isset($screen['height']) ? $screen['height'] : null;
}
