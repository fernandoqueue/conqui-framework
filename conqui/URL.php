<?php

namespace Conqui;


class URL
{
    private static $urlRoot = URL_ROOT;

    public function route($route)
    {
        $route =  trim($route, '/');
        return self::$urlRoot . $route;
    }
}