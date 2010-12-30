<?php
/**
 * List of keystrokes to send to a frontend
 *
 * @license     GPL
 *
 * @package     MythTV
 * @subpackage  Remote
/**/

?>

<script type="text/javascript">
<!--

// Handle shift
    var shift = false;
    function handle_shift() {
        if (capslock)
            return;
        shift = !shift;
        if (shift) {
            $('leftshift').addClassName('pressed');
            $('rightshift').addClassName('pressed');
        }
        else {
            if (!capslock) {
                $('leftshift').removeClassName('pressed');
                $('rightshift').removeClassName('pressed');
            }
        }
        if (shift && !capslock || !shift && !capslock)
            repaint_shifted();
    }

// Handle caps lock
    var capslock = false;
    function handle_capslock() {
        capslock = !capslock;
        if (capslock) {
            $('capslock').addClassName('pressed');
            $('leftshift').addClassName('pressed');
            $('rightshift').addClassName('pressed');
        }
        else {
            $('capslock').removeClassName('pressed');
            $('leftshift').removeClassName('pressed');
            $('rightshift').removeClassName('pressed');
        }
        if (capslock && !shift || !capslock && !shift)
            repaint_shifted();
        shift = false;
    }

// Repaint shifted keys
    function repaint_shifted() {
        if (capslock || shift) {
            $$('#remote_keys table a.noshift').each (function(s) {s.hide()});
            $$('#remote_keys table a.reqshift').each(function(s) {s.show()});
        }
        else {
            $$('#remote_keys table a.reqshift').each(function(s) {s.hide()});
            $$('#remote_keys table a.noshift').each (function(s) {s.show()});
        }
    }

    document.observe("dom:loaded", repaint_shifted);

// Send a key
    function send_key(key) {
        var r = new Ajax.Request('remote/keys',
                                 {
                                    parameters: 'command='+key,
                                  asynchronous: false
                                 });
    // Handle the response
        var results = r.transport.responseText.split("\n");
        if (results[0].match(/^err:/)) {
            alert(results[0].substr(4));
            return;
        }
    // Reset "shift" to off
        if (shift)
            handle_shift();
    // Update the screenshots
        setTimeout(function() { $$('img.x-screenshot').each(function(s) { s.src = s.src+"#"+Math.random(); }); }, 500);
    }

    function handle_keypress(event) {
        switch (event.keyCode) {
            case Event.KEY_BACKSPACE:
                send_key('backspace');
                break;
            case Event.KEY_TAB:
                send_key('tab');
                break;
            case Event.KEY_RETURN:
                send_key('enter');
                break;
            case Event.KEY_ESC:
                send_key('escape');
                break;
            case Event.KEY_LEFT:
                send_key('left');
                break;
            case Event.KEY_UP:
                send_key('up');
                break;
            case Event.KEY_RIGHT:
                send_key('right');
                break;
            case Event.KEY_DOWN:
                send_key('down');
                break;
            case Event.KEY_DELETE:
                send_key('delete');
                break;
            case Event.KEY_HOME:
                send_key('home');
                break;
            case Event.KEY_END:
                send_key('end');
                break;
            case Event.KEY_PAGEUP:
                send_key('pageup');
                break;
            case Event.KEY_PAGEDOWN:
                send_key('pagedown');
                break;
            default:
                send_key(String.fromCharCode(event.charCode));
                break;

        }
        Event.stop(event)
    }

    var keypress = false;
    function toggle_keypress() {
        if (keypress) {
            Event.stopObserving(document, 'keypress', handle_keypress);
            $('keypress').removeClassName('pressed');
        }
        else {
            Event.observe(document, 'keypress', handle_keypress);
            $('keypress').addClassName('pressed');
        }
        keypress = !keypress;
    }

// -->
</script>

<div id="remote_keys">

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="2">
        <a onclick="send_key('escape')"><?php echo t('Escape') ?></a></td>
    <td><a onclick="send_key('f13')" class="reqshift">F13</a>
        <a onclick="send_key('f1')"  class="noshift">F1</a></td>
    <td><a onclick="send_key('f14')" class="reqshift">F14</a>
        <a onclick="send_key('f2')"  class="noshift">F2</a></td>
    <td><a onclick="send_key('f15')" class="reqshift">F15</a>
        <a onclick="send_key('f3')"  class="noshift">F3</a></td>
    <td><a onclick="send_key('f16')" class="reqshift">F16</a>
        <a onclick="send_key('f4')"  class="noshift">F4</a></td>
    <td><a onclick="send_key('f17')" class="reqshift">F17</a>
        <a onclick="send_key('f5')"  class="noshift">F5</a></td>
    <td><a onclick="send_key('f18')" class="reqshift">F18</a>
        <a onclick="send_key('f6')"  class="noshift">F6</a></td>
    <td><a onclick="send_key('f19')" class="reqshift">F19</a>
        <a onclick="send_key('f7')"  class="noshift">F7</a></td>
    <td><a onclick="send_key('f20')" class="reqshift">F20</a>
        <a onclick="send_key('f8')"  class="noshift">F8</a></td>
    <td><a onclick="send_key('f21')" class="reqshift">F21</a>
        <a onclick="send_key('f9')"  class="noshift">F9</a></td>
    <td><a onclick="send_key('f22')" class="reqshift">F22</a>
        <a onclick="send_key('f10')" class="noshift">F10</a></td>
    <td><a onclick="send_key('f23')" class="reqshift">F23</a>
        <a onclick="send_key('f11')" class="noshift">F11</a></td>
    <td><a onclick="send_key('f24')" class="reqshift">F24</a>
        <a onclick="send_key('f12')" class="noshift">F12</a></td>
    <td></td>
    <td></td>
    <td colspan="3"><a id="keypress" onclick="toggle_keypress()"><?php echo t('Toggle Interactive Mode') ?></a></td>
</tr><tr>
    <td><a onclick="send_key('~')" class="reqshift">~</a>
        <a onclick="send_key('`')" class="noshift">`</a></td>
    <td><a onclick="send_key('!')" class="reqshift">!</a>
        <a onclick="send_key('1')" class="noshift">1</a></td>
    <td><a onclick="send_key('@')" class="reqshift">@</a>
        <a onclick="send_key('2')" class="noshift">2</a></td>
    <td><a onclick="send_key('#')" class="reqshift">#</a>
        <a onclick="send_key('3')" class="noshift">3</a></td>
    <td><a onclick="send_key('$')" class="reqshift">$</a>
        <a onclick="send_key('4')" class="noshift">4</a></td>
    <td><a onclick="send_key('%')" class="reqshift">%</a>
        <a onclick="send_key('5')" class="noshift">5</a></td>
    <td><a onclick="send_key('^')" class="reqshift">^</a>
        <a onclick="send_key('6')" class="noshift">6</a></td>
    <td><a onclick="send_key('&')" class="reqshift">&amp;</a>
        <a onclick="send_key('7')" class="noshift">7</a></td>
    <td><a onclick="send_key('*')" class="reqshift">*</a>
        <a onclick="send_key('8')" class="noshift">8</a></td>
    <td><a onclick="send_key('(')" class="reqshift">(</a>
        <a onclick="send_key('9')" class="noshift">9</a></td>
    <td><a onclick="send_key(')')" class="reqshift">)</a>
        <a onclick="send_key('0')" class="noshift">0</a></td>
    <td><a onclick="send_key('_')" class="reqshift">_</a>
        <a onclick="send_key('-')" class="noshift">&ndash;</a></td>
    <td><a onclick="send_key('+')" class="reqshift">+</a>
        <a onclick="send_key('=')" class="noshift">=</a></td>
    <td colspan="2"><a onclick="send_key('backspace')"><?php echo t('Backspace') ?></a></td>
    <td>&nbsp;</td>
    <td><a onclick="send_key('insert')"><?php echo t('Insert') ?></a></td>
    <td><a onclick="send_key('home')"><?php echo t('Home') ?></a></td>
    <td><a onclick="send_key('pageup')"><?php echo t('Page Up') ?></a></td>
</tr><tr>
    <td colspan="2">
        <a onclick="send_key('backtab')" class="reqshift"><?php echo t('Back Tab') ?></a>
        <a onclick="send_key('tab')"     class="noshift"><?php echo t('Tab') ?></a></td>
    <td><a onclick="send_key('Q')" class="reqshift">Q</a>
        <a onclick="send_key('q')" class="noshift">q</a></td>
    <td><a onclick="send_key('W')" class="reqshift">W</a>
        <a onclick="send_key('w')" class="noshift">w</a></td>
    <td><a onclick="send_key('E')" class="reqshift">E</a>
        <a onclick="send_key('e')" class="noshift">e</a></td>
    <td><a onclick="send_key('R')" class="reqshift">R</a>
        <a onclick="send_key('r')" class="noshift">r</a></td>
    <td><a onclick="send_key('T')" class="reqshift">T</a>
        <a onclick="send_key('t')" class="noshift">t</a></td>
    <td><a onclick="send_key('Y')" class="reqshift">Y</a>
        <a onclick="send_key('y')" class="noshift">y</a></td>
    <td><a onclick="send_key('U')" class="reqshift">U</a>
        <a onclick="send_key('u')" class="noshift">u</a></td>
    <td><a onclick="send_key('I')" class="reqshift">I</a>
        <a onclick="send_key('i')" class="noshift">i</a></td>
    <td><a onclick="send_key('O')" class="reqshift">O</a>
        <a onclick="send_key('o')" class="noshift">o</a></td>
    <td><a onclick="send_key('P')" class="reqshift">P</a>
        <a onclick="send_key('p')" class="noshift">p</a></td>
    <td><a onclick="send_key('{')" class="reqshift">{</a>
        <a onclick="send_key('[')" class="noshift">[</a></td>
    <td><a onclick="send_key('}')" class="reqshift">}</a>
        <a onclick="send_key(']')" class="noshift">]</a></td>
    <td><a onclick="send_key('|')" class="reqshift">|</a>
        <a onclick="send_key('\\')" class="noshift">\</a></td>
    <td>&nbsp;</td>
    <td><a onclick="send_key('delete')"><?php echo t('DeleteKey') ?></a></td>
    <td><a onclick="send_key('end')"><?php echo t('End') ?></a></td>
    <td><a onclick="send_key('pagedown')"><?php echo t('Page Down') ?></a></td>
</tr><tr>
    <td colspan="2">
        <a id="capslock" onclick="handle_capslock()"><?php echo t('Caps Lock') ?></a></td>
    <td><a onclick="send_key('A')" class="reqshift">A</a>
        <a onclick="send_key('a')" class="noshift">a</a></td>
    <td><a onclick="send_key('S')" class="reqshift">S</a>
        <a onclick="send_key('s')" class="noshift">s</a></td>
    <td><a onclick="send_key('D')" class="reqshift">D</a>
        <a onclick="send_key('d')" class="noshift">d</a></td>
    <td><a onclick="send_key('F')" class="reqshift">F</a>
        <a onclick="send_key('f')" class="noshift">f</a></td>
    <td><a onclick="send_key('G')" class="reqshift">G</a>
        <a onclick="send_key('g')" class="noshift">g</a></td>
    <td><a onclick="send_key('H')" class="reqshift">H</a>
        <a onclick="send_key('h')" class="noshift">h</a></td>
    <td><a onclick="send_key('J')" class="reqshift">J</a>
        <a onclick="send_key('j')" class="noshift">j</a></td>
    <td><a onclick="send_key('K')" class="reqshift">K</a>
        <a onclick="send_key('k')" class="noshift">k</a></td>
    <td><a onclick="send_key('L')" class="reqshift">L</a>
        <a onclick="send_key('l')" class="noshift">l</a></td>
    <td><a onclick="send_key(':')" class="reqshift">:</a>
        <a onclick="send_key(';')" class="noshift">;</a></td>
    <td><a onclick="send_key('%22')" class="reqshift">&quot;</a>
        <a onclick="send_key('%27')" class="noshift">'</a></td>
    <td colspan="2"><a onclick="send_key('enter')"><?php echo t('Enter') ?></a></td>
</tr><tr>
    <td colspan="2"><a id="leftshift" onclick="handle_shift()"><?php echo t('Shift') ?></a></td>
    <td><a onclick="send_key('Z')" class="reqshift">Z</a>
        <a onclick="send_key('z')" class="noshift">z</a></td>
    <td><a onclick="send_key('X')" class="reqshift">X</a>
        <a onclick="send_key('x')" class="noshift">x</a></td>
    <td><a onclick="send_key('C')" class="reqshift">C</a>
        <a onclick="send_key('c')" class="noshift">c</a></td>
    <td><a onclick="send_key('V')" class="reqshift">V</a>
        <a onclick="send_key('v')" class="noshift">v</a></td>
    <td><a onclick="send_key('B')" class="reqshift">B</a>
        <a onclick="send_key('b')" class="noshift">b</a></td>
    <td><a onclick="send_key('N')" class="reqshift">N</a>
        <a onclick="send_key('n')" class="noshift">n</a></td>
    <td><a onclick="send_key('M')" class="reqshift">M</a>
        <a onclick="send_key('m')" class="noshift">m</a></td>
    <td><a onclick="send_key('%3C')" class="reqshift">&lt;</a>
        <a onclick="send_key(',')" class="noshift">,</a></td>
    <td><a onclick="send_key('%3E')" class="reqshift">&gt;</a>
        <a onclick="send_key('.')" class="noshift">.</a></td>
    <td><a onclick="send_key('%3F')" class="reqshift">?</a>
        <a onclick="send_key('/')" class="noshift">/</a></td>
    <td colspan="3">
        <a id="rightshift" onclick="handle_shift()"><?php echo t('Shift') ?></a></td>
    <td colspan="2">&nbsp;</td>
    <td><a onclick="send_key('up')"><?php echo t('Up') ?></a></td>
</tr><tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="10">
        <a onclick="send_key('space')"><?php echo t('Space') ?></a></td>
    <td colspan="4">&nbsp;</td>
    <td><a onclick="send_key('left')"><?php  echo t('Left') ?></a></td>
    <td><a onclick="send_key('down')"><?php  echo t('Down') ?></a></td>
    <td><a onclick="send_key('right')"><?php echo t('Right') ?></a></td>
</tr>
</table>

</div>
