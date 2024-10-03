<?php

namespace Controllers;

use Cores\Authentication;

class LoginController
{
    private $auth = null;
    private $accountModel = null;
    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->accountModel = new \Models\AccountModel();
            if(isset($_GET['signin'])){
                $this->signin($data);
                return;
            }
            if(isset($_GET['signup'])){
                $this->signup($data);
                return;
            }
            if(isset($_GET['signinGoogle'])){
                $this->signinGoogle($data);
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

    function signin($data) {
        array_push($data, "day la sign in thanh cong");
        echo json_encode($data);
    }

    function signup($data) {
        $datares = $this->accountModel->addAccount($data);
        echo json_encode($datares);
    }

    function signinGoogle($data) {
        // $auth = new Authentication();
        // $token = $data['idToken'];
        // $payload = $auth->verifyIdTokenGoogle($data['idToken']);
        // if ($payload) {
        //     $_SESSION['acc'] = $payload;
        //     echo json_encode($payload);
        // } else {
        //     echo json_encode(['error' => 'idToken khong hop le']);
        // }
        array_push($data, ['test' => 'day la sign in google thanh cong']);
        echo json_encode($data);
    }

}
