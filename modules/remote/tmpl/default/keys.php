<?php
/**
 * List of keystrokes to send to a frontend
 *
 * @url         $URL$
 * @date        $Date$
 * @version     $Revision$
 * @author      $Author$
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
        var showkeys;
        var hidekeys;
        if (capslock || shift) {
            showkeys = $$('#remote_keys table a.noshift');
            hidekeys = $$('#remote_keys table a.reqshift');
        }
        else {
            showkeys = $$('#remote_keys table a.reqshift');
            hidekeys = $$('#remote_keys table a.noshift');
        }
    // Hide the unwanted keys
        for (var i=0;i<=showkeys.length;i++) {
            if (showkeys.hasOwnProperty(i))
                showkeys[i].addClassName('-hidden');
        }
    // Show the keys that should be visible
        for (var i=0;i<=hidekeys.length;i++) {
            if (hidekeys.hasOwnProperty(i))
                hidekeys[i].removeClassName('-hidden');
        }
    }

// Send a key
    function send_key(key) {
        var r = new Ajax.Request('<?php echo root ?>remote/keys',
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
    }

// -->
</script>

<div id="remote_keys">

<table border="0" cellspacing="0" cellpadding="0">
<tr>
    <td colspan="2">
        <a onclick="send_key('escape')"><?php echo t('Escape') ?></a></td>
    <td><a onclick="send_key('f13')" class="reqshift -hidden">F13</a>
        <a onclick="send_key('f1')"  class="noshift">F1</a></td>
    <td><a onclick="send_key('f14')" class="reqshift -hidden">F14</a>
        <a onclick="send_key('f2')"  class="noshift">F2</a></td>
    <td><a onclick="send_key('f15')" class="reqshift -hidden">F15</a>
        <a onclick="send_key('f3')"  class="noshift">F3</a></td>
    <td><a onclick="send_key('f16')" class="reqshift -hidden">F16</a>
        <a onclick="send_key('f4')"  class="noshift">F4</a></td>
    <td><a onclick="send_key('f17')" class="reqshift -hidden">F17</a>
        <a onclick="send_key('f5')"  class="noshift">F5</a></td>
    <td><a onclick="send_key('f18')" class="reqshift -hidden">F18</a>
        <a onclick="send_key('f6')"  class="noshift">F6</a></td>
    <td><a onclick="send_key('f19')" class="reqshift -hidden">F19</a>
        <a onclick="send_key('f7')"  class="noshift">F7</a></td>
    <td><a onclick="send_key('f20')" class="reqshift -hidden">F20</a>
        <a onclick="send_key('f8')"  class="noshift">F8</a></td>
    <td><a onclick="send_key('f21')" class="reqshift -hidden">F21</a>
        <a onclick="send_key('f9')"  class="noshift">F9</a></td>
    <td><a onclick="send_key('f22')" class="reqshift -hidden">F22</a>
        <a onclick="send_key('f10')" class="noshift">F10</a></td>
    <td><a onclick="send_key('f23')" class="reqshift -hidden">F23</a>
        <a onclick="send_key('f11')" class="noshift">F11</a></td>
    <td><a onclick="send_key('f24')" class="reqshift -hidden">F24</a>
        <a onclick="send_key('f12')" class="noshift">F12</a></td>
</tr><tr>
    <td><a onclick="send_key('~')" class="reqshift -hidden">~</a>
        <a onclick="send_key('`')" class="noshift">`</a></td>
    <td><a onclick="send_key('!')" class="reqshift -hidden">!</a>
        <a onclick="send_key('1')" class="noshift">1</a></td>
    <td><a onclick="send_key('@')" class="reqshift -hidden">@</a>
        <a onclick="send_key('2')" class="noshift">2</a></td>
    <td><a onclick="send_key('#')" class="reqshift -hidden">#</a>
        <a onclick="send_key('3')" class="noshift">3</a></td>
    <td><a onclick="send_key('$')" class="reqshift -hidden">$</a>
        <a onclick="send_key('4')" class="noshift">4</a></td>
    <td><a onclick="send_key('%')" class="reqshift -hidden">%</a>
        <a onclick="send_key('5')" class="noshift">5</a></td>
    <td><a onclick="send_key('^')" class="reqshift -hidden">^</a>
        <a onclick="send_key('6')" class="noshift">6</a></td>
    <td><a onclick="send_key('&')" class="reqshift -hidden">&amp;</a>
        <a onclick="send_key('7')" class="noshift">7</a></td>
    <td><a onclick="send_key('*')" class="reqshift -hidden">*</a>
        <a onclick="send_key('8')" class="noshift">8</a></td>
    <td><a onclick="send_key('(')" class="reqshift -hidden">(</a>
        <a onclick="send_key('9')" class="noshift">9</a></td>
    <td><a onclick="send_key(')')" class="reqshift -hidden">)</a>
        <a onclick="send_key('0')" class="noshift">0</a></td>
    <td><a onclick="send_key('_')" class="reqshift -hidden">_</a>
        <a onclick="send_key('-')" class="noshift">&ndash;</a></td>
    <td><a onclick="send_key('+')" class="reqshift -hidden">+</a>
        <a onclick="send_key('=')" class="noshift">=</a></td>
    <td colspan="2"><a onclick="send_key('backspace')"><?php echo t('Backspace') ?></a></td>
    <td>&nbsp;</td>
    <td><a onclick="send_key('insert')"><?php echo t('Insert') ?></a></td>
    <td><a onclick="send_key('home')"><?php echo t('Home') ?></a></td>
    <td><a onclick="send_key('pageup')"><?php echo t('Page Up') ?></a></td>
</tr><tr>
    <td colspan="2">
        <a onclick="send_key('backtab')" class="reqshift -hidden"><?php echo t('Back Tab') ?></a>
        <a onclick="send_key('tab')"     class="noshift"><?php echo t('Tab') ?></a></td>
    <td><a onclick="send_key('Q')" class="reqshift -hidden">Q</a>
        <a onclick="send_key('q')" class="noshift">q</a></td>
    <td><a onclick="send_key('W')" class="reqshift -hidden">W</a>
        <a onclick="send_key('w')" class="noshift">w</a></td>
    <td><a onclick="send_key('E')" class="reqshift -hidden">E</a>
        <a onclick="send_key('e')" class="noshift">e</a></td>
    <td><a onclick="send_key('R')" class="reqshift -hidden">R</a>
        <a onclick="send_key('r')" class="noshift">r</a></td>
    <td><a onclick="send_key('T')" class="reqshift -hidden">T</a>
        <a onclick="send_key('t')" class="noshift">t</a></td>
    <td><a onclick="send_key('Y')" class="reqshift -hidden">Y</a>
        <a onclick="send_key('y')" class="noshift">y</a></td>
    <td><a onclick="send_key('U')" class="reqshift -hidden">U</a>
        <a onclick="send_key('u')" class="noshift">u</a></td>
    <td><a onclick="send_key('I')" class="reqshift -hidden">I</a>
        <a onclick="send_key('i')" class="noshift">i</a></td>
    <td><a onclick="send_key('O')" class="reqshift -hidden">O</a>
        <a onclick="send_key('o')" class="noshift">o</a></td>
    <td><a onclick="send_key('P')" class="reqshift -hidden">P</a>
        <a onclick="send_key('p')" class="noshift">p</a></td>
    <td><a onclick="send_key('{')" class="reqshift -hidden">{</a>
        <a onclick="send_key('[')" class="noshift">[</a></td>
    <td><a onclick="send_key('}')" class="reqshift -hidden">}</a>
        <a onclick="send_key(']')" class="noshift">]</a></td>
    <td><a onclick="send_key('|')" class="reqshift -hidden">|</a>
        <a onclick="send_key('\\')" class="noshift">\</a></td>
    <td>&nbsp;</td>
    <td><a onclick="send_key('delete')"><?php echo t('Delete') ?></a></td>
    <td><a onclick="send_key('end')"><?php echo t('End') ?></a></td>
    <td><a onclick="send_key('pagedown')"><?php echo t('Page Down') ?></a></td>
</tr><tr>
    <td colspan="2">
        <a id="capslock" onclick="handle_capslock()"><?php echo t('Caps Lock') ?></a></td>
    <td><a onclick="send_key('A')" class="reqshift -hidden">A</a>
        <a onclick="send_key('a')" class="noshift">a</a></td>
    <td><a onclick="send_key('S')" class="reqshift -hidden">S</a>
        <a onclick="send_key('s')" class="noshift">s</a></td>
    <td><a onclick="send_key('D')" class="reqshift -hidden">D</a>
        <a onclick="send_key('d')" class="noshift">d</a></td>
    <td><a onclick="send_key('F')" class="reqshift -hidden">F</a>
        <a onclick="send_key('f')" class="noshift">f</a></td>
    <td><a onclick="send_key('G')" class="reqshift -hidden">G</a>
        <a onclick="send_key('g')" class="noshift">g</a></td>
    <td><a onclick="send_key('H')" class="reqshift -hidden">H</a>
        <a onclick="send_key('h')" class="noshift">h</a></td>
    <td><a onclick="send_key('J')" class="reqshift -hidden">J</a>
        <a onclick="send_key('j')" class="noshift">j</a></td>
    <td><a onclick="send_key('K')" class="reqshift -hidden">K</a>
        <a onclick="send_key('k')" class="noshift">k</a></td>
    <td><a onclick="send_key('L')" class="reqshift -hidden">L</a>
        <a onclick="send_key('l')" class="noshift">l</a></td>
    <td><a onclick="send_key(':')" class="reqshift -hidden">:</a>
        <a onclick="send_key(';')" class="noshift">;</a></td>
    <td><a onclick="send_key('%22')" class="reqshift -hidden">&quot;</a>
        <a onclick="send_key('%27')" class="noshift">'</a></td>
    <td colspan="2"><a onclick="send_key('enter')"><?php echo t('Enter') ?></a></td>
</tr><tr>
    <td colspan="2"><a id="leftshift" onclick="handle_shift()"><?php echo t('Shift') ?></a></td>
    <td><a onclick="send_key('Z')" class="reqshift -hidden">Z</a>
        <a onclick="send_key('z')" class="noshift">z</a></td>
    <td><a onclick="send_key('X')" class="reqshift -hidden">X</a>
        <a onclick="send_key('x')" class="noshift">x</a></td>
    <td><a onclick="send_key('C')" class="reqshift -hidden">C</a>
        <a onclick="send_key('c')" class="noshift">c</a></td>
    <td><a onclick="send_key('V')" class="reqshift -hidden">V</a>
        <a onclick="send_key('v')" class="noshift">v</a></td>
    <td><a onclick="send_key('B')" class="reqshift -hidden">B</a>
        <a onclick="send_key('b')" class="noshift">b</a></td>
    <td><a onclick="send_key('N')" class="reqshift -hidden">N</a>
        <a onclick="send_key('n')" class="noshift">n</a></td>
    <td><a onclick="send_key('M')" class="reqshift -hidden">M</a>
        <a onclick="send_key('m')" class="noshift">m</a></td>
    <td><a onclick="send_key('%3C')" class="reqshift -hidden">&lt;</a>
        <a onclick="send_key(',')" class="noshift">,</a></td>
    <td><a onclick="send_key('%3E')" class="reqshift -hidden">&gt;</a>
        <a onclick="send_key('.')" class="noshift">.</a></td>
    <td><a onclick="send_key('%3F')" class="reqshift -hidden">?</a>
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
