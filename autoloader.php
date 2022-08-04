<?php
class autoloader
{
    protected $directories = array();

    private function loadClass($class)
    {
        if($class[0] == '\\')
        {
            $class = substr($class, 1);
        }
        $class = str_replace(['\\','_'], '/', $class).'.php';

        $path = __DIR__ . '/'.$class;
        if(file_exists($path))
        {
            require_once $path; 
            return true;                
        }
        
    }

    public function register()
    {
        spl_autoload_extensions('php');
        spl_autoload_register([$this,'loadClass']);

    }
}
