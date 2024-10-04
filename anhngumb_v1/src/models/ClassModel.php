<?php
namespace Models;
class ClassModel{

    private $conn = null;
    private $table = 'classes';

    public function __construct()
    {
        $this->conn = BaseModel::getInstance();
    }

    public function getClasses($itemsPerPage, $currentPage)
    {
        $offset = ($currentPage - 1) * $itemsPerPage;
        $totalClasses = $this->getTotalClasses();
        $totalPages = ceil($totalClasses / $itemsPerPage);
        $sql = "SELECT * FROM $this->table ORDER BY id DESC LIMIT $itemsPerPage OFFSET $offset";
        $stmt = $this->conn->query($sql);
        $classes = $stmt->fetch_all(MYSQLI_ASSOC);
        return [
            'Classes' => $classes,
            'totalPages' => $totalPages
        ];
    }

    public function getClassesById($classId){
        $sql = "SELECT * FROM $this->table WHERE id = $classId";
        $stmt = $this->conn->query($sql);
        $course = $stmt->fetch_assoc();
        return $course;
    }

    public function getTotalClasses(){
        $totalItemsQuery = $this->conn->query("SELECT COUNT(*) as total FROM $this->table");
        $totalItems = $totalItemsQuery->fetch_assoc();
        return $totalItems['total'];
    }

    public function addClass($dataRow){
        $className = $dataRow['className'];
        $startDate = $dataRow['startDate'];
        $idCourses = $dataRow['courseId'];

        // tính toán ngày kết thúc 3 tháng sau ngày bắt đầu
        $date = new \DateTime($startDate);
        $date->modify('+ 3 months');
        $endDate = $date->format('Y-m-d'); // chuyển định dạng thành yyyy-mm-dd
        $sql = "INSERT INTO $this->table (className, startDate, endDate, idCourses) VALUES ('$className', '$startDate', '$endDate','$idCourses')";
        try {
            $this->conn->begin_transaction();
            $this->conn->query($sql);
            $newClassId = $this->conn->insert_id;
            $newClass = $this->getClassesById($newClassId);
            $this->conn->commit();
            return $newClass;
        } catch (\Exception $e) {
            $this->conn->rollback();
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function editClass($dataRow){
        $classId = $dataRow['id'];
        $className = $dataRow['className'];
        $sql = "UPDATE $this->table SET className = '$className'  WHERE id = $classId";
        try {
            $this->conn->begin_transaction();
            $this->conn->query($sql);
            $newClass = $this->getClassesById($classId);
            $this->conn->commit();
            return $newClass;
        } catch (\Exception $e) {
            $this->conn->rollback();
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function deleteClass($dataRow){
        $classId = $dataRow['id'];
        $sql = "DELETE FROM $this->table WHERE id = $classId";
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