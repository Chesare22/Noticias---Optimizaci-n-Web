<?php
error_reporting(0);
require_once './simplepie/autoloader.php';
include 'News.php';

$url = htmlspecialchars($_GET["url"]);
$feed = new SimplePie();

switch ($_GET['option']) {
    case 'url':
        if(!existURL($url)) {
            infoNews($url, $feed);
        }
        break;
    case 'selectNews':
        selectNews();
        break;
    case 'searchNews':
        matchNews($_GET['word']);
        break;
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

function matchNews($word) {
    require './db.php';
    
    $query = $connection->prepare('SELECT * FROM notice MATCH word = :word');
    $query->bindParam(':word', $word);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $news = new News($results['title'], $results['author'], $results['date'], $results['description']);
    
    echo json_encode($news->toArray());
}

function insertNews($news) {
    require './db.php';

    $query = $connection->prepare('INSERT INTO `notice`(`title`, `author`, `date`, `description`) 
        VALUES (:title,:author,:date,:description)');

    $query->bindParam(':title', $news->getTitle());
    $query->bindParam(':author', $news->getAuthor());
    $query->bindParam(':date', $news->getDate());
    $query->bindParam(':description', $news->getDescription());
    $query->execute();
}

function selectNews() {
    require './db.php';
    
    $query = $connection->prepare('SELECT * FROM notice WHERE 1');
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $count = $query->rowCount();
    
    for($i=0; $i<$count; $i++) {
        $news = new News($results['title'], $results['author'], $results['date'], $results['description']);
        $list[$i] = json_encode($news->toArray());
        $results = $query->fetch(PDO::FETCH_ASSOC);
    }

    echo json_encode($list);
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
        
        insertNews($news);
    }
}
?>