<?php

namespace App\Middleware;

use Conqui\Authentication;
use Conqui\Response;
class Auth
{
    public function handle($request)
    {
        if(Authentication::$is_route_gaurded){
            if( !Authentication::check()){
                (new Response)->redirect(Response::$loginPage);
            }
        }

        return $request;
    }
}