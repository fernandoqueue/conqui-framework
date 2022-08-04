<?php

namespace Conqui;


class Language
{
    public static $l;

    public function __construct()
    {
        self::$l = require_once('../language/en/language.php');
    }

    public function translation($key)
    {
        return self::$l[$key];
    }

}