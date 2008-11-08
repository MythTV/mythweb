#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
# @url       $URL: svn+ssh://svn.mythtv.org/var/lib/svn/trunk/mythplugins/mythweb/modules/stream/handler.pl $
# @date      $Date: 2008-08-28 18:51:49 -0700 (Thu, 28 Aug 2008) $
# @version   $Revision: 18224 $
# @author    $Author: nigel $
#

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

# Load some conversion settings from the database
    $sh = $dbh->prepare('SELECT data FROM settings WHERE value=? AND hostname IS NULL');
    $sh->execute('WebFLV_w');
    my ($width)    = $sh->fetchrow_array;
    $sh->execute('WebFLV_vb');
    my ($vbitrate) = $sh->fetchrow_array;
    $sh->execute('WebFLV_ab');
    my ($abitrate) = $sh->fetchrow_array;
# Someday, we can auto-detect height based on aspect ratio
    my $height = int($width * 3/4);

    $sh->finish();

    $width    = 320 unless ($width    && $width    > 1);
    $height   = 240 unless ($height   && $height   > 1);
    $vbitrate = 256 unless ($vbitrate && $vbitrate > 1);
    $abitrate = 64  unless ($abitrate && $abitrate > 1);

    my $ffmpeg_command = $ffmpeg
                        .' -y'
                        .' -i '.shell_escape($filename)
                        .' -s '.shell_escape("${width}x${height}")
                        .' -r 24'
                        .' -f flv'
                        .' -ac 2'
                        .' -ar 11025'
                        .' -ab '.shell_escape("${abitrate}k")
                        .' -b '.shell_escape("${vbitrate}k")
                        .' /dev/stdout 2>/dev/null |';

# Print the movie
    $ffmpeg_pid = open(DATA, $ffmpeg_command);
    unless ($ffmpeg_pid) {
        print header(),
                "Can't do ffmpeg: $!\n${ffmpeg_command}";
        exit;
    }
    print header(-type => 'video/x-flv');
    my $buffer;
    while (read DATA, $buffer, 262144) {
        print $buffer;
    }
    close DATA;

    1;
