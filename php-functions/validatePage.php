<?php
include 'Page.php';

$temp = $_GET['json']; //recibe un objeto en json
$page = Page::toPage(json_decode($temp,TRUE));

validateURL($page);

function validateURL($page) {
    require './db.php';

    $query = $connection->prepare('SELECT url, date FROM webpage WHERE 1');
    $query->execute();
    $results = $query->fetch(PDO::FETCH_ASSOC);
    $count = $query->rowCount();

    for($i=0; $i<$count; $i++) {
        if(compStrg($page->getURL(), $results['url'])) {
            if(!compStrg($page->getDate(), $results['date'])) {
                return json_encode($page->toArray());
            }
        }
        $results = $query->fetch(PDO::FETCH_ASSOC);
    }
}

function compStrg($str1, $str2) {
    return (strcasecmp($str1, $str2) == 0);
}
?>