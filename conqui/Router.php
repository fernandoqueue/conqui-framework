<?php
namespace Conqui;


class Router 
{    
    public static $routes = [];
    private static $pathNotFound = [\App\Controller\ErrorController::class,'pathNotFound'];
    private static $methodNotAllowed = [\App\Controller\ErrorController::class,'methodNotAllowed'];
    //change this 
    public $method;
    public static $m;

    public $basepath;
    public $path_match_found = false; 
    public $route_match_found = false; 
    public function __construct($basepath = '/')
    {
        $this->basepath = $basepath;
        $this->registerRoutes();
    }

    private function registerRoutes(){
        include_once '../routes/web.php';
    }

    private static function addRoute($expression, $route, $method){
        
        array_push(self::$routes,[
          'expression' => $expression,
          'function' => $route,
          'method' => $method
        ]);
    }

    public static function __callStatic($name, $arguments){
        self::addRoute($arguments[0],$arguments[1],$name);
    }

    private function getPath(){
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri
        return $parsed_url['path'] ?? '/';
    }

    private function buildRegex($expression){
      //parameter matching 
      $pattern = '/({:[A-Za-z]+})/i';
      $expression = preg_replace($pattern, '([\D\d\s]+)', $expression);

      if($this->basepath!='' && $this->basepath!='/'){
        $expression = '('.$this->basepath.')'.$expression;
      }
      $expression = '#^'.$expression.'?$#';
      return $expression;
  
    }

    private function getArguments($arguments){
        array_shift($arguments);// Always remove first element. This contains the whole string
  
        if($this->basepath!=''&& $this->basepath!='/'){
          array_shift($arguments);// Remove basepath
        }

        foreach($arguments as $key => $argument){
          $data = filter_var($argument, FILTER_SANITIZE_URL);
          $data = htmlspecialchars($argument);
          $data = stripslashes($argument);
          $data = trim($argument);
          $arguments[$key] = $data;
        }

        return $arguments;
      }

    public function matchRoute($basepath = '/'){
        $this->$basepath = $basepath;
        $path = $this->getPath();
        // Get current request method
        $this->method = self::$m =  $_SERVER['REQUEST_METHOD'];
        foreach(self::$routes as $route){  
          $routeRegex = $this->buildRegex($route['expression']);
          //check expression match
          if(preg_match($routeRegex,$path,$matches)){
              $this->path_match_found = true; 
            // Check method match            
            if(strtolower($this->method) == strtolower($route['method'])){
              $arguments = $this->getArguments($matches);
              $this->route_match_found = true;
              break;
            }
          }
        }
          
        if($this->path_match_found && $this->route_match_found){
            return [$route['function'], $arguments];
        }else{
            return $this->path_match_found ? [self::$methodNotAllowed, [$path,$this->method]] : [self::$pathNotFound, [$path]];            
        }
      }
}