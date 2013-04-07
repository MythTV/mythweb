<script type="text/javascript">
<!--

// Toggle showing of the advanced schedule options
    function toggle_advanced(show) {
        if (show) {
            $('schedule_advanced').style.display     = 'block';
            $('schedule_advanced_off').style.display = 'none';
            $('show_advanced').style.display         = 'none';
            $('hide_advanced').style.display         = 'inline';
        }
        else {
            $('schedule_advanced').style.display     = 'none';
            $('schedule_advanced_off').style.display = 'block';
            $('show_advanced').style.display         = 'inline';
            $('hide_advanced').style.display         = 'none';
        }
    // Toggle the session setting, too.
        new Ajax.Request('<?php echo root_url ?>tv/detail?=',
                         {
                            parameters: 'show_advanced_schedule='+(show ? 1 : '0'),
                          asynchronous: true
                         }
                        );
    }

    // Tries to populate the inetref, season and episode fields
    // by doing a metadata lookup against the backend.  If multiple
    // results are return displays a dialog to let the user choose
    // the appropriate show
    function lookupMetadata(success, failure) {
        ajax_add_request();

        new Ajax.Request('<?php echo root_url ?>tv/lookup_metadata',
                         {
                            parameters: {
                                              'title'        : "<?php echo $schedule->title ?>",
                                              'subtitle'     : "<?php echo $schedule->subtitle ?>",
                                              'inetref'      : $("inetref").value,
                                              'season'       : $("season").value,
                                              'episode'      : $("episode").value,
                                              'allowgeneric' : "true"
                                        },
                            asynchronous: true,
                            method: 'get',
                            onSuccess: success,
                            onFailure: failure
                         }
                        );
    }

    // callback for when metadata is returned for this show
    function onMetadata(transport) {
        ajax_remove_request();

        // make sure we got valid date
        if (!transport || !transport.responseJSON || !transport.responseJSON.VideoLookupList) {
           messageDialog("<?php echo t("Metadata Lookup Error")?>",
                         "<?php echo t("Server returned invalid data when attempting to retrieve metadata.")?>");
        }

        var list = transport.responseJSON.VideoLookupList;

        // display an error if there's no data
        if (list.Count == 0) {
            messageDialog("<?php echo t("Metadata Lookup")?>", "<?php echo t("No metadata results found.")?>");

        // populate the data immediately if there is one result
        } else  if (list.Count == 1) {
          updateMetadata(list.VideoLookups[0]);

        // if we can pick the right item from the list then use it
        // otherwise display a dialog for the user to choose which result
        } else {
            var item = guessItem(list);
            if (item) {
                updateMetadata(item);
            } else {
                multipleResultDialog(list);
            }
        }
    }

    // tries to find the correct item in list based off of the TMSref
    // if we can find it, cool, if not return null
    function guessItem(list) {
        var tmsRef = "<?php echo $schedule->seriesid ?>";
        for (var i=0; i < list.VideoLookups.length; i++) {
            var item = list.VideoLookups[i];
            if (tmsRef && item.TMSRef == tmsRef) {
               return item;
            }
        }
        return null;
    }

    // updates the inetref, season & episode values on the page
    // optionally creates or updates a "metdata home page" link
    // in the "More" section of the page
    function updateMetadata(item) {
         $("inetref").value = item.Inetref;
         $("season").value = item.Season;
         $("episode").value = item.Episode;

         // if the item has a real HomePage then update it
         if (!!item.HomePage) {
             updateHomePage(item);

         // otherwise do a lookup again
         } else {
             lookupMetadata(onHomePage, onMetadataFailure);
         }

    }

    function onHomePage(transport) {
        ajax_remove_request();

        var fakeItem = {HomePage: ""};

        // make sure we got valid data; if not ignore
        if (!transport || !transport.responseJSON || !transport.responseJSON.VideoLookupList) {
            updateHomePage(fakeItem);
            return;
        }

        var list = transport.responseJSON.VideoLookupList;

        // ignore if there's no data
        if (list.Count == 0) {
            updateHomePage(fakeItem);
            return;

        // populate the data immediately if there is one result
        } else  if (list.Count == 1) {
           updateHomePage(list.VideoLookups[0]);

        // if we can pick the right item from the list then use it
        // otherwise hich result
        } else {
           var item = guessItem(list);
           if (item) {
                updateMetadata(item);
           } else {
                updateHomePage(fakeItem);
           }
        }


    }

    // displays a dialog with an image and title of each possible show
    // if the user clicks on one of them then populates the metadata in the page
    function multipleResultDialog(list) {
        // parent div for the result
        var parent = new Element("div", {"class": "multiple-metadata"});

        // add all of the results
        parent.insert(generateResults(list));

        // add a cancel "button" to exit without choosing an option
        var a = new Element("a", {}).update("<?php echo t("Cancel") ?>");
        Event.observe(a, "click", function() { Dialogs.close(); });
        var d = new Element("div", {"class": "commands"});
        d.insert(a);
        parent.insert(d);

        // display the dialog
        new Dialog({
                opacity: 0.9,
                title: "<?php echo t("Select the correct show")?>",
                content: parent
                }).open();
    }

    // returns a div with a list of all of the items neatly formatted
    function generateResults(list) {
        var div = new Element("div", {"class": "metadata-list"});

        for (var i=0; i < list.VideoLookups.length; i++) {
            div.insert(generateResultsItem(list.VideoLookups[i]));
        }

       return div;
    }

    // returns a div for a single result
    // includes hover and click event handlers
    function generateResultsItem(item) {
        var div = new Element("div", {"class": "metadata-item"});
        Event.observe(div, "mouseover", function(e) { this.addClassName("hover");});
        Event.observe(div, "mouseout", function(e) { this.removeClassName("hover");});
        Event.observe(div, "click", function(e) { updateMetadata(item); Dialogs.close();});
        var img = generateItemImg(item);
        div.insert(img);
        var title = new Element("div", {"class": "title"});
        var titleString = item.Title;
        if (item.Year && item.Year > 0) {
            var suffix = " (" + item.Year + ")";
            titleString = titleString.endsWith(suffix) ? titleString : titleString + suffix;
        }

        title.update(titleString);
        div.insert(title);

        var desc = new Element("div", {"class": "description"});
        var descString = item.Description.length > 450 ? item.Description.substring(0, 450) + "..." : item.Description;
        desc.update(descString);
        div.insert(desc);

        return div;
    }

    // generates an image or empty div based on if there is
    // any thumbnail art work for this item
    function generateItemImg(item) {
        if (item.Artwork && item.Artwork.length) {
             var art = item.Artwork[0];
             var thumbUrl = art.Thumbnail;

             // hack to allow proxying of ttvdb.com images since they don't allow hot linking
             if (<?php echo $_SERVER['HTTPS'] == 'on' ? "false" : "true"?> &&  thumbUrl.startsWith("http://www.thetvdb.com")) {
                 thumbUrl = "<?php echo root_url ?>tv/ttvdb_proxy?url=" + thumbUrl.substring(22);
             }

             return new Element("img", {src: thumbUrl, "class": art.Type});
        }
        return new Element("div", {"class": "no-art"});
    }

    // callback for failure contacting the server
    function onMetadataFailure(response) {
        ajax_remove_request();
        messageDialog("<?php echo t("Metadata Lookup Error")?>", "<?php echo t("Error contacting server to retrieve metadata.")?>");
    }

    // displays a dialog with a message in it and an OK button
    function messageDialog(title, msg) {
        $("metadata-message").update(msg);
        new Dialog({
                opacity: 0.9,
                title: title,
                target:{
                    id:'message-dialog',
                    auto:true
                }
                }).open();

    }

    // Hook to start up the Dialog JS
    Dialogs.load();

// -->
</script>
            <h3><?php echo t('Advanced Options') ?>:</h3>
            (<?php
                echo '<a onclick="toggle_advanced(false); return false;" id="hide_advanced"';
                if (!$_SESSION['tv']['show_advanced_schedule'])
                    echo ' style="display: none"';
                echo '>', t('Hide'), '</a>',
                     '<a onclick="toggle_advanced(true)"  id="show_advanced"';
                if ($_SESSION['tv']['show_advanced_schedule'])
                    echo ' style="display: none"';
                echo '>', t('Display'), '</a>';
            ?>)

            <div id="schedule_advanced_off"<?php
                if ($_SESSION['tv']['show_advanced_schedule']) echo ' style="display: none"'
                ?>>
                <?php echo t('info: hidden advanced schedule') ?>
            </div>

            <dl class="clearfix" id="schedule_advanced"<?php
                if (!$_SESSION['tv']['show_advanced_schedule']) echo ' style="display: none"'
                ?>>
                <dt><?php echo t('Recording Profile') ?>:</dt>
                <dd><?php profile_select($schedule->profile) ?></dd>
                <dt><?php echo t('Transcoder') ?>:</dt>
                <dd><?php transcoder_select($schedule->transcoder) ?></dd>
                <dt><?php echo t('Recording Group') ?>:</dt>
                <dd><?php recgroup_select($schedule) ?></dd>
                <dt><?php echo t('Storage Group') ?>:</dt>
                <dd><?php storagegroup_select($schedule->storagegroup) ?></dd>
                <dt><?php echo t('Playback Group') ?>:</dt>
                <dd><?php playgroup_select($schedule->playgroup, 'playgroup', $schedule) ?></dd>
                <dt><?php echo t('Recording Priority') ?>:</dt>
                <dd><select name="recpriority"><?php
                    for ($i=99; $i>=-99; --$i) {
                        echo "<option value=\"$i\"";
                        if ($schedule->recpriority == $i)
                            echo ' SELECTED';
                        echo ">$i</option>";
                    }
                    ?></select></dd>
                <dt><?php echo t('Duplicate Check method') ?>:</dt>
                <dd><select name="dupmethod"><?php
                        echo '<option value="1"';
                        if ($schedule->dupmethod == 1)
                            echo ' SELECTED';
                        echo '>' . t('None') . '</option>';
                        echo '<option value="2"';
                        if ($schedule->dupmethod == 2)
                            echo ' SELECTED';
                        echo '>' . t('Subtitle') . '</option>';
                        echo '<option value="4"';
                        if ($schedule->dupmethod == 4)
                            echo ' SELECTED';
                        echo '>' . t('Description') . '</option>';
                        echo '<option value="6"';
                        if ($schedule->dupmethod == 6 || $schedule->dupmethod == 0)
                            echo ' SELECTED';
                        echo '>'.t('Subtitle and Description').'</option>';
                        echo '<option value="8"';
                        if ($schedule->dupmethod == 8)
                            echo ' SELECTED';
                        echo '>'.t('Subtitle then Description').'</option>';

                   ?></select></dd>
                <dt><?php echo t('Check for duplicates in') ?>: </dt>
                <dd><select name="dupin"><?php
                        $allOn = ($schedule->dupin & dupsin_all )== dupsin_all;
                        echo '<option value="', dupsin_all, '"';
                        if ($allOn || $schedule->dupin == 0)
                            echo ' SELECTED';
                        echo '>' . t('All recordings') . '</option>';
                        echo '<option value="', dupsin_recorded, '"';
                        if (!($allOn) && $schedule->dupin & dupsin_recorded)
                            echo ' SELECTED';
                        echo '>' . t('Current recordings') . '</option>';
                        echo '<option value="', dupsin_oldrecorded,'"';
                        if (!($allOn) && $schedule->dupin & dupsin_oldrecorded)
                            echo ' SELECTED';
                        echo '>' . t('Previous recordings') . '</option>';
                   ?></select></dd>
                <dt><?php echo t('Preferred Input') ?>:</dt>
                <dd><?php input_select($schedule->prefinput, 'prefinput') ?></dd>
                <dt><?php echo t('Internet Reference #') ?>:</dt>
                <dd class="commands"><input id="inetref" class="inetref" type="text" name="inetref" value="<?php echo html_entities($schedule->inetref) ?>"><a onclick="lookupMetadata(onMetadata, onMetadataFailure); return false;"><?php echo t("Look up Metadata")?></a></dd>
                <dt><?php echo t('Season') ?>:</dt>
                <dd><input type="text" id="season" class="quantity" name="season" value="<?php echo html_entities($schedule->season) ?>"></dd>
                <dt><?php echo t('Episode') ?>:</dt>
                <dd><input type="text" id="episode" class="quantity" name="episode" value="<?php echo html_entities($schedule->episode) ?>"></dd>
                <fieldset>
                <legend><?php echo t('Filters') ?></legend>
                <?php
                foreach ($schedule->recordFilters() as $id => $filter) {
                ?>
                        <dt><label for="recordfilter_<?php echo $id; ?>"><?php echo t($filter['description']) ?>:</label></dt>
                        <dd><input type="checkbox" class="radio" id="recordfilter_<?php echo $id ?>" name="recordfilter_<?php echo $id ?>"<?php if ($filter['enabled']) echo ' CHECKED' ?> value="1"></dd>
                <?php } ?>
                </fieldset>
                <fieldset>
                <legend><?php echo t('Post Processing') ?></legend>
                <dt><label for="autometadata"><?php echo t('Look up Metadata') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autometadata" name="autometadata"<?php if ($schedule->autometadata) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autocommflag"><?php echo t('Auto-flag commercials') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autocommflag" name="autocommflag"<?php if ($schedule->autocommflag) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autotranscode"><?php echo t('Auto-transcode') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autotranscode" name="autotranscode"<?php if ($schedule->autotranscode) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autouserjob1"><?php echo setting('UserJobDesc1') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob1" name="autouserjob1"<?php if ($schedule->autouserjob1) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autouserjob2"><?php echo setting('UserJobDesc2') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob2" name="autouserjob2"<?php if ($schedule->autouserjob2) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autouserjob3"><?php echo setting('UserJobDesc3') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob3" name="autouserjob3"<?php if ($schedule->autouserjob3) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autouserjob4"><?php echo setting('UserJobDesc4') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autouserjob4" name="autouserjob4"<?php if ($schedule->autouserjob4) echo ' CHECKED' ?> value="1"></dd>
                </fieldset>
                <fieldset>
                <legend><?php echo t('Schedule Options') ?></legend>
                <dt><label for="inactive"><?php echo t('Inactive') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="inactive" name="inactive"<?php if ($schedule->inactive) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="autoexpire"><?php echo t('Auto-expire recordings') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="autoexpire" name="autoexpire"<?php if ($schedule->autoexpire) echo ' CHECKED' ?> value="1"></dd>
                <dt><label for="maxnewest"><?php echo t('Record new and expire old') ?>:</label></dt>
                <dd><input type="checkbox" class="radio" id="maxnewest" name="maxnewest"<?php if ($schedule->maxnewest) echo ' CHECKED' ?> value="1"></dd>
                <dt><?php echo t('No. of recordings to keep') ?>:</dt>
                <dd><input type="text" class="quantity" name="maxepisodes" value="<?php echo html_entities($schedule->maxepisodes) ?>"></dd>
                <dt><?php echo t('Start Early') ?>:</dt>
                <dd><input type="text" class="quantity" name="startoffset" value="<?php echo html_entities($schedule->startoffset) ?>">
                    <?php echo t('minutes') ?></dd>
                <dt><?php echo t('End Late') ?>:</dt>
                <dd><input type="text" class="quantity" name="endoffset" value="<?php echo html_entities($schedule->endoffset) ?>">
                    <?php echo t('minutes') ?></dd>
                </fieldset>
            </dl>

<div style="display: none;" id="message-dialog">
   <div id="metadata-message"></div>
   <div class="commands">
     <a onclick="Dialogs.close(); return false;"><?php echo t('OK') ?></a>
   </div>
</div>
