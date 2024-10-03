<?php
namespace Models;
class AccountModel{
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


    public function addAccount($dataRow){
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