<?php
include 'Page.php';

$temp = $_GET['json']; //recibe un objeto en json
$page = Page::toPage(json_decode($temp,TRUE));

insertPage($page);

function insertPage($page) {
    require './db.php';

    $query = $connection->prepare('INSERT INTO `webpage`(`url`, `text`, `date`) 
        VALUES (:url,:text,:date)');
    $query->bindParam(':url', $page->getURL());
    $query->bindParam(':text', $page->getText());
    $query->bindParam(':date', $page->getDate());
    $query->execute();
}
?>