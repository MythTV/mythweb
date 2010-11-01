#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
# @url       $URL$
# @date      $Date$
# @version   $Revision$
# @author    $Author$
#

    use POSIX qw(ceil floor);

# round to the nearest even integer
    sub round_even {
        my ($in) = @_;
        my $n = floor($in);
        return ($n % 2 == 0) ? $n : ceil($in);
    }

    our $ffmpeg_pid;
    our $ffmpeg_pgid;

# Shutdown cleanup, of various types
    $ffmpeg_pgid = setpgrp(0,0);
    $SIG{'TERM'} = \&shutdown_handler;
    $SIG{'PIPE'} = \&shutdown_handler;
    END {
        shutdown_handler();
    }
    sub shutdown_handler {
        kill(1, $ffmpeg_pid) if ($ffmpeg_pid);
        kill(-1, $ffmpeg_pgid) if ($ffmpeg_pgid);
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
    $sh->finish();
# auto-detect height based on aspect ratio
    $sh = $dbh->prepare('SELECT data FROM recordedmarkup WHERE chanid=? AND starttime=FROM_UNIXTIME(?) AND (type=30 OR type=31) AND data IS NOT NULL ORDER BY type');
    $sh->execute($chanid,$starttime);
    $x = $sh->fetchrow_array;           # type = 30
    $y = $sh->fetchrow_array if ($x);   # type = 31
    $width = round_even($width);
    if ($x && $y) {
        $height = round_even($width * ($y/$x));
    } else {
        $height = round_even($width * 3/4);
    }
    $sh->finish();

    $width    = 320 unless ($width    && $width    > 1);
    $height   = 240 unless ($height   && $height   > 1);
    $vbitrate = 256 unless ($vbitrate && $vbitrate > 1);
    $abitrate = 64  unless ($abitrate && $abitrate > 1);

    my $ffmpeg_command = $ffmpeg
                        .' -y'
                        .' -i '.shell_escape($filename)
                        .' -s '.shell_escape("${width}x${height}")
                        .' -g 30'
                        .' -r 24'
                        .' -f flv'
                        .' -deinterlace'
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
    # Guess the filesize based on duration and bitrate. This allows for progressive download behavior
    my $lengthSec;
    $dur = `ffmpeg -i $filename 2>&1 | grep "Duration" | cut -d ' ' -f 4 | sed s/,//`;
    if ($dur && $dur =~ /\d*:\d*:.*/) {
        @times = split(':',$dur);
        $lengthSec = $times[0]*3600+$times[1]*60+$times[2];
        $size = int($lengthSec*($vbitrate*1000+$abitrate*1000)/8);
        print header(-type => 'video/x-flv','Content-Length' => $size);
    } else {
        print header(-type => 'video/x-flv');
    }

    my $buffer;
    if (read DATA, $buffer, 53) {
        print $buffer;
        read DATA, $buffer, 8;
        $durPrint = reverse pack("d",$lengthSec);
        print $durPrint;
        while (read DATA, $buffer, 262144) {
            print $buffer;
        }
    }
    close DATA;

    1;
