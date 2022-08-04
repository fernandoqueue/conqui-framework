<?php

namespace Conqui;

use Conqui\Session;

class CSRF {

/* CSRF Protection for ajax requests */
public static function set($name = 'token', $regenerate = false) {

    $token =  md5(time() . rand());

    if(!Session::get($name)) {
        Session::set($name,$token);
    } else {
        if($regenerate) 
            Session::set($name,$token);
    }

}

public static function preSessionCSRF()
{
    Session::startSession();
    self::set();
}

public static function get($name = 'token') {

    return Session::get($name) ?? false;

}

public static function get_url_query($name = 'token') {

    return '&token=' . self::get($name);

}

public static function check($token, $name='token') {
    return ($token == self::get($name));
}

}