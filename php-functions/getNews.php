<?php
error_reporting(0);
require_once './simplepie/autoloader.php';
include 'News.php';

$url = htmlspecialchars($_GET["url"]);
$feed = new SimplePie();

if()

function existURL($url) {
    $file = fopen('urls.txt', 'a+');
    
    while($line = fgets($file)) {
        if ($url === $line) {
            return true;
        }
    }
    fputs($file, $url);
    fclose($file);
    
    return false;
}

function matchNews($word) {
    require './php-functions/db.php';
    
    $query = $connection->prepare('SELECT * FROM notice MATCH word = :word');
    $query->bindParam(':word', $word);
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode(new News($results['title'], $results['author'], $results['date'], $results['description'], $results['content']));
}

function insertNews($news) {
    require './php-functions/db.php';
    
    $query = $connection->prepare('INSERT * FROM notice WHERE title = :title, author = :author, date = :date, description = :description, content = :content');
    $query->bindParam(':title', $news->getTitle());
    $query->bindParam(':author', $news->getAuthor());
    $query->bindParam(':date', $news->getDate());
    $query->bindParam(':description', $news->getDescription());
    $query->bindParam(':content', $news->getContent());
    $query->execute();
}

$feed->set_feed_url($url);

$feed->init();
$item = $feed->get_item(0);
$link = $item->get_link();
$title = $item->get_title();
$author = $item->get_author()->get_name();
$date = $item->get_date('Y-m-d H:i:s');
$description = $item->get_description();
$content = $item->get_content(true);

echo json_encode(new News($link, $title, $author, $date, $description, $content));
