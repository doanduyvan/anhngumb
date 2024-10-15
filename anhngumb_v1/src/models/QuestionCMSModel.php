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
            } else if ($typeAnswer == 1) {
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


    function getQuestionByIdQuiz($idQuizCMS)
    {
        $sql = "select que.id as idQuestion,
        que.questionName,
        que.typeAnswers as type,
        ans.id as idAnswer,
        ans.answerName,
        ans.isCorrect
        from questionscms as que
        inner join answerscms as ans on ans.idQuestionsCMS = que.id
        where que.idQuizzesCMS = $idQuizCMS";
        $stmt = $this->conn->query($sql);
        $questions = $stmt->fetch_all(MYSQLI_ASSOC);

        $result = [];

        foreach ($questions as $item) {

            $idQuestion = $item['idQuestion'];

            // Kiểm tra xem câu hỏi đã tồn tại trong kết quả chưa
            if (!isset($result[$idQuestion])) {
                $result[$idQuestion] = [
                    'id' => $idQuestion,
                    'questionName' => $item['questionName'],
                    'typeAnswers' => $item['type'],
                    'answersCMS' => []
                ];
            }

            // Thêm đáp án vào câu hỏi
            if ($item['type'] == 0) {
                // Nếu type = 0, thêm mảng 2 chiều
                $result[$idQuestion]['answersCMS'][] = [
                    'id' => $item['idAnswer'],
                    'isCorrect' => $item['isCorrect'] == 1 ? true : false,
                    'answerName' => $item['answerName']
                ];
            } else {
                // Nếu type = 1, thêm đáp án duy nhất
                $result[$idQuestion]['answersCMS'] = [
                    'idAnswer' => $item['idAnswer'],
                    'isCorrect' => $item['isCorrect'] == 1 ? true : false,
                    'answerName' => $item['answerName']
                ];
            }
        }

        // Chuyển đổi mảng kết quả thành mảng chỉ số (index array)
        $result = array_values($result);

        return $result;
    }
}
