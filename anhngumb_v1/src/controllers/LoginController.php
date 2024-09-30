<?php

namespace Controllers;

use Cores\Authentication;

class LoginController
{

    function __construct()
    {
        // if (Authentication::isLogin()) {
        //     header('Location:' . WEB_ROOT);
        //     return;
        // }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($_GET['signin'])) {
                if(isset($_GET['google'])){
                    $this->signinGoogle($data);
                    return;
                }
                $this->signin($data);
                return;
            }
            if (isset($_GET['signup'])) {
                $this->signup($data);
                return;
            }
            return;
        }
        $this->index();
    }

    function index()
    {
        $login = new \Views\viewsAuth\ViewLogin();
        $login->setTitle("Login - Anh ngữ MB");
        $login->addCSS("public/css/login.css");
        $login->addJS("public/js/login.js");
        $login->render();
    }

    function signup($data) {
        array_push($data, ['test' => 'ok thanh cong']);
        echo json_encode($data);
    }

    function signin($data) {
        array_push($data, "day la sign in thanh cong");
        echo json_encode($data);
    }



    function signinGoogle($data) {

        $auth = new Authentication();
        $token = $data['idToken'];
        $payload = $auth->verifyIdTokenGoogle($data['idToken']);
        if ($payload) {
            $_SESSION['acc'] = $payload;
            echo json_encode($payload);
        } else {
            echo json_encode(['error' => 'idToken khong hop le']);
        }
    }

    function handlAcc(){
        
    }
}
