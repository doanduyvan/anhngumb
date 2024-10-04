<?php
namespace Controllers;
class DashboardController
{
    public function index()
    {
        $dashboard = new \Views\ViewLayout();
        $dashboard->setTitle('Dashboard - AnhnguMB');
        $dashboard->setActivePage(1);
        // $dashboard->addCSS('public/css/dashboard.css');
        // $dashboard->addJS('public/js/dashboard.js');
        $dashboard->render();
        
    }

    public function dashboar1(){
        $dashboard = new \Views\ViewLayout('Đoàn Duy Vấn',0);
        $dashboard->setTitle('Dashboard - AnhnguMB');
        $dashboard->setActivePage(1);
        $dashboard->render();
    }

    // method for ajax

    public function getDashboardData()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Đoàn Duy Vấn',
                'age' => 20,
            ],
            [
                'id' => 2,
                'name' => 'Nguyễn Văn A',
                'age' => 21,
            ],
            [
                'id' => 3,
                'name' => 'Nguyễn Văn B',
                'age' => 22,
            ],
            [
                'id' => 4,
                'name' => 'Nguyễn Văn C',
                'age' => 23,
            ],
            [
                'id' => 5,
                'name' => 'Nguyễn Văn D',
                'age' => 24,
            ],
        ];
        sleep(5);
        echo json_encode($data);
    }
}