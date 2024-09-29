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
        echo 'day la trang con cua  dashboard';
    }


    public function addcourse()
    {
        if (isset($_POST['courseName'])) {
            $courseName = $_POST['courseName'];
            $result = $this->courseModel->addCourse($courseName);
            echo $result;
        } else {
            echo "Không có dữ liệu khóa học để thêm.";
        }
    }
}
