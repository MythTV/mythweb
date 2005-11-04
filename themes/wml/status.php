<?php
/***                                                                        ***\
    status.php                               Last Updated: 2004.10.25 (jbuckshin)

    This file is part of MythWeb, a php-based interface for MythTV.
    See README and LICENSE for details.
\***                                                                        ***/

// Initialize the script, database, etc.
chdir("../..");
require_once "includes/init.php";

// Get the address/port of the master machine
$masterhost = get_backend_setting('MasterServerIP');
$statusport = get_backend_setting('BackendStatusPort');

$file = "http://$masterhost:$statusport/xml";
$depth = array();
$JobFlag = 0;
$SchedDoneFlag = 0;
$JobData = "";

// set the global string builders
$encoders="";
$statusline="";
$sched="";
$disk="";
$load="";
$fill="";
$ddstatus="";

// Make sure the content is interpreted as UTF-8
header("Content-Type: text/vnd.wap.wml");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
echo "<?php xml version=\"1.0\" ?>";



function startElement($parser, $name, $attrs)
{
   global $depth;
   global $JobFlag;
   global $SchedDoneFlag;
   global $DDFlag;
   global $encoders;
   global $statusline;
   global $sched;
   global $disk;
   global $load;
   global $fill;
   global $ddstatus;

   switch ($name)
   {
      case "STATUS":
         $statusline.= $attrs['VERSION']."<br />\n";
         $statusline.= $attrs['DATE']." ".$attrs['TIME']."<br />\n";
         break;
      case "ENCODER":
         if ($attrs['CONNECTED'] == "1")
         {
            if ($attrs['STATE'] == "1")
            {
               $status = "currently recording";
            }
            else
            {
               $status = "not currently recording";
            }
         }
         else
         {
           $status = "not connected";
         }
         $encoders.="Encoder ".$attrs['ID']." is ".(($attrs['LOCAL'] == "1") ? "local" : "remote")." on ".$attrs['HOSTNAME']." and is ".$status."<br />\n";
         break;
      case "PROGRAM":
         $sched.="Encoder ".$attrs['INPUTID']." - ".$attrs['TITLE']." - ";
         break;
      case "CHANNEL":
         if ($SchedDoneFlag == 0)
         {
            $sched.=$attrs['CHANNELNAME']."<br />\n";
         }
         break;
      case "JOB":
         $JobFlag = 1;
         break;
      case "STORAGE":
         $disk.="Total Space:".$attrs['USED']."<br />Spaced Used:".$attrs['USED']."<br />Space Free:".$attrs['FREE']."<br />\n";
         break;
      case "LOAD":
         $load.= "1 Minute: ".$attrs['AVG1']."<br />5 Minutes: ".$attrs['AVG2']."<br />15 Minutes: ".$attrs['AVG3']."<br />\n";
         break;
      case "GUIDE":
         $fill.= "Last mythfilldatabase run started on ".$attrs['START']." and ended on ".$attrs['END']." ".$attrs['STATUS']."<br />There's guide data until ".$attrs['GUIDETHRU']." (".$attrs['GUIDEDAYS']." days).<br />DirectData Status: ";
         $DDFlag = 1;
         break;
   }
   $depth[$parser]++;
}

function endElement($parser, $name)
{
   global $depth;
   global $JobFlag;
   global $SchedDoneFlag;
   global $DDFlag;
   global $JobData;
   global $ddstatus;

   if ($name == "JOB")
   {
      # echo "Job : ".$JobData."<br />\n";
      $JobFlag = 0;
   }
   if ($name == "SCHEDULED")
   {
      $SchedDoneFlag = 1;
   }
   $depth[$parser]--;
}

function characterData($parser, $data)
{
   global $JobData;
   global $JobFlag;
   global $DDFlag;
   global $fill;

   if ($JobFlag == 1)
   {
      $JobData = $data;
      $JobFlag = 0;
   }
   if ($DDFlag == 1)
   {
      $fill.=$data."<br />\n";
      $DDFlag = 0;
   }
}

$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_set_character_data_handler($xml_parser, "characterData");
if (!($fp = fopen($file, "r"))) {
   die("could not open XML input");
}

while ($data = fread($fp, 4096)) {
   if (!xml_parse($xml_parser, $data, feof($fp))) {
       die(sprintf("XML error: %s at line %d",
                   xml_error_string(xml_get_error_code($xml_parser)),
                   xml_get_current_line_number($xml_parser)));
   }
}
xml_parser_free($xml_parser);

?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml">

<wml>

<card id="card1" title="Status">
<p>
<?php echo $statusline ?>
<a href="#encoders">Encoder status</a><br />
<a href="#schedules">Schedules</a><br />
<a href="#jobs">Job Status</a><br />
<a href="#disks">Disk usage</a><br />
<a href="#load">Load Average</a><br />
<a href="#fill">Mythfilldatabase</a><br />
</p>
</card>
<card id="encoders" title="Encoders">
<p>
<?php echo $encoders ?>
</p>
</card>
<card id="schedules" title="Schedules">
<p>
<?php echo $sched ?>
</p>
</card>
<card id="jobs" title="Jobs">
<p>
<?php echo $JobData ?>
</p>
</card>
<card id="disks" title="Disks">
<p>
<?php echo $disk ?>
</p>
</card>
<card id="load" title="Load">
<p>
<?php echo $load ?>
</p>
</card>
<card id="fill" title="MythFillDB">
<p>
<?php echo $fill ?>
</p>
</card>
</wml>
