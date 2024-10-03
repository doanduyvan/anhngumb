<?php
namespace Cores;
use Google\Client;
class Authentication{
    private $id;
    private $name;
    private $role;
    private $priveKey = "123fdjfjdfdjfdjf";
    private $IdClient = "865532873608-aik1oar7v5gimbu4m84dcl2aj8me92ih.apps.googleusercontent.com";
    


    static function setAccountSession($arrAccount){
        $_SESSION['acc'] = $arrAccount;
        // return [
        //     'id' => $row['id'],
        //     'fullName' => $row['fullName'],
        //     'roles' => $row['roles'],
        //     'statuss' => $row['statuss']
        // ];
    }

    static function isLoginSession(): bool {
        return isset($_SESSION['acc']) ? true : false;
    }

    static function isLoginCookie(): bool {
        if(isset($_COOKIE['user_token_mb'])){
            $token = $_COOKIE['user_token_mb'];
            $userData = self::decryption($token);
            if($userData){
                self::setAccountSession($userData);
                return true;
            }
            return false;
        }
        return false;
    }

    static function getRole(){
        return isset($_SESSION['acc']['role']) ? $_SESSION['acc']['role'] : null;
    }


    function verifyIdTokenGoogle($idToken) {
        try{
        $client = new Client([ $idToken => $this->IdClient]); // Thay bằng client ID của bạn
        $payload = $client->verifyIdToken($idToken);
        }catch(\Exception $e){
            return false;
        }
        if ($payload) {
            // ID Token hợp lệ, xử lý thông tin người dùng
            $userId = $payload['sub']; // ID người dùng Google
            $email = $payload['email']; // Email của người dùng
            $verifiedEmail = $payload['email_verified']; // Xác thực email
            return $payload; // Trả về thông tin người dùng
        } else {
            // ID Token không hợp lệ
            return false;
        }
    }



    function autoLogin(){
        // kiểm tra token được gửi từ header của người dùng có tồn tại hay không và có hợp lệ hay không
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
           $token = $headers['Authorization'];
           $userData = $this->verifyToken($token);
           if($userData){
            //    $_SESSION['acc'] = $userData;
               return true;
           }
        }
    }

    private function verifyToken($token){
        $token = base64_decode($token);
        $token = json_decode($token,true);
        if(isset($token['id']) && isset($token['name']) && isset($token['role'])){
            return true;
        }
        return false;
    }


    static function test(){
        $headers = getallheaders();
        $token = $headers['Authorization'];
        print_r($token);

        $ss = [
            'id' => 1,
            'name' => 'admin',
            'role' => 'admin'
        ];

        //role 0: students, 1: instructor, 2: admin
    }

    static function encryption($arrAccount): string{
        $serialized = serialize($arrAccount);
        return base64_encode($serialized);
    }
    
    static function decryption($stringAccount): array | false{
        $decoded = base64_decode($stringAccount, true); // true để trả về false nếu chuỗi không hợp lệ
        if ($decoded === false) {
            return false; // Nếu không thể giải mã base64, trả về false
        }
        // Giải nén từ serialized
        $unserialized = @unserialize($decoded); // Dùng @ để ngăn thông báo lỗi
        if ($unserialized === false && $decoded !== 'b:0;') { // Kiểm tra nếu unserialize không thành công
            return false; // Nếu không thể giải nén, trả về false
        }
        return $unserialized; // Trả về mảng đã giải nén
    }


}