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

    
}