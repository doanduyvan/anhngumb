<?php

namespace AdminControllers;

use Views\ViewLayout;

class LessonsControllerAdmin
{
    private $lessonModel;

    function __construct()
    {
        $this->lessonModel = new \Models\LessonModel();
    }

    function index()
    {
        $lesson = new ViewLayout('Đoàn Duy Vấn', 2);
        $lesson->setTitle('Danh sách khóa học');
        $lesson->setActivePage(7);
        $lesson->addCSS('public/css/Admin/lessonAdmin.css');
        $lesson->addJS('public/js/Admin/lessonAdmin.js');
        $lesson->render();
    }
    public function getlessons($currentPage = 1, $itemsPerPage = 20)
    {
        $lesson = $this->lessonModel->getLessons($itemsPerPage, $currentPage);
        echo json_encode($lesson);
    }
    public function addLesson()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $lesson = $this->lessonModel->addLesson($datareq);
            echo json_encode($lesson);
        }
    }
    public function editLesson()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $lesson = $this->lessonModel->editLesson($datareq);
            echo json_encode($lesson);
        }
    }

    public function deleteLesson()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datareq = json_decode(file_get_contents('php://input'), true);
            $lesson = $this->lessonModel->deleteLesson($datareq);
            echo json_encode($lesson);
        }
    }
}
