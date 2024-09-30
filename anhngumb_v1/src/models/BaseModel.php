<?php
namespace Models;
use PDO;
class BaseModel{
    private $host;
    private $userName;
    private $password;
    private $databaseName;
    private $conn = null;

    function __construct()
    {
        $this->host = $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'];
        $this->userName = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->databaseName = $_ENV['DB_NAME'];
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->databaseName", $this->userName, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<h2 style="color:green">Connected successfully</h2>';
        }catch(\PDOException $e){
            echo "<h2 style='color:red'> Connection failed: " . $e->getMessage() . "</h2>";
            die();
        }
    }

    // Các phương thức query dữ liệu

    protected function all($table) {
        $sql = "SELECT * FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function findById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // các phương thức insert dữ liệu

    // protected function insert($table, $data) {
    //     $columns = implode(", ", array_keys($data));
    //     $placeholders = ':' . implode(", :", array_keys($data));
    //     $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    //     $stmt = $this->conn->prepare($sql);

    //     foreach ($data as $key => $value) {
    //         $stmt->bindValue(":$key", $value);
    //     }
    //     return $stmt->execute();
    // }

    // function orderBy($order = 'ASC'){
    //     return " ORDER BY id $order";
    // }

    // function all($table){
    //     $sql = "SELECT * FROM $table";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll();
    // }

    // function close()
    // {
    //     $this->db->close();
    // }

}