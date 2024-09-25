<?php
namespace AdminControllers;

class DashboardControllerAdmin{

    function index(){
        $dashboard = new \Views\ViewLayout(); 
        $dashboard->setTitle('day la trang dashboard');
        $dashboard->setRole('ngọc tam',2);
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

    function concuadashboar(){
        echo 'day la trang con cua  dashboard';
    }

    // Dưới đây là các phương thức dành cho JSON API


    function getcourse(){

        $course = [
            [
                'id' => 1,
                'name' => 'Lập trình PHP',
                'description' => 'Học lập trình PHP cơ bản',
                'price' => 1000000
            ],
            [
                'id' => 1,
                'name' => 'Lập trình java',
                'description' => 'Học lập trình PHP cơ bản',
                'price' => 1000000
            ],
            [
                'id' => 1,
                'name' => 'Lập trình python',
                'description' => 'Học lập trình PHP cơ bản',
                'price' => 1000000
            ],
        ];
        echo json_encode($course);
    }



}