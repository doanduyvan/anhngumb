<?php
namespace AdminControllers;
class QuizzesControllerAdmin{

    private $quizView;

    function __construct()
    {
        $this->quizView = new \Views\ViewLayout('Đoàn Duy Vấn',2);
    }

    function index(){
        
    }
}