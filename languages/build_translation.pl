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
    my $mythweb_path   = dirname($languages_path);

# Make at least a reasonable attempt to make sure the script is where it's supposed to be
    die "Please make sure that this script is in the mythweb languages directory.\n"
        unless ($languages_path =~ /\/languages$/ && -e "$languages_path/English.php");

# Scan the files
    print "Scanning php files in $mythweb_path\n";
    finddepth({wanted => \&process}, $mythweb_path);

# Scan for the lengths of strings, so we can pad nicely
    my %lengths;
    foreach my $file (sort keys %strings) {
        if (keys %{$strings{$file}} < 1) {
            delete $strings{$file};
            next;
        }
        foreach my $str (sort keys %{$strings{$file}}) {
            my $fixed = $str;
            $fixed =~ s/'/\\'/sg;
            $lengths{$file} = length($fixed) if (!$lengths{$file} || $lengths{$file} < length($fixed));
        }
    }

# Scan the language files and update them for any missing strings
    foreach my $trans_file (<$languages_path/*php>) {
    # Slurp in the file
        my $data = '';
        open (DATA, $trans_file) or die "Can't read $trans_file:  $!\n";
        $data .= $_ while (<DATA>);
        close DATA;
    # Extract any existing strings
        unless ($data =~ /\n\s*\$L\s*=\s*array\(\s*\n(.+?)\n\s*\);/s) {
            print "No \$L array defined in $trans_file\n";
            next;
        }
        my $chunk = $1;
    # Remove comments
        $chunk =~ s#/\*.+?\*/##sg;
        $chunk =~ s#\s*(\#|//).+##mg;
    # Pull out each individual string pair
        my %translations;
        foreach my $line (split(/\s*\n\s*/, $chunk)) {
            next unless ($line =~ /\w/);
            my ($term, $trans) = split(/\s*=>\s*/, $line);
            $translations{clean_string($term)} = clean_string($trans);
        }
    # Build new array text
        my $new = "// Define the language lookup hash ** Do not touch the next line\n\$L = array(\n// Add your translations below here.\n// Warning, any custom comments will be lost during translation updates.\n//\n";
        foreach my $file (sort keys %strings) {
            my $safe = $file;
            $safe =~ s/^\s+//;
            $new .= "// $safe\n";
            foreach my $str (sort keys %{$strings{$file}}) {
                $safe = $str;
                $safe =~ s/'/\\'/sg;
                $new .= "    '$safe'"
                        .(' ' x ($lengths{$file} - length($safe)))
                        ." => '";
                if ($translations{$str}) {
                    $safe = $translations{$str};
                    $safe =~ s/'/\\'/sg;
                    $new .= $safe;
                }
                $new .= "',\n";
            }
        }
        $new =~ s#,\n$#\n// End of the translation hash ** Do not touch the next line\n          );\n#s;
    # Replace the new strings into $data
        $data =~ s#(?:\s*//[^\n]+)?\n\s*\$L\s*=\s*array\(\s*\n(.+?)\n\s*\);\s*#\n\n$new\n\n#s;
    # Print it back to the file
        open(DATA, ">$languages_path/tmp.$$.php") or die "Couldn't create tempfile $languages_path/tmp.$$.php:  $!\n";
        print DATA $data;
        close DATA;
        rename("$languages_path/tmp.$$.php", $trans_file) or die "Couldn't rename $languages_path/tmp.$$.php to $trans_file:  $!\n";
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
    # Skip non-default themes
    #   if ($File::Find::dir =~ /^theme\//) {
    #       return unless ($File::Find::dir =~ m#^themes/Default/#);
    #   }
    # Load the file contents
        my $data = '';
        open(TEXT, $this_file) or die "Can't open $File::Find::dir/$this_file:  $!\n\n";
        $data .= $_ while (<TEXT>);
        close TEXT;
    # Scan for translation strings
        my %str;
        while ($data =~ /\bt\(('.+?(?<!\\)'|".+?(?<!\\)")\s*[,\)]/sg) {
            $str{clean_string($1)} = 1;
        }
        while ($data =~ /\btn\(((?:(?:'.+?(?<!\\)'|".+?(?<!\\)")(?:\s*,\s*))+)/sg) {
            foreach my $s (split(/\s*,\s*/, $1)) {
                next unless ($s =~ /\w/);
                $str{clean_string($s)} = 1;
            }
        }
    # Get a local pathname for the file, and genericize themes files
        $this_file = $File::Find::name;
        $this_file =~ s/^$mythweb_path\///;
        $this_file =~ s#^themes/Default/#themes/.../#;
    # Now we file the string appropriately
        foreach my $str (keys %str) {
            my $found = 0;
            foreach my $file (keys %strings) {
            # Skip this file
                next if ($file eq $this_file);
            # No other matches?
                next unless ($strings{$file}{$str});
            # Delete it from the other, unless it's already marked as shared
                if ($file ne ' Shared Terms') {
                    delete $strings{$file}{$str};
                    $strings{' Shared Terms'}{$str}++;
                }
            # Make a note, and leave this loop
                $found = 1;
                last;
            }
            next if ($found);
            $strings{$this_file}{$str}++;
        }
    }

    sub clean_string {
        my $str = shift;
        if (eval("\$str = $str;")) {
            return $str;
        }
        return '';
    }

