<?php

class Torrent9Search
{
    CONST BASE_URL = 'http://www.torrent9.pe';
    CONST QUERY_URL = self::BASE_URL . '/search_torrent/%s.html';
    CONST GET_URL = self::BASE_URL . '/get_torrent/%s.torrent';
    CONST SIZE_MAP = array(
        "Ko" => 1024,
        "Mo" => 1048576,
        "Go" => 1073741824,
    );

    public function __construct()
    {
    }

    public function prepare($curl, $query)
    {
        $url = sprintf(self::QUERY_URL, urlencode($query));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    }


    public function parse($plugin, $response)
    {
        $doc = new DOMDocument();
        $doc->loadHTML($response);
        $xpath = new DOMXpath($doc);
        $torrents = $xpath->query("//table/tbody/tr");

        $count = 0;
        if (!is_null($torrents)) {
            $count = $torrents->length;
            foreach ($torrents as $torrent) {
                $first = $torrent->childNodes[0];
                $title = $first->nodeValue;
                $path = $first->getElementsByTagName('a')->item(0)->getAttribute("href");
                $download = sprintf(self::GET_URL, str_replace("/torrent", '', $path));
                $size = $this->size_format($torrent->childNodes[2]->nodeValue);
                $datetime = "";
                $page = self::BASE_URL . $path;
                $hash = hash('sha256', $download);
                $seeds = intval($torrent->childNodes[4]->nodeValue);
                $leechs = intval($torrent->childNodes[6]->nodeValue);
                $category = "";
                $plugin->addResult($title, $download, $size, $datetime, $page, $hash, $seeds, $leechs, $category);
            }
        }
        return $count;
    }

    public function size_format($size)
    {
        $sizes = explode(' ', $size);
        return doubleval($sizes[0]) * self::SIZE_MAP[$sizes[1]];
    }
}

?>