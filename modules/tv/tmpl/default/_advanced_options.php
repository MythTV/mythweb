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

// -->
</script>

            <h3><?php echo t('Advanced Options') ?>:</h3>
            (<?php
                echo '<a href="#" onclick="toggle_advanced(false); return false;" id="hide_advanced"';
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
                <dt><?php echo t('Time Stretch Default') ?>:</dt>
                <dd>
                    <select name="timestretch">
                <?php
                    $tsstep = 0.05;
                    for ($tscount = 0.5; $tscount < 2.01; $tscount += $tsstep) {
                        $matches = fequals($schedule->tsdefault, $tscount);

                        if (!$matches &&
                                $schedule->tsdefault < $tscount &&
                                $schedule->tsdefault > $tscount - $tsstep) {
                            printf('<option value="%01.2f" selected>%01.2f' .
                                    "</option>\n", $schedule->tsdefault,
                                    $schedule->tsdefault);
                        }

                        printf('<option value="%01.2f"', $tscount);
                        if ($matches) {
                            echo ' selected';
                        }
                        printf(">%01.2f</option>\n", $tscount);
                    }
                ?>
                    </select>
                </dd>
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
                <dt><?php echo t('Filter')?>:</dt>
                <dd><select name="dupin2"><?php
                        echo '<option value="0"';
                        if ($schedule->dupin == 0)
                            echo ' SELECTED';
                        echo '>' . t('None') . '</option>';
                        echo '<option value="', dupsin_newepisodes, '"';
                        if ($schedule->dupin & dupsin_newepisodes && !($schedule->dupin & dupsin_ex_repeats))
                            echo ' SELECTED';
                        echo '>' . t('New Episodes Only') . '</option>';
                        echo '<option value="', dupsin_ex_repeats,'"';
                        if ($schedule->dupin & dupsin_ex_repeats && !($schedule->dupin & dupsin_ex_generic))
                            echo ' SELECTED';
                        echo '>' . t('Exclude Repeat Episodes') . '</option>';
                        echo '<option value="', dupsin_ex_generic, '"';
                        if ($schedule->dupin & dupsin_ex_generic && !($schedule->dupin & dupsin_ex_repeats))
                            echo ' SELECTED';
                        echo '>' . t('Exclude Generic Episodes') . '</option>';
                        echo '<option value="', dupsin_ex_repeats + dupsin_ex_generic, '"';
                        if ($schedule->dupin & dupsin_ex_repeats && $schedule->dupin & dupsin_ex_generic)
                            echo ' SELECTED';
                        echo '>' . t('Exclude Repeat and Generic Episodes') . '</option>';
                   ?></select></dd>
                <dt><?php echo t('Preferred Input') ?>:</dt>
                <dd><?php input_select($schedule->prefinput, 'prefinput') ?></dd>
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
            </dl>
