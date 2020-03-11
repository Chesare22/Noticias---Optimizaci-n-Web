<?php
include 'Page.php';

$temp = $_GET['page'];
$page = Page::toPage(json_decode($temp, TRUE));

updatePage($page);

function updatePage($page) {
    require './db.php';

    $query = $connection->prepare('UPDATE `webpage` SET `text` = :text, `date` = :date 
        WHERE `url` = :url');
    $query->bindParam(':url', $page->getURL());
    $query->bindParam(':text', $page->getText());
    $query->bindParam(':date', $page->getDate());
    $query->execute();
}
?>