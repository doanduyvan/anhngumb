<?php

namespace Models;

class ClassDetailModel
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
    public function getClassDetails($classId)
    {
        $classId = $this->conn->real_escape_string($classId);
        $sql = "select ac.idClasses, c.className, a.id as idStudent, a.fullName, a.createdAt from accounts_classes as ac 
        inner join classes as c on c.id = ac.idClasses
        inner join accounts as a on a.id = ac.idAccounts
        where ac.idClasses = $classId AND ac.statuss = 1";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }


    public function getClassesById($classId)
    {
        $classId = $this->conn->real_escape_string($classId);
        $sql = "SELECT * FROM $this->table WHERE id = $classId";
        $stmt = $this->conn->query($sql);
        $course = $stmt->fetch_assoc();
        return $course;
    }

    public function getTotalClasses()
    {
        $totalItemsQuery = $this->conn->query("SELECT COUNT(*) as total FROM $this->table");
        $totalItems = $totalItemsQuery->fetch_assoc();
        return $totalItems['total'];
    }

    public function addClass($dataRow)
    {
        $className = $dataRow['className'];
        $idCourses = $dataRow['courseId'];
        $className = $this->conn->real_escape_string($className);
        $idCourses = $this->conn->real_escape_string($idCourses);
        $sql = "INSERT INTO $this->table (className, statuss, idCourses) VALUES ('$className', 1,'$idCourses')";
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
