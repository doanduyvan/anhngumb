<?php
namespace Models;
class AccountModel{
    private $conn = null;
    private $id;
    private $name;
    private $role;
    private $priveKey;
    private $data = [
        'fullName' => null,
        'email' => null,
        'pass' => null,
        'roles' => null,
        'statuss' => 0,
    ];

    public function __construct()
    {
        $this->conn = BaseModel::getInstance();
        $sql = "select * from accounts";
        
        $result = $this->conn->query($sql);
        $data = $result->fetch_all(MYSQLI_ASSOC);

        echo "<pre>";
        print_r($data);
        echo "</pre>";

        // $datatemp = [
        //     'title' => 'kiem tra giua ki',
        //     'idlesson' => 1,
        //     'QuestionCMS' => [
        //         'questionName' => 'Câu hỏi 1',
        //         'typeAnswer' => 1,
        //         'answers' => [
        //             ''
        //         ]
        //     ]
        // ]

    }

}