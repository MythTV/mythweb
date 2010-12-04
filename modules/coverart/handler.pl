#!/usr/bin/perl
#
# MythWeb Coverart/Download module
#
#

# Necessary constants for sysopen
    use Fcntl;

# Other includes
    use Sys::Hostname;
    use HTTP::Date;

# Attempt to use the perl bindings to prevent the backend from shutting down during streaming
    eval 'use MythTV;';

    if (!$@) {
        our $mythbackend = new MythTV();
        $mythbackend->backend_command('ANN Playback '.hostname);
    }

# Which cover are we displaying
    our $cover    = url_param('cover');
    if ($Path[1]) {
        $cover    = $Path[1];
    }

# No match?
    unless ($cover =~ /\w/) {
        print header(),
              "Unknown cover requested.\n";
        exit;
    }

# Find the local file
    our $filename;
    $sh = $dbh->prepare('SELECT dirname FROM storagegroup WHERE groupname = "Coverart"');
    $sh->execute();
    while (my ($coverart_dir) = $sh->fetchrow_array()) {
        next unless (-e "$coverart_dir/$cover");
        $filename = "$coverart_dir/$cover";
        last;
    }
    $sh->finish;

    1;

    unless ($filename) {
        print header(),
              "$cover does not exist in any recognized storage group directories for this host.";
        exit;
    }

# File size
    my $size = -s $filename;

# Zero bytes?
    if ($size < 1) {
        print header(),
              "$cover is an empty file.";
        exit;
    }

# File type
    my $type   = 'text/html';
    my $suffix = '';
    if ($cover =~ /\.jpg$/) {
        $type   = 'image/jpeg';
        $suffix = '.jpg';
    }
    else {
        print header(),
              "Unknown image type requested:  $cover\n";
        exit;
    }

# Open the file for reading
    unless (sysopen DATA, $filename, O_RDONLY) {
        print header(),
              "Can't read $cover:  $!";
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
                     -Content_disposition => " attachment; filename=\"$cover\""
                 );
    }
    else {
        print header(-type                  => $type,
                    -Content_length         => $size,
                    -Accept_Ranges          => 'bytes',
                    -Last_Modified          => time2str($mtime),
                    -Content_disposition => " attachment; filename=\"$cover\""
                 );
    }

# Seek to the requested position
    sysseek DATA, $start, 0;

# Print the content to the browser
    my $buffer;
    while (sysread DATA, $buffer, $read_size ) {
        print $buffer;
        $size -= $read_size;
        if ($size == 0) {
            last;
        }
        if ($size < $read_size) {
            $read_size = $size;
        }
    }
    close DATA;

# Escape a parameter for safe use in a commandline call
    sub shell_escape {
        $str = shift;
        $str =~ s/'/'\\''/sg;
        return "'$str'";
    }

# Return true
    1;

