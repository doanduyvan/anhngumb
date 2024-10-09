<?php

namespace Models;

class QuestionCMSModel
{
    private $table = 'questionsCMS';
    private $conn = null;
    function __construct()
    {
        $this->conn = BaseModel::getInstance();
    }

    public function addQuestion($idQuizCMS, $dataRow)
    {
        $questionName = $dataRow['questionName'];
        $typeAnswer = $dataRow['typeAnswers'];
        $answers = $dataRow['answers'];

        $questionName = $this->conn->real_escape_string($questionName);
        
        $sql = "INSERT INTO $this->table (questionName, typeAnswers, idQuizzesCMS) VALUES ('$questionName', $typeAnswer, $idQuizCMS)";
        try {

            if (!$this->conn->query($sql)) {
                throw new \Exception("Failed to insert question: " . $this->conn->error);
            }

            $newQuestionId = $this->conn->insert_id;
            $answerModel = new AnswersCMSModel();
            if ($typeAnswer == 0) {
                foreach ($answers as $answer) {
                    $saveAnswer = $answerModel->addAnswer($newQuestionId, $answer);
                    if (isset($saveAnswer['error'])) {
                        throw new \Exception($saveAnswer['error']);
                    }
                }
            }
            else if($typeAnswer == 1){
                $saveAnswer = $answerModel->addAnswer($newQuestionId, $answers);
                if (isset($saveAnswer['error'])) {
                    throw new \Exception($saveAnswer['error']);
                }
            }
            return ['message' => 'Add question success'];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
