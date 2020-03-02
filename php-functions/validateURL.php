<?php
require_once './simplepie/autoloader.php';
include 'News.php';

$url = htmlspecialchars($_GET["url"]);
$feed = new SimplePie();

if(!existURL($url)) {
    infoNews($url, $feed);
}

function existURL($url) {
    $file = fopen('urls.txt', 'a+');
    
    while($line = fgets($file)) {
        if ($url == $line) {
            return true;
        }
    }
    fputs($file, $url);
    fclose($file);
    
    return false;
}

function infoNews($url, $feed) {
    $feed->set_feed_url($url);
    $feed->init();
    $itemQry = $feed->get_item_quantity();
    
    for ($i = 0; $i < $itemQry; $i++) {
        $item = $feed->get_item($i);
        $title = $item->get_title();
        $author = $item->get_author()->get_name();
        $date = $item->get_date('Y-m-d H:i:s');
        $description = $item->get_description();
        $news = new News($title,$author,$date,$description);
        
        $list[$i] = json_encode($news->toArray());
    }

    echo json_encode($list);
}
?>