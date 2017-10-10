<?php
/**
 * Oxigen Class
 * Core class
 */
class Oxigen //esta clase no hereda de ninguna no?
{
  private $appName,$appVersion;
  function __construct(String $appName,$appVersion = null)
  {
    $this->appName = $appName;
    $this->appVersion = $appVersion;
  }
  function __destruct(){

  }
  public function regModule($module){
      $name = $module->name;
      $this->{$name} = $module;
  }
  
}

?>
