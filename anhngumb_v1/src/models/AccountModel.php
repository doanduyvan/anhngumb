<?php

namespace Models;

class AccountModel
{
    private $conn = null;
    private $table = 'accounts';
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
    }

    public function signinModel($data)
    {
        $email = $data['email'];
        $pass = $data['password'];
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return [
                'error' => 'Email does not exist'
            ];
        }
        $row = $result->fetch_assoc();
        if ($row['pass'] != $pass) {
            return [
                'error' => 'Password is incorrect'
            ];
        }
        return [
            'id' => $row['id'],
            'fullName' => $row['fullName'],
            'roles' => $row['roles'],
            'statuss' => $row['statuss']
        ];
    }


    public function addAccount($dataRow)
    {
        $fullName = $dataRow['fullName'];
        $email = $dataRow['email'];
        $pass = $dataRow['password'];
        $roles = 0;
        $statuss = 0;
        $sql = "INSERT INTO $this->table (fullName, email, pass, roles, statuss) VALUES ('$fullName', '$email', '$pass', $roles, $statuss)";
        try {
            $this->conn->begin_transaction();
            $this->conn->query($sql);
            $this->conn->commit();
            return [
                'message' => 'Account registration successful'
            ];
        } catch (\Exception $e) {
            $this->conn->rollback();
            if ($e->getCode() == 1062) {  // 1062 là mã lỗi MySQL cho Duplicate entry
                return [
                    'error' => 'Email already exists'
                ];
            } else {
                return [
                    'error' => 'Database error: ' . $e->getMessage()
                ];
            }
        }
    }
}
