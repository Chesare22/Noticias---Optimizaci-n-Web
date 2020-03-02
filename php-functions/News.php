<?php
class News{
    private $title;
    private $author;
    private $date;
    private $description;
    
    public function __construct($title, $author, $date, $description) {
        $this->title = $title;
        $this->author = $author;
        $this->date = $date;
        $this->description = $description;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getAuthor() {
        return $this->author;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function toArray() {
        return $array = array(
            "Title: " => $this->getTitle(),
            "Author: " => $this->getAuthor(),
            "Date: " => $this->getDate(),
            "Description: " => $this->getDescription()
        );
    }
}