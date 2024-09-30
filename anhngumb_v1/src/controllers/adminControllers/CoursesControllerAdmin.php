<?php
namespace AdminControllers;
use Views\ViewLayout;
class CoursesControllerAdmin {


    function index(){
        $course = new ViewLayout('Đoàn Duy Vấn',2);
        $course->setTitle('Danh sách khóa học');
        $course->setActivePage(6);
        $course->templatehtml = file_get_contents('public/temphtml/tempadmin/courseAdmin.html');
        $course->render();
    }

    // Các phương thức dành cho ajax

    function getallcourses(){
        // data demo 
        $courses = [
            [
                'id' => 1,
                'courseName' => 'Lập trình PHP',
                'createdAt' => '2021-09-01',
            ],
            [
                'id' => 2,
                'courseName' => 'Lập trình Java',
                'createdAt' => '2021-09-01',
            ],
            [
                'id' => 3,
                'courseName' => 'Lập trình Python',
                'createdAt' => '2021-09-01',
            ],
            [
                'id' => 4,
                'courseName' => 'Lập trình C#',
                'createdAt' => '2021-09-01',
            ],
            [
                'id' => 5,
                'courseName' => 'Lập trình C++',
                'createdAt' => '2021-09-01',
            ]
        ];
        echo json_encode($courses);
    }

}