<?php

namespace Conqui;




class Gates
{

    private static $gates = [];

    public function __construct()
    {

    }


    public function define($title,$callbackfunction)
    {
        self::$gates[$title] = $callbackfunction;
    }

    public function allow($title, $params = null)
    {
        if(!isset(self::$gates[$title]))return false;

        return self::$gates[$title]( $params );

    }


}