<?php

namespace Models;

class AccountModel
{
    private $conn = null;
    private $table = 'accounts';

    public function __construct()
    {
        $this->conn = BaseModel::getInstance();
    }

    public function getLinkImgModel($id){
        $sql = "SELECT avatar FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        return $row['avatar'];
    }

    public function getAccountByEmail($email){
        $sql = "SELECT * FROM $this->table WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        // kiểm tra xem tài khoản có tồn tại hay Không
        if ($result->num_rows == 0) {
            return null;
        }
        $row = $result->fetch_assoc();
        $status = $row['statuss'];
        if ($status == 2) {
            return [
                'error' => 'Account is locked'
            ];
        }
        if ($status == 0) {
            return [
                'error' => 'Account is not activated'
            ];
        }
        return [
            'id' => $row['id'],
            'fullName' => $row['fullName'],
            'roles' => $row['roles'],
            'statuss' => $row['statuss']
        ];
    }

    public function signinGoogleModel($dataRow){
        $emaiReq = $dataRow['email'];
        $infoAccount = $this->getAccountByEmail($emaiReq);
        if($infoAccount){
            return $infoAccount;
        }
        $passGenerate = $this->generatePassword();
        $dataRow['password'] = $passGenerate;
        $addAcount = $this->addAccount($dataRow);
        if(isset($addAcount['error'])){
            return $addAcount;
        }
        $infoAccount = $this->getAccountByEmail($emaiReq);
        return $infoAccount;
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
        $status = $row['statuss'];
        if ($status == 2) {
            return [
                'error' => 'Account is locked'
            ];
        }
        if ($status == 0) {
            return [
                'error' => 'Account is not activated'
            ];
        }
        return [
            'id' => $row['id'],
            'fullName' => $row['fullName'],
            'roles' => $row['roles']
        ];
    }


    public function addAccount($dataRow)
    {
        $fullName = $dataRow['fullName'];
        $email = $dataRow['email'];
        $pass = $dataRow['password'];
        $avatar = isset($dataRow['avatar']) ? $dataRow['avatar'] : null; 
        $roles = 0;
        $statuss = 0;
        $sql = "INSERT INTO $this->table (fullName, email, pass, roles, statuss, avatar) VALUES (?, ?, ?, ?, ?, ?)";
        try {
            $this->conn->begin_transaction();
            // $this->conn->query($sql);
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sssiis', $fullName, $email, $pass, $roles, $statuss, $avatar);
            $stmt->execute();
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

    public function generatePassword($length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
