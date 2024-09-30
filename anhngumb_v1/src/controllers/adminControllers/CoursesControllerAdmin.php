<?php
namespace AdminControllers;
use Views\ViewLayout;
class CoursesControllerAdmin {

    function __construct()
    {
        
    }

    function index(){
        $course = new ViewLayout('Đoàn Duy Vấn',2);
        $course->setTitle('Danh sách khóa học');
        $course->setActivePage(2);
        $course->templatehtml = file_get_contents('public/temphtml/tempadmin/courseAdmin.html');
        $course->addCSS('public/css/Admin/courseAdmin.css');
        $course->addJS('public/js/Admin/courseadmin.js');
        $course->render();
    }

    function test2(){
        echo json_encode(['thong bao' => 'bajn da thanh cong']);
    }

    // Các phương thức dành cho ajax

    function addcourses(){
        // data demo 

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = json_decode(file_get_contents('php://input'),true);
            
            // $data = [
            //     'id' => 1,
            //     'num' => 5,
            //     'name' => 'tam',
            //     'text' => 'fdfd'
            // ];

            // $data['num'] = $data['num'] + 10;
            // $data['thongbao'] = "bajn da them thanh cong";
            // echo json_encode(['thong bao' => 'bajn da thanh cong']);
            // die();
            sleep(5);
        }


        sleep(7);
    }

    public function getcourses($page = 1)
    {
        $courses = $this->courseModel->getCourses();
        $courseArray = [];
        while ($course = $courses->fetch_assoc()) {
            $courseArray[] = $course;
        }
        echo json_encode($courseArray);
    }

}