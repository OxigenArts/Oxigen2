<?php 
/**
 * Oxigen Class
 * Core class
 */
namespace App;

use Core\Loader;

class Oxigen
{
  private $appName,$appVersion;
  function __construct($appName,$appVersion = null)
  {
    $this->loader = new Loader($this);
    $this->appName = $appName;
    $this->appVersion = $appVersion;
    $this->loadedModules = [];
  }

  function __destruct(){

  }

  public function init() {
    $this->loader->loadCore();
  }



  public function regModule($module){
      $name = $module->name;
      $this->{$name} = $module;
      $this->loadedModules[$name] = "loaded";
  }
  
}

?>
