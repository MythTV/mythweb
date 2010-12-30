#!/usr/bin/perl
#
# MythWeb Streaming/Download module
#
#

# Necessary constants for sysopen
    use Fcntl;

# Other includes
    use Sys::Hostname;

    require "modules/$Path[0]/tv.pl";

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
# Mpeg4?
    elsif ($ENV{'REQUEST_URI'} =~ /\.mp4$/i) {
        require "modules/$Path[0]/stream_mp4.pl";
    }
# Raw file?
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
