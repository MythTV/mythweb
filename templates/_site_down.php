<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Down for maintenance</title>

    <style type="text/css">
		body	 { background-color:#ccc }
		#message {
            position:           absolute;
            top:                50%;
            left:               50%;
            height:             13em;
            margin-top:         -6.5em;
            width:              40%;
            margin-left:        -20%;
            line-height:        2em;
            text-align:         center;
            border:             2px ridge #228;
            background-color:   white
        }
	</style>

</head>

<body>

<div id="message">

<h2>Database Error</h2>

<p>
<?php echo htmlentities($db->error) ?>
</p>

</div>

</body>
</html>