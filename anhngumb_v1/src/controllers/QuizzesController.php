<?php

namespace Controllers;

use Views\ViewLayout;

class QuizzesController
{
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
        $quiz->render();
    }

    // Các phương thức dành cho ajax

    function test()
    {

        // khi dữ liệu là một object
        $course = [
            'courseall' => [
                [
                    "id" => 1,
                    'coursesName' => 'anh van 1'
                ],
                [
                    "id" => 2,
                    'coursesName' => 'anh van2'
                ]
            ],
            'totalPages' => 5
        ];
    }
}
