<?php

namespace AdminControllers;

use Models\Database;
use Models\CourseModels;

class DashboardControllerAdmin
{

    private $courseModel;

    public function __construct(CourseModels $courseModel)
    {
        $this->courseModel = $courseModel;
    }


    function index()
    {
        $dashboard = new \Views\ViewLayout();
        $dashboard->setTitle('day la trang dashboard');
        $dashboard->setRole('ngọc tam', 2);
        $dashboard->setPage(('Dashboard'));

        // set CSS 
        $dashboard->addCSS('public/css/style.css');
        $dashboard->addCSS('public/css/dashboard.css');
        $dashboard->addCSS('public/css/course.css');
        // set js 
        $dashboard->addJS('public/js/main.js');
        $dashboard->addJS('public/js/dashboard.js');
        $dashboard->render();
    }

    function concuadashboar()
    {
        echo 'day la trang con cua dashboard';
    }


    public function addcourse()
    {
        if (isset($_POST['courseName'])) {
            $courseName = $_POST['courseName'];
            $result = $this->courseModel->addCourse($courseName);
            if ($result) {
                // Giả sử phương thức addCourse trả về thông tin khóa học mới thêm
                $newCourse = $this->courseModel->getCourseById($result); // Lấy thông tin khóa học mới thêm
                echo json_encode(['success' => true, 'message' => 'Thêm dữ liệu khóa học thành công', 'course' => $newCourse]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thêm được khóa học']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Không có dữ liệu khóa học']);
        }
    }

    public function getcourses()
    {
        $courses = $this->courseModel->getCourses();
        $courseArray = [];
        while ($course = $courses->fetch_assoc()) {
            $courseArray[] = $course;
        }
        echo json_encode($courseArray);
    }
}
