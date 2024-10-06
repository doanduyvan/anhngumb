<?php
namespace AdminControllers;
class QuizzesControllerAdmin{

    private $quizView;

    function __construct()
    {
        $this->quizView = new \Views\ViewLayout();
    }

    function index(){
        $this->quizView->setTitle('Quizzes Amin');
        $this->quizView->setActivePage(9);
        $this->quizView->templatehtml = file_get_contents('public/temphtml/tempadmin/addquizadmin.html');
        $this->quizView->render();
    }
}