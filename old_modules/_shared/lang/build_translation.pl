#!/usr/bin/perl -w
#Last Updated: 2004.11.29 (xris)
#
#  build_translation.pl
#
#   scans mythweb files for translation strings, and builds
#

# Load some required libraries
    use File::Find;
    use English;
    use Cwd 'abs_path';
    use File::Basename;

# Slurp mode!
    $/ = undef;

# Initialize the strings hash
    my %strings;

# Find the mythweb dir
    my $languages_path = dirname(abs_path($PROGRAM_NAME));
    my $mythweb_path   = dirname(dirname(dirname($languages_path)));

# Make at least a reasonable attempt to make sure the script is where it's supposed to be
    die "Please make sure that this script is in modules/_shared/lang/\n"
        unless ($languages_path =~ /\/lang$/ && -e "$languages_path/English.lang");

# Scan the files
    print "Scanning php files in $mythweb_path\n";
    finddepth({wanted => \&process}, $mythweb_path);

# Scan the language files and update them for any missing strings
    foreach my $trans_file (<$languages_path/*lang>) {
    # Slurp in the file
        my $data = '';
        open (DATA, $trans_file) or die "Can't read $trans_file:  $!\n";
        $data .= $_ while (<DATA>);
        close DATA;
    # Extract any existing strings
        my %translations = ();
        foreach my $group (split /\n(?=\S)/, $data) {
            my ($key, $indent, $trans) = $group =~ /^([^\n]+?)\s*(?:$|\s*\n(\s+)(.+)$)/s;
        # Cleanup
            $key   =~ s/^\s+//;
            $key   =~ s/\s+$//;
            if ($key =~ /^["\']/) {
                $key =~ s/^(["\'])(.+)\1$/$2/sg;
            }
            if ($trans) {
                $trans =~ s/\n$indent/\n/sg;
                $trans =~ s/^\s+//;
                $trans =~ s/\s+$//;
            }
            else {
                next;
            }
        # Store
            $translations{$key} = $trans;
        }
    # Open a new output file
        open(DATA, ">$languages_path/tmp.$$.lang") or die "Couldn't create tempfile $languages_path/tmp.$$.lang:  $!\n";
    # Build the new file
        foreach my $str (sort { lc($a) cmp lc($b) } keys %strings) {
            print DATA "\"$str\"\n";
            if ($translations{$str}) {
                my $trans = $translations{$str};
                   $trans =~ s/\n/\n    /g;
                print DATA "    $trans\n";
            }
        }
    # Close and rename the file into place
        close DATA;
        rename("$languages_path/tmp.$$.lang", $trans_file) or die "Couldn't rename $languages_path/tmp.$$.lang to $trans_file:  $!\n";
    # Notify the user
        print "Updated:  $trans_file\n";
    }

# This subroutine does all of the work
    sub process {
        my $this_file = $_;
    # Not a php file?
        return unless ($this_file =~ /\.php$/i);
    # Skip language files
        return if ($File::Find::dir eq "$mythweb_path/languages");
    # For some reason, the file is gone?
        return unless (-e $this_file);
    # Load the file contents
        my $data = '';
        open(TEXT, $this_file) or die "Can't open $File::Find::dir/$this_file:  $!\n\n";
        $data .= $_ while (<TEXT>);
        close TEXT;
    # Scan for translation strings
        while ($data =~ /\bt\(('.+?(?<!\\)'|".+?(?<!\\)")\s*[,\)]/sg) {
            $strings{clean_string($1)}++;
        }
        while ($data =~ /\btn\(((?:(?:'.+?(?<!\\)'|".+?(?<!\\)")(?:\s*,\s*))+)/sg) {
            foreach my $s (split(/\s*,\s*/, $1)) {
                next unless ($s =~ /\w/);
                $strings{clean_string($s)}++;
            }
        }
    }

    sub clean_string {
        my $str = shift;
        if (eval("\$str = $str;")) {
            return $str;
        }
        return '';
    }

