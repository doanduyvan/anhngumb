<?php
namespace Models;
class ClassDetailModel{
    private $conn = null;
    private $table = 'accounts_classes';

    public function __construct()
    {
        $this->conn = BaseModel::getInstance();
    }

    public function getClassDetails($itemsPerPage, $currentPage)
    {
        $offset = ($currentPage - 1) * $itemsPerPage;
        $totalLessons = $this->gettotalAcc();
        $totalPages = ceil($totalLessons / $itemsPerPage);
        $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT $itemsPerPage OFFSET $offset";
        $stmt = $this->conn->query($sql);
        $lessons = $stmt->fetch_all(MYSQLI_ASSOC);
        return [
            'accounts_classes' => $lessons,
            'totalPages' => $totalPages
        ];
    }

    public function gettotalAcc(){
        $totalItemsQuery = $this->conn->query("SELECT COUNT(*) as total FROM $this->table");
        $totalItems = $totalItemsQuery->fetch_assoc();
        return $totalItems['total'];
    }


    public function deleteClassDetail($dataRow){
        $accounts_classeId = $dataRow['id'];
        $sql = "DELETE FROM $this->table WHERE id = $accounts_classeId";
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