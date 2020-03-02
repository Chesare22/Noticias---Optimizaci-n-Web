<?php
require './db.php';
include 'News.php';

$temp = $_GET['list']; // recibe la lista de noticias a cargar a la db

$list = json_decode($temp);

for($i=0; $i<count($list); $i++) {
    $news = json_decode($list[$i]);
    insertNews($news);
}

function insertNews($news) {
    $query = $connection->prepare('INSERT INTO `notice`(`title`, `author`, `date`, `description`) 
        VALUES (:title,:author,:date,:description)');

    $query->bindParam(':title', $news->getTitle());
    $query->bindParam(':author', $news->getAuthor());
    $query->bindParam(':date', $news->getDate());
    $query->bindParam(':description', $news->getDescription());
    $query->execute();
}

?>