<?php
namespace Conqui;

use App\Controller\ClosureController;
use Conqui\Router;
use Conqui\Session;
use Conqui\Authentication;
use Conqui\CSRF;
use Conqui\Request;
use App\Service\UserServiceProvider;
use Exception;
class Conqui {
    public $router;

    public function __construct(){
      $this->router = new Router(BASEPATH);
      $this->session = (new Session())->initialize();
      $this->auth = new Authentication;
      $this->request = new Request;
      $this->language = new Language;
      $this->gates = new Gates;
    }

    public function run(){
      $match = $this->router->matchRoute();
      [$arguments, $class, $method] = $this->parseMatch($match);
 
      CSRF::set();
         
      Authentication::$is_route_gaurded = $class->isAuthenticated;
      Authentication::$nonAuthenticatedRoutes = $class->nonAuthenticatedRoutes;
      Authentication::$currentRoute = $method;

      //set Authenticated user
      if(Authentication::check()){

        if(Authentication::$user) {

            $permissions = (new UserServiceProvider)->getPermissions(Authentication::$user->id);
            Authentication::$role = isset($permissions[0]) ? $permissions[0]->role : 'Guest';

            foreach($permissions as $permission){
              $this->gates->define($permission->title,fn()=>true);
            }
            
        }else{
          Authentication::logout();
        }

      }
      
      $error = $this->request->processMiddleware($class->middleware);
      
      if($error !== null){
        $class = $error[0];
        $method = $error[1];
        $arguments = $error[2];
      }

      $class->auth = $this->auth;
      $class->session = $this->session;
      $class->request = $this->request;
      $class->gates = $this->gates;

      $this->callFunction($arguments,$class,$method);

      Session::unset('error');
      Session::unset('success');
    }

    private function parseMatch($match){
      [$function, $arguments] = $match;
      [$class,$method] = is_array($function) 
                          ? [new $function[0], $function[1]] 
                          : [new ClosureController, $function];
                          
      return [$arguments, $class, $method];
    }

    private function callFunction($arguments,$class,$method){
      try{
        if($class instanceof ClosureController){
          call_user_func_array($method->bindTo($class,$class), $arguments);
        }else{
          call_user_func_array([$class,$method], $arguments);
        }
      }catch(\Exception $e){
      }
    }
}
