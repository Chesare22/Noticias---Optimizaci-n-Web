<?php

class News{
    private $title;
    private $author;
    private $date;
    private $description;
    private $content;
    
    public function __construct($title, $author, $date, $description, $content) {
        $this->title = $title;
        $this->author = $author;
        $this->date = $date;
        $this->description = $description;
        $this->content = $content;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function getAuthor() {
        return $this->Author;
    }
    
    public function getDate() {
        return $this->date;
    }
    
    public function getDescription() {
        return $this->$description;
    }
    
    public function getContent() {
        return $this->content;
    }
}