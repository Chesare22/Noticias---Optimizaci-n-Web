<?php
include_once 'Page.php';
include_once 'DB.php';

class PageDAO {
    private $db;
    private $url;
    private $text;
    private $date;

    public function __construct() {
        $this->db = new DB();
        $this->db->openConnection();
    }

    public function validatePage($page) {
        $this->url = $page->getURL();
        $this->text = $page->getText();
        $this->date = $page->getDate();

        $sql = 'SELECT url, date FROM webpage WHERE 1';
        $query = $this->db->getConnection()->prepare($sql);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();
        
        for($i = 0; $i < $count; $i++) {
            if( $this->compStrg($this->url, $results['url']) ) {
                if( !$this->compStrg($this->date, $results['date']) ) {
                    $this->updatePage();
                    return 'updated';
                }else {
                    return 'not updated';
                }
            }
            $results = $query->fetch(PDO::FETCH_ASSOC);
        }

        $this->insertPage();
        return 'created';
    }
    
    private function insertPage() {
        $sql = 'INSERT INTO `webpage`(`url`, `text`, `date`) VALUES (:url,:text,:date)';
        $query = $this->db->getConnection()->prepare($sql);
        
        $query->bindParam(':url', $this->url);
        $query->bindParam(':text', $this->text);
        $query->bindParam(':date', $this->date);
        $query->execute();
    }

    private function updatePage() {
        $sql = 'UPDATE `webpage` SET `text` = :text, `date` = :date WHERE `url` = :url';
        $query = $this->db->getConnection()->prepare($sql);

        $query->bindParam(':url', $this->url);
        $query->bindParam(':text', $this->text);
        $query->bindParam(':date', $this->date);
        $query->execute();
    }

    public function matchWord($word) {
        $sql = 'SELECT * FROM webpage WHERE MATCH(text) AGAINST (:word IN BOOLEAN MODE)';
        $query = $this->db->getConnection()->prepare($sql);
        $query->bindParam(':word', $word);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        $count = $query->rowCount();
        $list = array();
        echo $count;
    
        for($i = 0; $i < $count; $i++) {
            $page = new Page($results['url'], null, $results['date']);
            $list[$i] = $page->toArray();
            $results = $query->fetch(PDO::FETCH_ASSOC);
        }
        
        return $list;
    }
    
    private function compStrg($str1, $str2) {
        return (strcasecmp($str1, $str2) === 0);
    }
}
?>