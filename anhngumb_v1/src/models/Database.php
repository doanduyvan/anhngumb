<?php
namespace Models;
use PDO;
class Database{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $database = 'mvc';
    private $conn = null;
    function __construct()
    {
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(\PDOException $e){
            echo "<h2 style='color:red'> Connection failed: " . $e->getMessage() . "</h2>";
            die();
        }
    }

    function getConn(){
        return $this->conn;
    }

    function close()
    {
        $this->conn = null;
    }
}