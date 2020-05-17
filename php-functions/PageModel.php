<?php
include_once 'PageDAO.php';
include_once 'Page.php';

class PageModel {
    private $pageDAO;
    private $urls;

    public function __construct() {
        $this->pageDAO = new PageDAO();
        date_default_timezone_set("America/Mexico_City");
    }

    public function loadURL($url, $deep) {
        $this->urls = array();
        $this->extractInfo($url, $deep);

        return $this->urls;
    }

    private function extractInfo($url, $deep) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $page = curl_exec($ch);
        curl_close($ch);

        $html = $this->replaceJS($page);
        $title = $this->extractTitle($html);
    
        if($deep > 0) {
            $this->extractURLs($page, $deep);
        }
    
        $text = $this->replaceHTML($html);
        $date = $this->extractDate($url);
        $page = new Page($url, $title, $text, $date);
        $message = $this->pageDAO->validatePage($page);
        
        array_push($this->urls, [$url => $message]);
    }
    
    private function replaceJS($page) {
        $javascript = '/<script[^>]*?>.*?<\/script>/si';
        $page = preg_replace($javascript, '', $page);
        $javascript = '/<script[^>]*?javascript{1}[^>]*?>.*?<\/script>/si';
        $page = preg_replace($javascript, '', $page);

        return $page;
    }

    private function replaceHTML($html) {
        $text = strip_tags($html);
        $text = preg_replace("/[\r\n|\n|\r|\t]+/", " ", $text);

        return $text;
    }
    
    private function extractURLs($page, $deep) {
        preg_match_all('(https://(.*)")siU', $page, $keyURL);

        for($i = 0; $i < count($keyURL[1]); $i++) {
            if(!array_key_exists($keyURL[1][$i], $this->urls) ) {
                $this->extractInfo('https://'.$keyURL[1][$i], $deep-1);
            }
        }
    }

    private function extractDate($url) {
        $headers = get_headers($url, 1);

        if( isset($headers['Last-Modified']) ) {
            $date = $headers['Last-Modified'];
        }else {
            $date = date ('Y-m-d', time());
        }

        return $date;
    }

    private function extractTitle($html) {
        preg_match('/<title>([^<]+)</', $html, $title);
		return isset($title[1]) ? $title[1] : false;
    }

    public function matchWordOnURL($word) {
        $response = $this->pageDAO->matchWord($word);

        return $response;
    }
}
?>