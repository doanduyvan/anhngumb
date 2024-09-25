<?php
namespace Models;
use Models\Database;
class BaseModels{
    private $db;
    private $conn;
    private 
    function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConn();
    }

    function orderBy($order = 'ASC'){
        return " ORDER BY id $order";
    }

    function all($table){
        $sql = "SELECT * FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function close()
    {
        $this->db->close();
    }

}