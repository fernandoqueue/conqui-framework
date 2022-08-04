<?php

namespace App\Controller;

class Controller {
    public $session;
    public $auth;
    public $request;
    public $isAuthenticated = false;
    public $nonAuthenticatedRoutes = [];
    public $middleware = [];
}