<?php

namespace Controllers;

use Views\ViewLayout;

class QuizzesController
{
    private $userName;
    private $role;
    private $quizModel;
    function __construct()
    {
        // $this->quizModel = new \Models\QuizModel();
    }

    function index()
    {
        $quiz = new ViewLayout('Đoàn Duy Vấn', 0);
        $quiz->setTitle('Quizzes - Anh Ngữ MB');
        $quiz->setActivePage(5);
        $quiz->templatehtml = file_get_contents('public/temphtml/tempUser/quiz.html');
        // $quiz->addCSS('public/css/Users/Quiz.css');
        // $quiz->addJS('public/js/Users/Quiz.js');
        $quiz->render();
    }

    // Các phương thức dành cho ajax


}
