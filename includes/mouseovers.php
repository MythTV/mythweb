<?php
/***                                                                        ***\
    mouseovers.php                           Last Updated: 2005.01.21 (xris)

    This allows you to create inline help items - popup tables linked to
    mouseover events.  It requires the mouseovers.js file
\***                                                                        ***/

// Enable/Disable help messages
    if ($_GET['show_help'] == 'yes' || $_POST['show_help'] == 'yes')
        $_SESSION['show help'] = true;
    elseif ($_GET['show_help'] == 'no' || $_POST['show_help'] == 'no')
        $_SESSION['show help'] = false;

/*
    show_popup:
    Returns an id and mouseover code to display a popup over whatever
    element the id resides within.
*/
    function show_popup($id, $text, $popup_id = NULL, $class = 'popup', $wstatus = '') {
        global $Footnotes;
        if (!$Footnotes[$popup_id ? $popup_id : $id])
            $Footnotes[$popup_id ? $popup_id : $id] = '<div id="'.($popup_id ? $popup_id : $id)."_popup\" class=\"$class\">$text</div>";
    // $popup_id allows us to recycle certain info fields - it's ignored if empty
        $ret = " id=\"$id\" onmouseover=\"popup('$id', '$popup_id');";
        # This won't work until we add wstatus stuff to the javascript code, since it rewrites onmouseout
        #if ($wstatus) {
        #    $ret .= "wstatus('".str_replace('\'', '\\\'', $wstatus)
        #           ."');return true\" onmouseout=\"wstatus('foo');";
        #}
        $ret .= "return true\"";
        return $ret;
    }

/*
    show_help:
    This will create a link around $link that will bring up a popup
    div containing $text, which should be the help info for whatever
    $link relates to.
*/
    function show_help($link, $text, $url = '', $extras = '') {
        if ($url)
            $url = " href=\"$url\" ";
        if (!$_SESSION['show help']) {
            if ($url || $extras)
                echo "<a $url$extras>$link</a>";
            else
                echo $link;
            return;
        }
        static $help_count;
        $help_count++;
        echo '<a'.show_popup('helplink_'.$help_count, $text, NULL, 'help').'>'.$link.'</a>';
    }

/*
    generate_popup_menu:
    generates a popup
*/
    function generate_popup_menu($id, $class, $items, $overload = 0) {
        if ($overload >= 50) return '';
        if (!count($items))  return '';
        if ($id && $overload == 0) {
            $text = "<script language=\"JavaScript\" type=\"text/javascript\">\n"
                   ."<!--\n"
                   ."register_menu('$id');\n"
                   ."// -->\n"
                   ."</script>\n"
                   ."<ul id=\"$id\"";
        }
        else
            $text = '<ul';
        if ($class)
            $text .= " class=\"$class\"";
        $text .= ">\n";
        $sep = false;
        foreach ($items as $item) {
        // Normal menu item
            if (is_array($item) && isset($item['name'])) {
                $text .= str_repeat('  ', $overload+1) . '<li';
            // Separator above?
                if ($sep) {
                    $sep = false;
                    $text .= ' class="sep"';
                }
            // Print the content
                if ($item['url'])
                    $text .= "><a href=\"".$item['url'].'">'.$item['name'].'</a>';
                elseif ($item['click'])
                    $text .= '><a onclick="'.$item['click'].'">'.$item['name'].'</a>';
                else
                    $text .= '>'.$item['name'];
            // Child menu?
                if ($item['children'])
                    $text .= "\n".str_repeat('  ', $overload+2).generate_popup_menu('', '', $item['children'], $overload + 2)
                            .str_repeat('  ', $overload+2);
            // Close off the list item
                $text .= "</li>\n";
            }
        // Just a separator
            else
                $sep = true;
        }
        return $text.str_repeat('  ', $overload)."</ul>\n";
    }

