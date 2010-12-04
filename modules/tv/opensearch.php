<?php
/**
 * An OpenSearch system for suggesting program names from the firefox toolbar
 *
 * @license     GPL
 *
 * @package     MythWeb
 * @subpackage  TV
 *
/**/

// Requesting information about the search query itself
    if ($_REQUEST['type'] == 'xml') {
        header("Content-Type: application/xml");
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/">
    <ShortName>MythTV</ShortName>
    <Description>Search MythTV</Description>
    <Url type="application/x-suggestions+json"
         method="GET"
         template="<?php echo root_url ?>tv/opensearch?type=suggest&amp;search={searchTerms}">
    </Url>
    <Url type="text/html"
         method="GET"
         template="<?php echo root_url ?>tv/search/?type=q&amp;search=Search&amp;s={searchTerms}">
    </Url>
    <Image height="16" width="16" type="image/png"><?php echo skin_url ?>img/favicon.ico</Image>
</OpenSearchDescription>
<?php
    }

// Requesting a search suggestion
    elseif ($_REQUEST['type'] == 'suggest') {
    // Error notification
        if (!isset($_REQUEST['search'])) {
            echo "ERROR: Must have a search term";
            exit;
        }
    // Do a basic query for similar program titles
        $matches = $db->query_list('SELECT DISTINCT title
                                      FROM program
                                     WHERE title LIKE ?
                                  ORDER BY title
                                     LIMIT 10',
                                   $_REQUEST['search'].'%');
    // Print the list of found suggestions
        $comma = false;
        echo '["', addslashes($_REQUEST['search']), '",[';
        foreach ($matches as $match) {
            if ($comma)
                echo ',';
            else
                $comma = true;
            echo '"', addslashes($match),'"';
        }
        echo ']]';
    }

// Done
    exit;
