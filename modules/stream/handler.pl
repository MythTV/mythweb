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

# Print the header
    print header(-type                => $type,
                 -Content_length      => $size,
                 -Content_disposition => " attachment; filename=\"$name\""
                );

# Open the file for reading
    unless (open DATA, $filename) {
        print header(),
              "Can't read $basname:  $!";
        exit;
    }

# Print the content to the browser
    my $buffer;
    while (!eof DATA) {
        read DATA, $buffer, 262144;
        print $buffer;
    }
    close DATA;

# Return true
    1;

