<?php
class Page{ 
    private $url;
    private $text;
    private $date;

    public function __construct($url, $text, $date) {
        $this->url = $url;
        $this->text = $text;
        $this->date = $date;
    }

    public function getURL() {
        return $this->url;
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
            'Text' => $this->text,
            'Date' => $this->date
        );
    }

    public static function toPage($stdClass) {
        return new Page(
            $stdClass->URL,
            $stdClass->Text,
            $stdClass->Date,
        );
    }
}
?>