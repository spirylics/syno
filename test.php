<?php
include 'torrent9/search.php';

class CheckPlugin
{
    public function __construct()
    {
    }

    public function addResult($title, $download, $size, $datetime, $page, $hash, $seeds, $leechs, $category)
    {
        echo "$title - $download - $size - $datetime - $page - $hash - $seeds - $leechs - $category";
        assert(!empty($title), "title not found");
        assert(!empty($download), "download not found");
        assert(!empty($size), "size not found");
        assert(!empty($seeds), "seeds not found");
        assert(!empty($leechs), "leechs not found");
        echo "\n";
    }
}

function checkResults($pluginClass, $query)
{
    $plugin = new CheckPlugin();

    $search = new $pluginClass();
    $curl = curl_init();
    $search->prepare($curl, $query);
    $response = curl_exec($curl);
    assert($search->parse($plugin, $response) > 0, "no result found");
    curl_close($curl);
}

checkResults("Torrent9Search", 'thrones');

?>