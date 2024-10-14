<?php
namespace Controllers;
class ClassesController
{
    private $layout = null;

    public function __construct()
    {
        $this->layout = new \Views\ViewLayout();
    }

    public function index()
    {
        $this->layout->setTitle('Classes');
        $this->layout->setActivePage(2);
        $this->layout->templatehtml = file_get_contents('public/temphtml/tempUser/joinclass.html');
        $this->layout->render();
    }
}