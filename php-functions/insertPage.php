<?php
include 'News.php';

$temp = $_GET['json']; //recibe un objeto en json
$page = Page::toPage(json_decode($temp,TRUE));
insertDB($page);

function insertDB($page) {
    require './db.php';

    $query = $connection->prepare('INSERT INTO `webpage`(`url`, `text`, `date`) 
        VALUES (:title,:text,:date)');
    $query->bindParam(':title', $page->getURL());
    $query->bindParam(':author', $page->getText());
    $query->bindParam(':date', $page->getDate());
    $query->execute();
}
?>