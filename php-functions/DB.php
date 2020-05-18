<?php
class DB {
    private $server = 'localhost';
    private $database = 'oawdb';
    private $username = 'root';
    private $password = '';
    private $connection;

    public function __construct() {
        $this->connection = null;
    }

    public function openConnection() {
        try {
            $this->connection = new PDO( "mysql:host=$this->server;dbname=$this->database;charset=utf8mb4",
            $this->username, $this->password);
        } catch (Exception $ex) {
            die('Connection failed:'.$ex->getMessage());
        }
    }

    public function closeConnection() {
        $this->connection->close();
    }

    public function getConnection() {
        return $this->connection;
    }

}
?>
