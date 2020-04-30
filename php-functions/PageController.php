<?php
include_once 'PageModel.php';
header('Content-Type: application/json');

$pageController = new PageController();

if( isset($_GET['url']) ) {
    $pageController->setPage($_GET['url']);
}else if($_GET['word']){
    $pageController->matchWord($_GET['word']);
}

class PageController {
    private $pageModel;

    public function __construct() {
        $this->pageModel = new PageModel();
    }

    public function setPage($url) {
        $response = $this->pageModel->loadURL($url, 1);

        echo json_encode($response);
    }

    public function matchWord($word) {
        $response = $this->pageModel->matchWordOnURL($word);

        echo json_encode($response);
    }
}
?>