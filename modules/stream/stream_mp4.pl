#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#

    $| = 1;

    use HTTP::Date;

    $filename =~ s/mpg$/mp4/g;
    $basename =~ s/mpg$/mp4/g;
    $filename =~ s/nuv$/mp4/g;
    $basename =~ s/nuv$/mp4/g;

# File size
    my $size = -s $filename;

# Zero bytes?
    if ($size < 1) {
        print header(),
              "$basename is an empty file.";
        exit;
    }

# File type
    my $type   = 'video/mp4';
    my $suffix = '.mp4';

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
        print header(-status                 => "206 Partial Content",
                     -type                   => $type,
                     -Content_length         => $size,
                     -Accept_Ranges          => 'bytes',
                     -Content_Range          => "bytes $start-$end/$total_size",
                     -Last_Modified          => time2str($mtime)
                 );
    }
    else {
        print header(-type                  => $type,
                    -Content_length         => $size,
                    -Accept_Ranges          => 'bytes',
                    -Last_Modified          => time2str($mtime)
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
        if ($size == 0) {
            last;
        }
        if ($size < $read_size) {
            $read_size = $size;
        }
    }
    close DATA;

    1;
