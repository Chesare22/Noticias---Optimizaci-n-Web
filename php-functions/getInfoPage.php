<?php
include 'Page.php';

$url = $_GET['url'];

getInfo($url, 1);

function getInfo($url, $deep) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FILETIME, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $page = curl_exec($ch);
    $filetime = curl_getinfo($ch, CURLINFO_FILETIME);
    curl_close($ch);

    $html = replaceJS($page);

    if($deep>0) {
        extractURLs($page, $deep);
    }

    $text = strip_tags($html);
    $text = preg_replace("/[\r\n|\n|\r|\t]+/", " ", $text);

    $filetime = date('Y-m-d H:i:s', $filetime);
    $page = new Page($url, $text, $filetime);

    echo json_encode($page->toArray());
}

function replaceJS($page) {
    $javascript = '/<script[^>]*?>.*?<\/script>/si';
    $page = preg_replace($javascript, '', $page);
    $javascript = '/<script[^>]*?javascript{1}[^>]*?>.*?<\/script>/si';
    $page = preg_replace($javascript, '', $page);
    return $page;
}

function extractURLs($page, $deep) {
    preg_match_all('(href="(.*)")siU', $page, $url);
    for($i=0; $i<count($url[1]); $i++) {
        getInfo($url[1][$i], $deep-1);
    }
}
?>