<?php

namespace Cores;

use Config\Routers;
use Cores\Authentication;
class Router
{

    private $controler = 'dashboard';
    private $action = 'index';
    private $params = [];

    function __construct()
    {
        $arrUrl = $this->UrlProcess();
        if (isset($arrUrl[0]) && $arrUrl[0] == 'admin') {
            $this->controler = isset($arrUrl[1]) ? $arrUrl[1] : $this->controler;
            $this->action = isset($arrUrl[2]) ? $arrUrl[2] : $this->action;
            $this->params = $this->handlParams($arrUrl, 3);
            $this->handlAdmin();
        } else {
            $this->controler = isset($arrUrl[0]) ? $arrUrl[0] : $this->controler;
            $this->action = isset($arrUrl[1]) ? $arrUrl[1] : $this->action;
            $this->params = $this->handlParams($arrUrl, 2);
            $this->hanldUser();
        }
    }


    function hanldUser() {
        $auth = new Authentication();
        if(!$this->isRouters()) {
            $this->render404();
        }
        if(Authentication::isLogin()){
            // echo "da login";
        new \Cores\App($this->controler, $this->action, $this->params, 1);
        }else{
           $Clogin = new \Controllers\LoginController();
        }

    }

    function handlAdmin()
    {
        new \Cores\App($this->controler, $this->action, $this->params, 1);
    }

    function handlParams($arrUrl, $num)
    {
        if (!isset($arrUrl[$num])) {
            return [];
        }
        $respon = [];
        foreach ($arrUrl as $index => $item) {
            if ($index < $num) {
                unset($arrUrl[$index]);
            } else {
                array_push($respon, $item);
            }
        }
        return $respon;
    }

    function render404()
    {
        include_once Routers::URL404;
        die();
    }

    function isRouters($isAdmin = false)
    {
        $routers = $isAdmin ? Routers::routersAdmin() : Routers::routersUser();
        if (array_key_exists($this->controler, $routers)) {
            if (in_array($this->action, $routers[$this->controler])) {
                return true;
            }
            return false;
        }
        return false;
    }

    function UrlProcess()
    {
        if (isset($_GET['url'])) {
            $url = strtolower($_GET['url']);
            return explode("/", trim(trim($url, " "), "/"));
        }
    }
}
