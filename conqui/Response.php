<?php

namespace Conqui;

use Conqui\Session;

class Response
{
    private $viewName;
    private $layout;
    private $args = null;

    public static $loginPage = '/conqui/public/login';
    
    public function __construct()
    {

    }
    public function view($name,$layout)
    {
        $this->viewName = $name;
        $this->layout = $layout;
        return $this;
    }
    public function with($args)
    {
        $this->args = $args;
        return $this;
    }
    public function render()
    {
        if($this->args != null)extract($this->args);
        
        if(file_exists('../views/'.$this->layout.'.php')){
            require_once '../views/'.$this->layout.'.php';
        } else{
            die('views does not exist');
        }
    }

    public function redirectWithMessage($location,$data){
        Session::set($data[0],$data[1]);
        $this->redirect($location,302);
    }

    public function json($data)
    {
        header('Content-type: application/json');
        echo json_encode( $data );
    }
    public function redirect($url, $statusCode = 303)
    {   
       header('Location: ' . $url, true, $statusCode);
       die();
    }
}