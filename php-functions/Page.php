<?php
class Page {
    private $url;
    private $title;
    private $text;
    private $date;

    public function __construct($url, $title, $text, $date) {
        $this->url = $url;
        $this->title = $title;
        $this->text = $text;
        $this->date = $date;
    }

    public function getURL() {
        return $this->url;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getText() {
        return $this->text;
    }

    public function getDate() {
        return $this->date;
    }
    
    public function toArray() {
        return array(
            'URL' => $this->url,
            'Title' => $this->title,
            'Text' => $this->text,
            'Date' => $this->date
        );
    }
}
?>