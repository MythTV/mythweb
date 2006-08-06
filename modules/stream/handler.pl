#
# MythWeb Streaming/Download module
#
# @url       $URL$
# @date      $Date$
# @version   $Revision$
# @author    $Author$
#

# Autoflush
    $|++;

# Which show are we streaming?
    our $chanid    = url_param('chanid');
    our $starttime = url_param('starttime');
    if ($Path[1]) {
        $chanid    = $Path[1];
        $starttime = $Path[2];
        $starttime =~ s/\.\w+$//;
    }

# Get the basename from the database
    my $sh = $dbh->prepare('SELECT basename, title, subtitle FROM recorded WHERE chanid=? AND starttime=FROM_UNIXTIME(?)');
    $sh->execute($chanid, $starttime);
    my ($basename, $title, $subtitle) = $sh->fetchrow_array();
    $sh->finish;

# No match?
    unless ($basename =~ /\w/) {
        print header(),
              "Unknown recording requested.\n";
        exit;
    }

# Filename on disk
    my $filename = "data/recordings/$basename";

# Make sure the file exists
    unless (-e $filename) {
        print header(),
              "$basename does not exist in the recordings directory.";
        exit;
    }

# File size
    my $size = -s $filename;

# File type
    my $type   = 'text/html';
    my $suffix = '';
    if ($basename =~ /\.mpe?g$/) {
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
    unless (open DATA, $filename) {
        print header(),
              "Can't read $basname:  $!";
        exit;
    }


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
    while (!eof DATA) {
    # Make sure we don't read more than was requested
        my $readsize = 262144;
        my $cur_pos  = tell(DATA);
        if ($cur_pos + $readsize > $size) {
            $readsize = $size = $cur_pos;
        }
    # Print the data to the browser
        sysread DATA, $buffer, $readsize;
        print $buffer;
    # Time to leave?
        last if ($cur_pos + $readsize >= $size);
    }
    close DATA;

# Return true
    1;

