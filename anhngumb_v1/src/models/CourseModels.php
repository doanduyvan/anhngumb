<?php
namespace Models;
use Models\Database;
class CourseModels{
    private $mysqli;
    public function __construct() {
        $this->mysqli = Database::getInstance(); // Lấy kết nối từ Database
    }
    public function addCourse($courseName){
        if(empty($courseName)){
            return "Tên khóa học không được để trống.";
        }
        // Tạo câu truy vấn SQL để thêm khóa học
        $sql = "INSERT INTO courses (courseName) VALUES (?)";
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) {
            die("Lỗi khi chuẩn bị câu truy vấn: " . $this->mysqli->error);
        }

        $stmt->bind_param("s", $courseName);

        if ($stmt->execute()) {
            $courseId = $this->mysqli->insert_id; // Lấy ID của khóa học mới thêm
            $stmt->close();
            return $courseId;
        } else {
            $stmt->close();
            return false;
        }
        
    }
    public function getCourseById($courseId){
        $sql = "SELECT * FROM courses WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        if ($stmt === false) {
            die("Lỗi khi chuẩn bị câu truy vấn: " . $this->mysqli->error);
        }

        $stmt->bind_param("i", $courseId);
        $stmt->execute();
        $result = $stmt->get_result();
        $course = $result->fetch_assoc();
        $stmt->close();
        return $course;
    }
    public function getCourses(){
        
        $sql = "SELECT * FROM courses ORDER BY id DESC limit 5";
        $result = $this->mysqli->query($sql);
        if($result === false){
            return [];
        }
        return $result;
    }
}
?>