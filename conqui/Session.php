<?php
namespace Conqui;

class Session
{
  
  public function __construct()
  {

  }

  public function initialize()
  {
    $this->startSession(true);
    return $this;
  }

  public function startSession($onlyIfExists = false)
  {
    if (session_id() == '')
    {
      if ($onlyIfExists && !isset($_COOKIE[session_name()]))
        return;
      @session_start([
        // 'name' => 'nnnn',
      ]);
    }
  }

  public function set($id, $value)
  {
    self::startSession();
    $_SESSION[$id] = $value;
  }

  public function unset($key){
    unset($_SESSION[$key]);
  }

  public function get($id)
  {
      self::startSession(true);
      if (isset($_SESSION) && array_key_exists($id, $_SESSION))
        return $_SESSION[$id];
      else return NULL;
  }

  public function getAll()
  {
    return $_SESSION;
  }

  public function destroy()
  {
    session_unset();
    session_destroy();
  }
}