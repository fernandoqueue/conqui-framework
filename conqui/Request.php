<?php

namespace Conqui;

/*
    $rules = [
        'name' => ['required','string','email','max:255'],
        'password'
    ];
*/

class Request
{
    public $request;
    public $filters;
    public $validated;
    
    public function __construct()
    {
        $this->filters = [
            'required' => function($name){
                return (isset($this->request[$name]) && $this->request[$name] != '' && !is_null($this->request[$name]));
            },
            'required:nullable' => function($name){
                return isset($this->request[$name]);
            },
            'email' => function($name = 'email'){
                filter_var($this->request[$name], FILTER_SANITIZE_EMAIL);
                return filter_var($this->request[$name],FILTER_VALIDATE_EMAIL);
            },
            'string' => function($name){
                $this->request[$name] = filter_var($this->request[$name], FILTER_SANITIZE_STRING);
                return true;
            },
            'integer' => function($name){
               return filter_var($this->request[$name], FILTER_VALIDATE_INT);
            },
        ];
        $this->request = $_POST;
    }

    public function __get($name){
        return isset($this->request[$name]) ? $this->request[$name] : null;
    }

    public function validate($validations, $throwOnFirstFail = false){
        $inputFailed = false;
        foreach($validations as $key => $rules){    
            foreach($rules as $rule){
                if(!$this->filters[$rule]($key)){
                    $inputFailed = true;
                    if($throwOnFirstFail){
                        throw new \Exception('validation.' . $rule);
                    }
                }
            }
            if(!$inputFailed){
                $this->validated[$key] = $this->request[$key];
            }
            $inputFailed = false;
        }
        return $this;
    }

    public function validated(){
        return $this->validated;
    }

    public function __set($name,$value){
        $this->request[$name] = $value;
    }

    public function processMiddleware($middlewares)
    {
        //CSRF token check
        if(in_array(\Conqui\Router::$m,['POST','PUT','DELETE','PATCH'])){
            if(!isset($this->request['token']) || !CSRF::check($this->request['token'])){
                return [(new \App\Controller\ErrorController),'exception',['Sorry, your session has expired. Please refresh and try again',419,'error/exception']];
            }
        }

        foreach($middlewares as $middleware){
            $this->request = (new $middleware)->handle($this->request);
        }
        return null; 
    }

    public function all()
    {
        return $this->request;
    }
}