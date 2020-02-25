<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'NewsDB';
$connection = null;

function getConnection() {
    try {
        $connection = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
    } catch (Exception $ex) {
        die('Connection failed:'.$ex->getMessage());
    return $connection;
}

function closeConnection() {
    $connection->closeConnection();
}
