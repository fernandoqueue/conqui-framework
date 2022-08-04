<?php

namespace Conqui\Traits;

trait SingletonTrait
{
    private static $instance = null;

    public static function getInstance()
    {
      if(!self::$instance)
      {
        $className = get_called_class();
        self::$instance = new $className();
      }
     
      return self::$instance;
    }
    public function __call($name, $arguments)
    {
      if (in_array($method, ['increment', 'decrement', 'callThis'])) {
        return $this->$method(...$parameters);
    }

    return $this->newQuery()->$method(...$parameters);
    }

    public static function __callStatic($name, $arguments)
    {

      return (new static)->$name(...$arguments);
      
    //  // print_r($name);
    //   // if(!self::$instance)
    //   // {
    //   //   $className = get_called_class();
    //   //   self::$instance = new $className();
    //   // }

    //   // return self::$instance->$name($arguments);
    }

}