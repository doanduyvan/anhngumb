<?php

namespace AdminControllers;

use Views\ViewLayout;

class ClassesControllerAdmin
{
    private $classModel;

    function __construct()
    {
        $this->classModel = new \Models\classModel();
    }

    function index()
    {
        $class = new ViewLayout();
        $class->setTitle('Danh sách khóa học');
        $class->setActivePage(2);
        $class->addCSS('public/css/Admin/classAdmin.css');
        $class->addJS('public/js/Admin/classAdmin.js');
        $class->render();
    }
    public function tets(){
        $class = new ViewLayout();
        $class->render();
    }
    public function getclasses($currentPage = 1, $itemsPerPage = 20)
    {
        $class = $this->classModel->getClasses($itemsPerPage, $currentPage);
        echo json_encode($class);
    }
    public function addClass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $class = $this->classModel->addClass($datareq);
            echo json_encode($class);
        }
    }
    public function editCLass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $class = $this->classModel->editCLass($datareq);
            echo json_encode($class);
        }
    }

    public function deleteClass()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $class = $this->classModel->deleteClass($datareq);
            echo json_encode($class);
        }
    }
}
