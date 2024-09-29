<?php
namespace Cores;
use AdminControllers\DashboardControllerAdmin;
use Models\CourseModels;
use mysqli;
class App{
    private $mysqli;
    private $courseModels;
    function __construct($controller,$action,$params = [],$role)
    {
        $this->mysqli = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
        if ($this->mysqli->connect_error) {
            die("Kết nối thất bại: " . $this->mysqli->connect_error);
        }
        $this->courseModels = new CourseModels($this->mysqli);
        $controller = ucfirst($controller).'Controller';
        $nameSpace = '';
        if($role == 1 || $role == 2){
            $nameSpace = 'AdminControllers\\'.$controller . 'Admin';
        }else{
            $nameSpace = 'Controllers\\'.$controller;
        }
        $this->run($nameSpace,$action,$params);
    }

    function run($nameSpace,$action,$params = []){
        try{
            if(!class_exists($nameSpace)){
                throw new \Exception('Không tìm thấy class');
            }
            if(!method_exists($nameSpace,$action)){
                throw new \Exception('Không tìm thấy action');
            }
            $controllerInstance = new $nameSpace($this->courseModels);
            call_user_func_array([$controllerInstance, $action], $params);
        }catch(\Exception $e){
            echo "<h1 style = 'text-align: center; color: red; margin-top: 30px'>Lỗi chưa xác định, vui lòng liên hệ admin</h1>";
            echo "<h3 style = 'text-align: center; color: blue; margin-top: 30px'>".$e->getMessage()."</h3>";
        }
    }
}