<?php

namespace AdminControllers;

use Views\ViewLayout;

class ClassDetailsControllerAdmin
{
    private $classdetailModel;

    function __construct()
    {
        $this->classdetailModel = new \Models\ClassDetailModel();
    }

    function index()
    {
        $classdetail = new ViewLayout();
        $classdetail->setTitle('Danh sách khóa học');
        $classdetail->setActivePage(7);
        $classdetail->addCSS('public/css/Admin/classAdmin.css');
        $classdetail->addJS('public/js/Admin/classDetailsAdmin.js');
        $classdetail->render();
    }
    public function getclassdetails($currentPage = 1, $itemsPerPage = 20)
    {
        $classdetail = $this->classdetailModel->getClassDetails($itemsPerPage, $currentPage);
        echo json_encode($classdetail);
    }

    public function deleteClassDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $classdetail = $this->classdetailModel->deleteClassDetail($datareq);
            echo json_encode($classdetail);
        }
    }
}
