<?php
namespace Cores;
use Google\Client;
class Authentication{
    private $id;
    private $name;
    private $role;
    private $priveKey = "123fdjfjdfdjfdjf";
    private $IdClient = "865532873608-aik1oar7v5gimbu4m84dcl2aj8me92ih.apps.googleusercontent.com";
    

    static function isLogin(){
        return isset($_SESSION['acc']) ? true : false;
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

    function encryption($arrAccount): string{
        $serialized = serialize($arrAccount);
        return base64_encode($serialized);
    }
    
    function decryption($arrAccount): array{
        $unserialized = unserialize(base64_decode($arrAccount));
        return $unserialized;
    }


}