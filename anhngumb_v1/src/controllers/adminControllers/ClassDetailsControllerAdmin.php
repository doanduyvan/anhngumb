<?php

namespace AdminControllers;

use Views\ViewLayout;

class ClassDetailsControllerAdmin
{
    private $classAccModel;

    function __construct()
    {
        $this->classAccModel = new \Models\ClassDetailModel();
    }

    function index()
    {
        $class = new ViewLayout();
        $class->setTitle('Danh sách học viên');
        $class->setActivePage(2);
        $class->addCSS('public/css/Admin/classAdmin.css');
        $class->addJS('public/js/Admin/classDetailsAdmin.js');
        $class->render();
    }
    public function getclassdetails() 
    {
        if (isset($_GET['classId'])) {
            $classId = intval($_GET['classId']);
            $students = $this->classAccModel->getClassDetails($classId);
            echo json_encode($students);
        } else {
            echo json_encode(['error' => 'Invalid classId']);
        }
    }
    public function deleteClass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $class = $this->classAccModel->deleteClassDetail($datareq);
            echo json_encode($class);
        }
    }

}
