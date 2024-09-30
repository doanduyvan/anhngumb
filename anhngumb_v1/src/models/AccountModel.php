<?php
namespace Models;
class AccountModel extends BaseModel{
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
        // parent::__construct();
        // $this->table = 'accounts';

        $exampleDataExam = [
            'title' => 'English1.1',
            'idLesson' => 1,
            'QuestionCMS' => [
                [
                    'questionName' => 'What is your name?',
                    'typeAnswer' => 1,
                    'idQuizCMS' => 1,
                    'answersCMS' => [
                        [
                            'answerName' => 'my name is anh',
                            'isCorrect' => false,
                            'idQuestionCMS' => 1
                        ],
                        [
                            'answerName' => 'my name is anh',
                            'isCorrect' => false,
                            'idQuestionCMS' => 1
                        ]
                    ]
                ],
                [
                    'questionName' => 'who are you?',
                    'typeAnswer' => 2,
                    'idQuizCMS' => 2,
                    'answersCMS' => [
                        [
                            'answerName' => 'my name is anh',
                            'isCorrect' => false,
                            'idQuestionCMS' => 2
                        ],
                        [
                            'answerName' => 'my name is anh',
                            'isCorrect' => false,
                            'idQuestionCMS' => 2
                        ]
                    ]
                ]

            ]
        ];
    }
}