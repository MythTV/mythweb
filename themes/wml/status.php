<?php
/***                                                                        ***\
    status.php                               Last Updated: 2004.10.25 (jbuckshin)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.
\***                                                                        ***/

chdir("../..");
require_once "includes/init.php";


// Get the address/port of the master machine
$masterhost = get_backend_setting('MasterServerIP');
$statusport = get_backend_setting('BackendStatusPort');

// Since the status service directly outputs html we parse it
// the old fasion way
$str = file_get_contents("http://$masterhost:$statusport");

// Make sure the content is interpreted as UTF-8
header("Content-Type: text/vnd.wap.wml");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");    

echo "<?xml version=\"1.0\"?>"
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">

<wml>

<card id="card1" title="Status">
<p>
<a href="#encoders">Encoder status</a><br/>
<a href="#schedules">Schedules</a><br/>
<a href="#jobs">Job Status</a><br/>
<a href="#disks">Disk usage</a><br/>
<a href="#load">Load Average</a><br/>
<a href="#fill">Mythfilldatabase</a><br/>
</p>
</card>
<?php
$encoders="";
$sched="";
$disk="";
$load="";
$fill="";
$arr1 = preg_split("/\n/", $str, -1, PREG_SPLIT_NO_EMPTY);
$count = count($arr1);
for ($i=0; $i < $count; $i++)
{
    $line = $arr1[$i];

    if (strpos($line, "    Encoder ") !== FALSE) {
        trim($line);
        $line = substr($line, strpos($line, "<li>")+4, strpos($line, ".")-4);
        $encoders.=$line."<br/>\n";
    } else if (strpos($line, "<div id=\"schedule\">") !== FALSE) {
        $i++;
        $line = $arr1[$i];
        while (strpos($line, "</div>") === FALSE) {
            $sched.=substr($line, strpos($line, "<a href=\"#\">")+12, strpos($line, "<br />")-18)."<br/>\n";
            $i++;
            $line = $arr1[$i];
        }
    } else if (strpos($line, "    Jobs currently in") !== FALSE) {
        $i++;
        $line = $arr1[$i];
        $job="";
        while (strpos($line, "<br />    <div") !== FALSE) {
            $i++;
            $line = $arr1[$i];
            $job.=substr($line, strpos($line, ">") + 1, strpos($line, "<f")-12);
            $last_tok =  strpos($line, "<f")+3;
            $line = substr($line, $last_tok + 1);
            $job.=" (".substr($line, strpos($line, ">") + 1, strpos($line, "</f")-22).")<br/>";
            $i+=2;
            $line = $arr1[$i];
        }
    } else if (strpos($line, "      Disk Usage:") !== FALSE) {
        $i += 2;
        $line = $arr1[$i];
        $disk.=substr($line, strpos($line, "<li>")+4, strpos($line, "<li/>")-6)."<br/>\n";
        $i++;
        $line = $arr1[$i];
        $disk.=substr($line, strpos($line, "<li>")+4, strpos($line, "<li/>")-6)."<br/>\n";
        $i++;
        $line = $arr1[$i];
        $disk.=substr($line, strpos($line, "<li>")+4, strpos($line, "<li/>")-6)."<br/>\n";
        
    } else if (strpos($line, "      This machine's load") !== FALSE) {
        $i += 2;
        $line = $arr1[$i];
        $load.=substr($line, strpos($line, "<li>")+4, strpos($line, "<li/>")-6)."<br/>\n";
        $i++;
        $line = $arr1[$i];
        $load.=substr($line, strpos($line, "<li>")+4, strpos($line, "<li/>")-6)."<br/>\n";
        $i++;
        $line = $arr1[$i];
        $load.=substr($line, strpos($line, "<li>")+4, strpos($line, "<li/>")-6)."<br/>\n";
    } else if (strpos($line, "    Last mythfilldatabase") !== FALSE) {
        $fill.=$line;
        $line = $arr1[++$i];
        if (strpos($line, "</div>") === FALSE) {    
            $fill.=$line;
            $line = $arr1[++$i];
            if (strpos($line, "</div>") === FALSE) {    
                $fill.=$line;
            }
        }
    }

}
?>
<card id="encoders" title="Encoders">
<p>
<?php echo $encoders; ?>
</p>
</card>
<card id="schedules" title="Schedules">
<p>
<?php echo $sched; ?>
</p>
</card>
<card id="jobs" title="Jobs">
<p>
<?php echo $job; ?>
</p>
</card>
<card id="disks" title="Disks">
<p>
<?php echo $disk; ?>
</p>
</card>
<card id="load" title="Load">
<p>
<?php echo $load; ?>
</p>
</card>
<card id="fill" title="MythFillDB">
<p>
<?php echo $fill; ?>
</p>
</card>
</wml>
