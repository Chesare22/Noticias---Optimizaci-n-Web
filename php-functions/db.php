<?php
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'newsdb';

try {
    $connection = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (Exception $ex) {
    die('Connection failed:'.$ex->getMessage());
}