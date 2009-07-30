<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <title><?php echo htmlentities($errstr, ENT_COMPAT, 'UTF-8') ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo root ?>skins/errors.css">
</head>

<body>

<div id="message">

<h2>Fatal Error</h2>

<p class="err">
<?php echo nl2br(htmlentities($errstr, ENT_COMPAT, 'UTF-8')) ?>
</p>

<div id="backtrace">

    <p>
    If you choose to
    <b><u><a href="http://svn.mythtv.org/trac/newticket" target="_blank">submit a bug report</a></u></b>
    please make sure to include a brief description of what you were doing,
    along with the following backtrace as an attachment <i>(please don't
    just paste the whole thing into the ticket)</i>.
    </p>

    <textarea><?php echo htmlentities($err) ?></textarea>

</div>


</div>

</body>
</html>
