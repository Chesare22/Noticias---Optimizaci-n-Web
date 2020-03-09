<?php
include 'Page.php';

$url = $_GET['url'];
$tag = $_GET['tag'];

getInfo($url, $tag);

function getInfo($url, $tag) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FILETIME, TRUE);
    $result = curl_exec($ch);
    $filetime = curl_getinfo($ch, CURLINFO_FILETIME);
    curl_close($ch);

    preg_match_all('(<'.$tag.'>(.*)</'.$tag.'>)siU', $result, $matches);
    $filetime = date('Y-m-d H:i:s', $filetime);
    
    $page = new Page($url, $matches, $filetime);

    echo json_encode($page->toArray());
}
?>