<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo htmlentities($title, ENT_COMPAT, 'UTF-8') ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo root ?>skins/errors.css">
</head>

<body>

<div id="message">

<h2><?php echo htmlentities($header, ENT_COMPAT, 'UTF-8') ?></h2>

<p>
<?php echo nl2br(htmlentities($text, ENT_COMPAT, 'UTF-8')) ?>
</p>

</div>

</body>
</html>
