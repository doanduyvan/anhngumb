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
            echo "Thêm khóa học thành công";
        } else {
            echo "Lỗi: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>