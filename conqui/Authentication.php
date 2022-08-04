<?php

namespace Conqui;

use App\Service\UserServiceProvider;

class Authentication
{
    public static $is_logged_in = null;
    public static $user_id = null;
    public static $user = null;
    public static $role = null;
    public static $is_route_gaurded = false;
    public static $nonAuthenticatedRoutes = null;
    public static $currentRoute = '';

    public function __construct()
    {

    }

    public function authenticate($username, $password){
        if(!$user = (new UserServiceProvider())->usersWhere(['email' => $username])[0])return false;
        if(!password_verify($password, $user->password))return false;
        self::loginUser($user);
        return true;
    }

    public function setAuthRoutes($guarded, $nonAuthenticatedRoutes = null)
    {
        self::$is_route_gaurded = $guarded;
        self::$nonAuthenticatedRoutes = $nonAuthenticatedRoutes;
    }   

    public function isLoggedIn()
    {
        return (self::$is_logged_in || self::$user_id || self::$user );
    }

    public function loginUser($user)
    {
        self::$is_logged_in = true;
        self::$user_id = $user->id;
        self::$user = $user;

        Session::set('user_id', $user->id);
        Session::set('user_password_hash', md5($user->password));

    }


    public function check()
    {
        //Check if logged in
        if(self::$is_logged_in) {
            return true;
        }
        //TODO: Add cache check

        //check from session
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && $user = (new UserServiceProvider())->userById($_SESSION['user_id'])){
            if(isset($_SESSION['user_password_hash']) && $_SESSION['user_password_hash'] == md5($user->password)) {
                self::$is_logged_in = true;
                self::$user_id = $user->id;

                self::$user = $user;

                return true;
            }
        }

        return false;
    }

    public function logout()
    {
        Session::destroy();
    }
}