<?php

function nice_date($timestamp)
{
	$midnight   = strtotime('12:00 am');
	$delta_days = floor(($timestamp - $midnight) / 86400);
	if (0 == $delta_days)
		$ret = "Today";
	elseif (1 == $delta_days)
		$ret = "Tomorrow";
	elseif (-1 == $delta_days)
		$ret = "Yesterday";
	elseif (7 > abs($delta_days))
		$ret = strftime('%A', $timestamp);
	else
		$ret = strftime('%B %e, %Y', $timestamp);

	return $ret;
}

function nice_duration($time)
{
	return floor($time / 3600) . date(":i", $time);
}

?>
