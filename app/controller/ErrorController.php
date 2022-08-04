<?php

namespace App\Controller;

use Conqui\Response;

class ErrorController extends Controller
{
    public function __construct()
    {   

    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function pathNotFound($path)
    {
        echo 'Page ' . $path .' not found';
    }
    public function methodNotAllowed($path, $method)
    {
        echo 'Method '. $method . ' not allowed';
    }

    public function exception($message,$statusCode,$view)
    {
        http_response_code($statusCode);
        return (new Response)->view($view,'layout/exception')->with(compact('message'))->render();
    }
    
} 