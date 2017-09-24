<?php

class Torrent9Search
{
    private $qurl = 'http://www.torrent9.pe/search_torrent/%s.html';

    public function __construct()
    {
    }

    public function prepare($curl, $query)
    {
        $url = sprintf($this->qurl, urlencode($query));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    }


    public function parse($plugin, $response)
    {
        $count = 0;
        for ($i = 0; $i < 10; $i++) {
            $title = "title" . $count;
            $download = "download" . $count;
            $size = $count;
            $datetime = "2017-06-08 14:57:21";
            $page = "page" . $count;
            $hash = $count;
            $seeds = $count;
            $leechs = $count;
            $category = "category" . $count;
            $plugin->addResult($title, $download, $size, $datetime, $page, $hash, $seeds, $leechs, $category);
            $count++;
        }
        return $count;
    }
}

?>