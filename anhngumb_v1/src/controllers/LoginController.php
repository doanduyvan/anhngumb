<?php

namespace Controllers;

use Cores\Authentication;
use Google\Service\ServiceControl\Auth;

class LoginController
{
    private $auth = null;
    private $accountModel = null;
    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $this->accountModel = new \Models\AccountModel();
            $this->auth = new Authentication();
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

    function signin($datareq) {

        $data = [
            'message' => 'test success'
        ];
        if(isset($_COOKIE)){
            $data['cookie'] = $_COOKIE;
        }else{
            $data['cookie'] = 'khong co cookie';
        }

        echo json_encode($data);
        return;
        $dataResModel = $this->accountModel->signinModel($datareq);
        if(isset($dataResModel['error'])){
            echo json_encode($dataResModel);
            return;
        }
        Authentication::setAccountSession($dataResModel);
        if(isset($datareq['rememberMe'])){
            $base46 = Authentication::encryption($dataResModel);
            setcookie('user_token_mb', $base46, time() + 3600*24*90, '/');
        }
        echo json_encode(['message' => 'Login success']);
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
