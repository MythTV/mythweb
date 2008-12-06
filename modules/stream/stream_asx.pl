#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
# @url       $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/stream/handler.pl $
# @date      $Date: 2008-08-28 18:51:49 -0700 (Thu, 28 Aug 2008) $
# @version   $Revision: 18224 $
# @author    $Author: nigel $
#

# URI back to this file?  We just need to take the current URI and strip
# off the .asx suffix.
    my $uri = ($ENV{'HTTPS'} || $ENV{'SERVER_PORT'} == 443)
                ? 'https'
                : 'http';
    my $serverAddr = $ENV{'HTTP_X_FORWARDED_HOST'} || $ENV{'SERVER_NAME'} || $ENV{'SERVER_ADDR'};
# Attempt to remove the port out of the serverAddr if it's in there
    $serverAddr =~ tr/:[0-9]+//;
    my $serverPort = $ENV{'HTTP_X_FORWARDED_PORT'} || $ENV{'SERVER_PORT'};
    $uri .= '://'.$serverAddr.':'.$serverPort
            .$ENV{'REQUEST_URI'};

    $uri =~ s/\.asx$//i;
# Build the ASX file so we can know how long it is
    my $file = <<EOF;
<ASX version = "3.0">
<TITLE>$title</TITLE>
<ENTRY>
<TITLE>$title - $subtitle</TITLE>
<AUTHOR>MythTV - MythWeb</AUTHOR>
<COPYRIGHT>GPL</COPYRIGHT>
<REF HREF = "$uri" />
</ENTRY>
</ASX>
EOF
# Print out the HTML headers and the ASX file itself
    print header(-type                => 'video/x-ms-asf',
                -Content_length      => length($file),
                -Content_disposition => " attachment; filename=\"$title-$subtitle.asx\"",
                ),
            $file;

    1;
