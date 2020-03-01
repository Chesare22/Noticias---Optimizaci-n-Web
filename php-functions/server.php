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
    case 'getNews':
        getNews();
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
    
    echo json_encode(new News($results['title'], $results['author'], $results['date'], $results['description'], $results['content']));
}

function insertNews($news) {
    require './db.php';

    $query = $connection->prepare('INSERT INTO `notice`(`title`, `author`, `date`, `description`, `content`) 
        VALUES (:title,:author,:dates,:descriptions,:content)');

    $query->bindParam(':title', $news->getTitle());
    $query->bindParam(':author', $news->getAuthor());
    $query->bindParam(':dates', $news->getDate());
    $query->bindParam(':descriptions', $news->getDescription());
    $query->bindParam(':content', $news->getContent());
    echo $news->getDate();
    $query->execute();
}

function selectNews() {
    require './db.php';
    
    $query = $connection->prepare('SELECT * FROM notice WHERE 1');
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $count = $query->rowCount();
    $list = array();
    
    for($i=0; $i<$count; $i++) {
        $list[$i] = json_encode(new News($results['title'], $results['author'], $results['date'], $results['description'], $results['content']) );
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
        $content = $item->get_content(true);
        $news = new News($title,$author,$date,$description,$content);
        
        insertNews($news);
    }
}