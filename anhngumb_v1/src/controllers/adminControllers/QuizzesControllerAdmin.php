<?php
namespace AdminControllers;
class QuizzesControllerAdmin{

    private $quizView;
    private $quizModel;

    function __construct()
    {
        $this->quizView = new \Views\ViewLayout();
        $this->quizModel = new \Models\QuizzesCMSModel();
    }

    function index(){
        $this->quizView->setTitle('Quizzes Amin');
        $this->quizView->setActivePage(9);
        $this->quizView->templatehtml = file_get_contents('public/temphtml/tempadmin/addquizadmin.html');
        $this->quizView->render();
    }

    // các hàm xử lý ajax


    function getCourses(){
        $courses = new \Models\CourseModel();
        $courses = $courses->getAllCourses();
        echo json_encode($courses);
    }

    function getLessonByCourseId($idCourse){
        $lessons = new \Models\LessonModel();
        $lessons = $lessons->getLessonByCourseId($idCourse);
        echo json_encode($lessons);
    }

    function addQuiz(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $dataReq = json_decode(file_get_contents('php://input'), true);
            $dataRes = $this->quizModel->addQuiz($dataReq);
            echo json_encode($dataRes);
        }
    }
}