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

# Which show are we streaming?
    our $chanid    = url_param('chanid');
    our $starttime = url_param('starttime');
    if ($Path[1]) {
        $chanid    = $Path[1];
        $starttime = $Path[2];
        $starttime =~ s/\.\w+$//;
    }

# Get the basename from the database
    my $sh = $dbh->prepare('SELECT basename, title, subtitle, endtime-starttime
                              FROM recorded
                             WHERE starttime=FROM_UNIXTIME(?)
                                   AND recorded.chanid   = ?');
    $sh->execute($starttime, $chanid);
    our ($basename, $title, $subtitle, $runtime) = $sh->fetchrow_array();
    $sh->finish;

# No match?
    unless ($basename =~ /\w/) {
        print header(),
              "Unknown recording requested.\n";
        exit;
    }

# Find the local file
    our $filename;
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

# ASX mode?
    if ($ENV{'REQUEST_URI'} =~ /\.asx$/i) {
        require "modules/$Path[0]/stream_asx.pl";
    }
# Flash?
    elsif ($ENV{'REQUEST_URI'} =~ /\.flvp$/i) {
        require "modules/$Path[0]/stream_flvp.pl";
    }
    elsif ($ENV{'REQUEST_URI'} =~ /\.flv$/i) {
        require "modules/$Path[0]/stream_flv.pl";
    }
    else {
        require "modules/$Path[0]/stream_raw.pl";
    }

###############################################################################

# Escape a parameter for safe use in a commandline call
    sub shell_escape {
        $str = shift;
        $str =~ s/'/'\\''/sg;
        return "'$str'";
    }

# Return true
    1;
