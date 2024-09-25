<?php
namespace AdminControllers;
use Views\ViewLayout;
class CoursesControllerAdmin {
    private $role = 2;
    private $page = 'Course';

    function index(){
        $layout = new ViewLayout();
        $layout->setRole('thay mb', $this->role);
        $layout->setPage($this->page);
        $layout->setTitle('Courses - anh ngu mb');
        $layout->addCSS('public/css/style.css');
        $layout->addCSS('public/css/course.css');
        $layout->addJS('public/js/main.js');
        $layout->addJS('public/js/course.js');
        $layout->render();

    }

}