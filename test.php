<?php
include 'torrent9/search.php';

class Plugin
{
    public function __construct()
    {
    }

    public function addResult($title, $download, $size, $datetime, $page, $hash, $seeds, $leechs, $category) {
        echo "$title - $download - $size - $datetime - $page - $hash - $seeds - $leechs - $category";
        echo "\n";
    }
}

$plugin = new Plugin();

$t9Search = new Torrent9Search();
$curl = curl_init();
$t9Search->prepare($curl, 'thrones');
$response = curl_exec($curl);
echo $t9Search->parse($plugin, $response);
curl_close($curl);
?>