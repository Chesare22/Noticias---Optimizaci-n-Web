<?php
include 'News.php';

selectNews();

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
?>