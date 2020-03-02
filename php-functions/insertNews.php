<?php
include 'News.php';

$temp = $_GET['list']; //recibe un arreglo en json
$list = json_decode($temp, true);

for($i=0; $i<count($list); $i++) {
    $news = News::toNews(json_decode($list[$i]));
    insertNews($news);
}

function insertNews($news) {
    require './db.php';

    $query = $connection->prepare('INSERT INTO `notice`(`title`, `author`, `date`, `description`) 
        VALUES (:title,:author,:date,:description)');
    $query->bindParam(':title', $title);
    $query->bindParam(':author', $news->getAuthor());
    $query->bindParam(':date', $news->getDate());
    $query->bindParam(':description', $news->getDescription());
    $query->execute();
}
?>