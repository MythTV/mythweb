#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
# @url       $URL$
# @date      $Date$
# @version   $Revision$
# @author    $Author$
#

# Necessary constants for sysopen
    use Fcntl;

# Other includes
    use Sys::Hostname;

# Autoflush
    $|++;

    our $ffmpeg_pid;

# Shutdown cleanup, of various types
    $SIG{'TERM'} = \&shutdown_handler;
    $SIG{'PIPE'} = \&shutdown_handler;
    END {
        shutdown_handler();
    }
    sub shutdown_handler {
        kill(1, $ffmpeg_pid) if ($ffmpeg_pid);
    }

# Which show are we streaming?
    our $chanid    = url_param('chanid');
    our $starttime = url_param('starttime');
    if ($Path[1]) {
        $chanid    = $Path[1];
        $starttime = $Path[2];
        $starttime =~ s/\.\w+$//;
    }

# Find ffmpeg
    $ffmpeg = '';
    foreach my $path (split(/:/, $ENV{'PATH'}.':/usr/local/bin:/usr/bin'), '.') {
        if (-e "$path/ffmpeg") {
            $ffmpeg = "$path/ffmpeg";
            last;
        }
        elsif ($^O eq 'darwin' && -e "$path/ffmpeg.app") {
            $ffmpeg = "$path/ffmpeg.app";
            last;
        }
    }

# Get the basename from the database
    my $sh = $dbh->prepare('SELECT basename, title, subtitle
                              FROM recorded
                             WHERE starttime=FROM_UNIXTIME(?)
                                   AND recorded.chanid   = ?');
    $sh->execute($starttime, $chanid);
    my ($basename, $title, $subtitle) = $sh->fetchrow_array();
    $sh->finish;

# No match?
    unless ($basename =~ /\w/) {
        print header(),
              "Unknown recording requested.\n";
        exit;
    }

# Find the local file
    my $filename;
       $sh = $dbh->prepare('SELECT DISTINCT dirname
                              FROM storagegroup');
    $sh->execute();
    while (my ($video_dir) = $sh->fetchrow_array()) {
        next unless (-e "$video_dir/$basename");
        $filename = "$video_dir/$basename";
        last;
    }
    $sh->finish;

    unless ($filename) {
        print header(),
              "$basename does not exist in any recognized storage group directories for this host.";
        exit;
    }

# Load some conversion settings from the database
    $sh = $dbh->prepare('SELECT data FROM settings WHERE value=? AND hostname IS NULL');
    $sh->execute('WebFLV_w');
    my ($width)    = $sh->fetchrow_array;
    $sh->execute('WebFLV_vb');
    my ($vbitrate) = $sh->fetchrow_array;
    $sh->execute('WebFLV_ab');
    my ($abitrate) = $sh->fetchrow_array;

    $width    = 320 unless ($width    && $width    > 1);
    $vbitrate = 256 unless ($vbitrate && $vbitrate > 1);
    $abitrate = 64  unless ($abitrate && $abitrate > 1);

# Someday, we can auto-detect height based on aspect ratio
    my $height = int($width * 3/4);

# ASX mode?
    if ($ENV{'REQUEST_URI'} =~ /\.asx$/i) {
    # URI back to this file?  We just need to take the current URI and strip
    # off the .asx suffix.
        my $uri = ($ENV{'HTTPS'} || $ENV{'SERVER_PORT'} == 443)
                   ? 'https'
                   : 'http';
        my $serverAddr = $ENV{'HTTP_X_FORWARDED_HOST'} || $ENV{'SERVER_NAME'} || $ENV{'SERVER_ADDR'};
        $uri .= '://'.$serverAddr.':'.$ENV{'SERVER_PORT'}
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
        exit;
    }

# Flash?
    elsif ($ENV{'REQUEST_URI'} =~ /\.flvp$/i) {
    # URI back to this file?  We just need to take the current URI and strip
    # off the .flvp suffix.
        my $uri = ($ENV{'HTTPS'} || $ENV{'SERVER_PORT'} == 443)
                   ? 'https'
                   : 'http';
        $uri .= '://'.($ENV{'SERVER_NAME'} or $ENV{'SERVER_ADDR'}).':'.$ENV{'SERVER_PORT'}
               .$ENV{'REQUEST_URI'};
        $uri =~ s/\.flvp$/\.flv/i;
    # Print a page to hold the player
        print header();
        print <<EOF;
<html>
<head>
</head>
<body>
<embed src="${web_root}tv/flvplayer.swf" width="320" height="260" bgcolor="#FFFFFF"
type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"
flashvars="file=$uri&autoStart=true" />
</body>
EOF
        exit;
    }
    elsif ($ENV{'REQUEST_URI'} =~ /\.flv$/i) {
    # Print the movie
        $ffmpeg_pid = open(DATA,
            "$ffmpeg -y -i ".shell_escape($filename)
            .' -s '.shell_escape("${width}x$height")
            .' -r 24 -f flv -ac 2 -ar 11025'
            .' -ab '.shell_escape("${abitrate}k")
            .' -b '.shell_escape("${vbitrate}k")
            .' /dev/stdout 2>/dev/null |'
            );
        unless ($ffmpeg_pid) {
            print header(),
                  "Can't do ffmpeg:  $!";
            exit;
        }
        print header(-type => 'video/x-flv');
        my $buffer;
        while (read DATA, $buffer, 262144) {
            print $buffer;
        }
        close DATA;
        exit;
    }

# File size
    my $size = -s $filename;

# Zero bytes?
    if ($size < 1) {
        print header(),
              "$basename is an empty file.";
        exit;
    }

# File type
    my $type   = 'text/html';
    my $suffix = '';
    if ($basename =~ /\.mpe?g2?$/) {
        $type   = 'video/mpeg';
        $suffix = '.mpg';
    }
    elsif ($basename =~ /\.nuv$/) {
        $type   = 'video/nuppelvideo';
        $suffix = '.nuv';
    }
    else {
        print header(),
              "Unknown video type requested:  $basename\n";
        exit;
    }

# Download filename
    my $name = $basename;
    if ($name =~ /^\d+_\d+\.\w+$/) {
        $name = $title;
        if ($subtitle =~ /\w/) {
            $name .= " - $subtitle";
        }
        $name .= $suffix;
    }

# Open the file for reading
    unless (sysopen DATA, $filename, O_RDONLY) {
        print header(),
              "Can't read $basename:  $!";
        exit;
    }

# Binmode, in case someone is running this from Windows.
    binmode DATA;

# Requested a range?
    my $start      = 0;
    my $end        = $size;
    my $total_size = $size;
    if ($ENV{'HTTP_RANGE'}) {
    # Figure out the size of the requested chunk
        ($start, $end) = $ENV{'HTTP_RANGE'} =~ /bytes\W+(\d*)-(\d*)\W*$/;
        $start ||= 0;
        if ($end < 1 || $end > $size) {
            $end = $size;
        }
        $size = $end - $start;
    }

# Print the header
    print header(-type                => $type,
                 -Content_length      => $size,
                 -Accept_Ranges       => 'bytes',
                 -Content_disposition => " attachment; filename=\"$name\"",
                 -Content_Range       => "bytes $start-$end/$total_size"
                );

# Seek to the requested position
    sysseek DATA, $start, 0;

# Print the content to the browser
    my $buffer;
    while (sysread DATA, $buffer, 262144) {
        print $buffer;
    }
    close DATA;

###############################################################################

# Escape a parameter for safe use in a commandline call
    sub shell_escape {
        $str = shift;
        $str =~ s/'/'\\''/sg;
        return "'$str'";
    }

# Return true
    1;

