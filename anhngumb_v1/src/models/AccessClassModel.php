<?php

namespace Models;

class AccessClassModel
{

    private $conn = null;
    private $table = 'accounts_classes';

    public function __construct()
    {
        $this->conn = BaseModel::getInstance();
    }
    public function getAccountName($idAccounts)
    {
        $sql = "SELECT * FROM accounts where id = $idAccounts";
        $stmt = $this->conn->query($sql);
        $class = $stmt->fetch_all(MYSQLI_ASSOC);
        return $class;
    }
    public function getAccessStatuss()
    {
$sql = "select ac.idClasses, c.className, a.id as idStudent, a.fullName, a.createdAt from $this->table as ac 
inner join classes as c on c.id = ac.idClasses
inner join accounts as a on a.id = ac.idAccounts
where ac.statuss = 0;";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }


    public function getTotalClasses()
    {
        $totalItemsQuery = $this->conn->query("SELECT COUNT(*) as total FROM $this->table");
        $totalItems = $totalItemsQuery->fetch_assoc();
        return $totalItems['total'];
    }


    public function deleteClassDetail($dataRow)
    {
        $classDetailId = $dataRow['idAccounts'];
        $sql = "DELETE FROM $this->table WHERE idAccounts = $classDetailId";
        try {
            $this->conn->begin_transaction();
            $this->conn->query($sql);
            $this->conn->commit();
            return true;
        } catch (\Exception $e) {
            $this->conn->rollback();
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
