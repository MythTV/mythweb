<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title>Database Setup Error</title>
    <link rel="stylesheet" type="text/css" href="<?php echo root ?>skins/errors.css" />
</head>

<body>

<div id="message">

<h2>Database Setup Error</h2>

<p>
The database environment variables are not correctly set in the<br />
included .htaccess file.  Please read through the comments included<br />
in the file and set up the db_* environment variables correctly.
</p>

<p>
Some possible solutions are to make sure that mod_env is enabled<br />
in httpd.conf, as well as having followed the instructions in the<br />
README about the AllowOverride settings.
</p>

</div>

</body>
</html>