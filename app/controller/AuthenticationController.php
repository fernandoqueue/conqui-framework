<?php

namespace App\Controller;

use Conqui\Authentication;
use Conqui\Response;
use Conqui\CSRF;
use Conqui\URL;
use Conqui\Language;
use App\Service\UserServiceProvider;
use Exception;
class AuthenticationController extends Controller
{
    public function __construct()
    {

    }

    public function login()
    {
        CSRF::preSessionCSRF();
        return (new Response)->view('home/login','layout/app')->render();
    }

    public function register()
    {
        return (new Response)->view('home/register','layout/app')->render();
    }

    public function registerUser()
    {
        $userService = new UserServiceProvider();
        
        try{

            $data = $this->request->validate([
                'first_name' => ['required','string'],
                'last_name' => ['required:nullable','string'],
                'email' => ['required','email'],
                'password' => ['required'],
            ],true)->validated();

            $userService->create($data);

            return (new Response)->redirectWithMessage(URL::route('/'),['success', 'User created was a success!']);

        }catch(\Exception $e){

            $message = (isset($e->errorInfo) && $e->errorInfo[1] == 1062)
                        ? Language::translation('registration.fail.duplicate')
                        : Language::translation('registration.fail.other');
                        
            return (new Response)->redirectWithMessage(URL::route('register'),['error', $message]);
        }
    }

    public function authenticate()
    {   
        $userService = new UserServiceProvider();
        try{
            $data = $this->request->validate([
                'email' => ['required','email'],
                'password' => ['required'],
            ],true)->validated();

            if(!$userService->loginUser($data)) throw new Exception;

            CSRF::set('token',true);    
            return (new Response)->redirectWithMessage(URL::route('/'),['success', Language::translation('login.success')]);

        }catch(\Exception $e){
            return (new Response)->redirectWithMessage(URL::route('login'),['error', Language::translation('login.fail')]);
        }
    }

    public function logout()
    {
        Authentication::logout();
        return (new Response)->redirect(URL::route('login'));
    }
}