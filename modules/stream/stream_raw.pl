#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
# @url       $URL$
# @date      $Date$
# @version   $Revision$
# @author    $Author$
#

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

    1;
