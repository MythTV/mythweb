#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
#

    use Sys::Hostname;

# Attempt to use the perl bindings to prevent the backend from shutting down during streaming
    eval 'use MythTV;';

    if (!$@) {
        our $mythbackend = new MythTV();
        $mythbackend->backend_command('ANN Playback '.hostname);
    }

# Which show are we streaming?
    our $chanid    = url_param('chanid');
    our $starttime = url_param('starttime');
    if ($Path[1]) {
        $chanid    = $Path[1];
        $starttime = $Path[2];
        $starttime =~ s/\.\w+$//;
    }

# Get the basename from the database
    my $sh = $dbh->prepare('SELECT basename, title, subtitle, endtime-starttime, season, episode
                              FROM recorded
                             WHERE starttime=FROM_UNIXTIME(?)
                                   AND recorded.chanid   = ?');
    $sh->execute($starttime, $chanid);
    our ($basename, $title, $subtitle, $runtime, $season, $episode) = $sh->fetchrow_array();
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
    }
    $sh->finish;

    1;
