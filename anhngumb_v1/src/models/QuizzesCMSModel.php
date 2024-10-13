<?php
namespace Models;
class QuizzesCMSModel{
    private $table = 'quizzesCMS';
    private $conn = null;
    private $fullPathAudio = '';
    function __construct()
    {
        $this->conn = BaseModel::getInstance();
    }

    public function addQuiz($dataRow){
        $idLesson = $dataRow['idLesson'];
        $quizName = $dataRow['quizName'];
        $media = $dataRow['media'];
        $questions = $dataRow['questions'];

        $quizName = $this->conn->real_escape_string($quizName);

        $sql = "INSERT INTO $this->table (title, idLessons) VALUES ('$quizName', $idLesson)";
        try {
            $this->conn->begin_transaction();
            $this->conn->query($sql);

            $newQuizId = $this->conn->insert_id;
            if($media !== null){
                $mediaModel = new MediaCMSModel();
                $saveMedia = $mediaModel->addMedia($newQuizId,$media);
                if(isset($saveMedia['error'])){
                    throw new \Exception($saveMedia['error']);
                }else{
                    $this->fullPathAudio = $saveMedia;
                }
            }
            $questionModel = new QuestionCMSModel();
            foreach ($questions as $question) {
                $saveQuestion = $questionModel->addQuestion($newQuizId, $question);
                if (isset($saveQuestion['error'])) {
                    throw new \Exception($saveQuestion['error']);
                }
            }
            $this->conn->commit();
            return ['message' => 'Add quiz success'];
        } catch (\Exception $e) {
            $this->conn->rollback();
            if(file_exists($this->fullPathAudio)){
                unlink($this->fullPathAudio);
            }
            return [
                'error' => $e->getMessage()
            ];
        }

    }

    public function getQuizByIdLesson($idUser,$idClass,$idLesson){
        $idLesson = $this->conn->real_escape_string($idLesson);
        $sql = "select cl.className, cl.id as idClass, le.lessonName, le.id as idLesson, qu.title as quizName , qu.id as idQuiz, re.score from quizzescms as qu
        inner join lessons as le on le.id = qu.idLessons
        inner join courses as co on co.id = le.idCourses
        inner join classes as cl on co.id = cl.idCourses
        inner join accounts_classes as ac on ac.idClasses = cl.id
        left join resultscms as re on re.idQuizzesCMS = qu.id
        where ac.idAccounts = $idUser and cl.id = $idClass and qu.idLessons = $idLesson";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    
    public function getQuestionByIdQuiz($idUser,$idClass, $idLesson, $idQuiz)
    {

        $idClass = $this->conn->real_escape_string($idClass);
        $idLesson = $this->conn->real_escape_string($idLesson);
        $idQuiz = $this->conn->real_escape_string($idQuiz);
        try{
                $sql = "select
                cla.id as idClass,
                cla.className,
                les.id as idLesson,
                les.lessonName,
                qui.id as idQuiz,
                qui.title as quizName	
                from quizzescms as qui
                inner join lessons as les on les.id = qui.idLessons
                inner join courses as cou on cou.id = les.idCourses
                inner join classes as cla on cla.idCourses = cou.id
                inner join accounts_classes as ac on ac.idClasses = cla.id
                where qui.id = $idQuiz and les.id = $idLesson and cla.id = $idClass and ac.idAccounts = $idUser";

            $stmt = $this->conn->query($sql);
            $quizzes = $stmt->fetch_assoc();
            if($quizzes === null){
                return [
                    'error' => 'Quiz not found'
                ];
            }
            $sql = "select m.title, m.type, m.content from mediacms as m where idQuizzesCMS = $idQuiz";
            $stmt = $this->conn->query($sql);
            $media = $stmt->fetch_assoc();
            $quizzes['mediaCMS'] = $media;
            $scoreLesson = $this->getPercentScoreLesson($idUser,$idClass,$idLesson);
            $quizzes['scoreUnit'] = $scoreLesson;
            $questionModel = new QuestionCMSModel();
            $questions = $questionModel->getQuestionByIdQuiz($idQuiz);
            $quizzes['questionsCMS'] = $questions;

            return $quizzes;

        }catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    function getPercentScoreLesson($idUser,$idClass,$idLesson){

        // lấy tổng số câu hỏi của bài học
        $sql = "select count(qui.id) as totalQuiz from quizzescms as qui where qui.idLessons = $idLesson";
        $stmt = $this->conn->query($sql);
        $totalQuiz = $stmt->fetch_assoc()['totalQuiz'];
        if($totalQuiz === 0){
            return 0;
        }
        // lấy toàn bộ điểm của bài học
        $sql = "select sum(res.score) as totalScore from resultscms as res 
        inner join quizzescms as qui on qui.id = res.idQuizzesCMS
        inner join lessons as les on les.id = qui.idLessons
        where res.idAccounts = $idUser and res.idClasses = $idClass and les.id = $idLesson";
        $stmt = $this->conn->query($sql);
        $totalScore = $stmt->fetch_assoc()['totalScore'];
        if($totalScore === null || $totalScore === 0){
            return 0;
        }
        $percent = round(($totalScore / ($totalQuiz * 10)) * 100,2);
        return $percent;
    }
}