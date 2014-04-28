#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
#

    $| = 1;

    use HTTP::Date;

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
    elsif ($basename =~ /\.mkv$/) {
        $type   = 'video/x-matroska';
        $suffix = '.mkv';
    }
    elsif ($basename =~ /\.mp4$/) {
        $type   = 'video/mp4';
        $suffix = '.mp4';
    }
    elsif ($basename =~ /\.avi$/) {
        $type   = 'video/x-msvideo';
        $suffix = '.mp4';
    }
    elsif ($basename =~ /\.mov$/) {
        $type   = 'video/quicktime';
        $suffix = '.mov';
    }
    elsif ($basename =~ /\.wmv$/) {
        $type   = 'video/x-ms-wmv';
        $suffix = '.wmv';
    }
    elsif ($basename =~ /\.3gp$/) {
        $type   = 'video/3gpp';
        $suffix = '.3gp';
    }
    elsif ($basename =~ /\.ogv$/) {
        $type   = 'video/ogg';
        $suffix = '.ogv';
    }
    elsif ($basename =~ /\.webm$/) {
        $type   = 'video/webm';
        $suffix = '.webm';
    }
    else {
        print header(),
              "Unknown video type requested:  $basename\n";
        exit;
    }

# Download filename
    my $name = $basename;
    if ($name =~ /^\d+_\d+\.\w+$/) {
        if ($title =~ /\w/) {
            $name = $title;
            $name .= sprintf(" - %dx%02d", $season, $episode) if $season and $episode;
            if ($subtitle =~ /\w/) {
                $name .= " - $subtitle";
            }
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

    my $start      = 0;
    my $end        = $size;
    my $total_size = $size;
    my $read_size  = 1024;
    my $mtime      = (stat($filename))[9];

# Handle cache hits/misses
    if ( $ENV{'HTTP_IF_MODIFIED_SINCE'}) {
        my $check_time = str2time($ENV{'HTTP_IF_MODIFIED_SINCE'});
        if ($mtime <= $check_time) {
            print header(-Content_type           => $type,
                         -status                 => "304 Not Modified"
                        );
            exit;
        }
    }

# Requested a range?
    if ($ENV{'HTTP_RANGE'}) {
    # Figure out the size of the requested chunk
        ($start, $end) = $ENV{'HTTP_RANGE'} =~ /bytes\W+(\d*)-(\d*)\W*$/;
        if ($end < 1 || $end > $size) {
            $end = $size;
        }
        $size = $end - $start+1;
        if ($read_size > $size) {
            $read_size = $size;
        }
        print header(-status                => "206 Partial Content",
                     -type                  => $type,
                     -Content_length        => $size,
                     -Accept_Ranges         => 'bytes',
                     -Content_Range         => "bytes $start-$end/$total_size",
                     -Last_Modified         => time2str($mtime),
                     -Content_disposition => " attachment; filename=\"$name\""
                 );
    }
    else {
        print header(-type                  => $type,
                    -Content_length         => $size,
                    -Accept_Ranges          => 'bytes',
                    -Last_Modified          => time2str($mtime),
                    -Content_disposition => " attachment; filename=\"$name\""
                 );
    }

# RFC 3875 4.3.3. script MUST NOT provide a response message-body for a HEAD request
    if ($ENV{'REQUEST_METHOD'} eq 'HEAD') {
        exit;
    }

# Seek to the requested position
    sysseek DATA, $start, 0;

# Print the content to the browser
    my $buffer;
    while (sysread DATA, $buffer, $read_size ) {
    # Exit if the output pipe is broken i.e. client disconnect
        unless (print $buffer ) {
            last;
        }
        $size -= $read_size;
        if ($size <= 0) {
            my $fileSize = -s $filename;
            my $filePos  = tell DATA;
            if ( ($fileSize - $filePos) > 0 ) {
                $size = $fileSize - $filePos;
            }
            else {
                last;
            }
        }
        if ($size < $read_size) {
            $read_size = $size;
        }
        if ($read_size < 0) {
            $read_size = 0;
        }
    }
    close DATA;

    1;
