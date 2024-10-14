<?php

namespace AdminControllers;

use Views\ViewLayout;

class AccessClassControllerAdmin
{
    private $classAccModel;

    function __construct()
    {
        $this->classAccModel = new \Models\AccessClassModel();
    }

    function index()
    {
        $class = new ViewLayout();
        $class->setTitle('Lớp truy cập');
        $class->setActivePage(2.3);
        $class->addCSS('public/css/Admin/classAdmin.css');
        $class->addJS('public/js/Admin/accessClassAdmin.js');
        $class->render();
    }
    public function getAccessStatuss() 
    {
        $dataResponse = $this->classAccModel->getAccessStatuss();
        echo json_encode($dataResponse);
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
