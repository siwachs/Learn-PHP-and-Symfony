<?php
class Database
{
    private $connection;

    public function __construct()
    {
        require_once("./config.php");
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE;
            $this->connection = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
