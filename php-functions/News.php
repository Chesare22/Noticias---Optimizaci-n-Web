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

    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }
    
    public function getDate() {
        return $this->date;
    }

    public function setDate($date) {
        $this->date = $date;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function toArray() {
        return $array = array(
            'Title' => $this->getTitle(),
            'Author' => $this->getAuthor(),
            'Date' => $this->getDate(),
            'Description' => $this->getDescription()
        );
    }

    public static function toNews($stdClass) {
        return new News(
            $stdClass->Title,
            $stdClass->Author,
            $stdClass->Date,
            $stdClass->Description
        );
    }
}