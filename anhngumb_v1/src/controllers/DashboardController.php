<?php
namespace Controllers;
class DashboardController
{
    public function index()
    {
        $dashboard = new \Views\ViewLayout('Đoàn Duy Vấn',1);
        $dashboard->setTitle('Dashboard - AnhnguMB');
        $dashboard->setActivePage(1);
        $dashboard->render();
        
    }

    // method for ajax

    public function getDashboardData()
    {

        $data = [
            'total' => 100,
            'new' => 10,
            'active' => 20,
            'inactive' => 30,
            'blocked' => 40
        ];
        sleep(5);
        echo json_encode($data);
    }
}