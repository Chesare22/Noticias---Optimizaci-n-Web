<?php
error_reporting(0);
require_once './simplepie/autoloader.php';

class News {
  public function __construct($link, $title, $author, $date, $description, $content) {
    $this->link = $link;
    $this->title = $title;
    $this->author = $author;
    $this->date = $date;
    $this->description = $description;
    $this->content = $content;
  }
}

$url = htmlspecialchars($_GET["url"]);
$feed = new SimplePie();
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
